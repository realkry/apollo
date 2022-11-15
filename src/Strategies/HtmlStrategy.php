<?php

namespace Metapp\Apollo\Strategies;


use Exception;
use League\Route\Http\Exception as HttpException;
use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnauthorizedException;
use League\Route\Route;
use League\Route\Strategy\ApplicationStrategy;
use Metapp\Apollo\Logger\Interfaces\LoggerHelperInterface;
use Metapp\Apollo\Logger\Traits\LoggerHelperTrait;
use Metapp\Apollo\Route\Router;
use Metapp\Apollo\Twig\Twig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use Twig\Environment;

class HtmlStrategy extends ApplicationStrategy implements LoggerHelperInterface
{
    use LoggerHelperTrait;

    /**
     * @var string
     */
    private $content_type = 'text/html';

    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @param \Twig\Environment $twig
     * @param Router $router
     * @param LoggerInterface|null $logger
     */
    public function __construct(Environment $twig, Router $router, LoggerInterface $logger = null)
    {
        $this->twig = $twig;
        $this->router = $router;
        if ($logger) {
            $this->setLogger($logger);
        }
    }

    public function invokeRouteCallable(Route $route, ServerRequestInterface $request): ResponseInterface
    {
        $response = new \Laminas\Diactoros\Response;
        $controller = $route->getCallable($this->getContainer());
        $response = $controller($request, $response, $route->getVars());
        return $this->decorateResponse($response);
    }

    public function getNotFoundDecorator(NotFoundException $exception): MiddlewareInterface
    {
        return $this->buildStandardException(404);
    }

    public function getMethodNotAllowedDecorator(MethodNotAllowedException $exception): MiddlewareInterface
    {
        return $this->buildStandardException(405);
    }

    public function getThrowableHandler(): MiddlewareInterface
    {
        return new class ($this->twig, $this->router) implements MiddlewareInterface
        {
            protected $twig;
            protected $router;

            public function __construct(Twig $twig, Router $router)
            {
                $this->twig = $twig;
                $this->router = $router;
            }

            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $handler
            ): ResponseInterface {
                try {
                    return $handler->handle($request);
                } catch (Exception $exception) {
                    $response = new \Laminas\Diactoros\Response;
                    print_r($exception->getMessage());
                    if ($exception instanceof UnauthorizedException) {
                        $response = $response->withHeader('Location', $this->router->getRealUrl($this->router->getNamedRoute('login')->getPath()));
                        return $response;
                    }
                    if ($exception instanceof HttpException) {
                        $response = $response->withStatus($exception->getStatusCode());
                        $params = array(
                            'title' => $response->getStatusCode(),
                            'block' => array(
                                'title' => $response->getReasonPhrase(),
                                'content' => json_decode(strtok("\n"), true),
                            ),
                        );
                        $response->getBody()->write(implode("<br>",$params));
                        return $response;
                    }

                    $response = $response->withStatus(500);
                    $params = array(
                        'title' => $response->getStatusCode(),
                        'block' => array(
                            'title' => $response->getReasonPhrase(),
                            'message' => $exception->getMessage(),
                            'trace' => $exception->getTraceAsString(),
                        ),
                    );
                    $response->getBody()->write(implode("<br>",$params));
                    return $response;
                }
            }
        };
    }

    /**
     * @param $statusCode
     * @return MiddlewareInterface
     */
    private function buildStandardException($statusCode = 400): MiddlewareInterface
    {
        return new class ($this->twig,$statusCode) implements MiddlewareInterface {
            protected $twig;
            protected $statusCode;

            public function __construct(Twig $twig,$statusCode)
            {
                $this->twig = $twig;
                $this->statusCode = $statusCode;
            }

            public function process(
                ServerRequestInterface  $request,
                RequestHandlerInterface $handler
            ): ResponseInterface
            {
                $response = new \Laminas\Diactoros\Response;
                $response = $response->withStatus($this->statusCode);
                $params = array(
                    'title' => $response->getStatusCode(),
                    'block' => array(
                        'title' => $response->getReasonPhrase(),
                    ),
                );
                $response->getBody()->write(json_encode($params));
                return $response;
            }
        };
    }
}
