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
use Metapp\Apollo\Utils\APIResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use Twig\Environment;

class JsonStrategy extends ApplicationStrategy implements LoggerHelperInterface
{
	use LoggerHelperTrait;

	/**
	 * @var string
	 */
	private $content_type = 'application/json';

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
		return $this->buildStandardException(404, "Method not found");
	}

	public function getMethodNotAllowedDecorator(MethodNotAllowedException $exception): MiddlewareInterface
	{
		return $this->buildStandardException(405, "Method not allowed");
	}

	public function getThrowableHandler(): MiddlewareInterface
	{
		return new class ($this->twig, $this->router) implements MiddlewareInterface
		{
			protected $router;

			public function __construct(Twig $twig, Router $router)
			{
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
					if ($exception instanceof UnauthorizedException) {
						$apiResponseBuilder = new APIResponseBuilder(401, "Unauthorized");
						$response->getBody()->write($apiResponseBuilder->build());
						return $response;
					}
					if ($exception instanceof HttpException) {
						$message = $exception->getMessage();
						$data = array();
						try {
							$messageDecoded = json_decode($message, true);
							if (!empty($messageDecoded)) {
								if (isset($messageDecoded["message"])) {
									$message = $messageDecoded["message"];
								}
								if (isset($messageDecoded["data"])) {
									$data = $messageDecoded["data"];
								}
							}
						} catch (Exception $e) {
						}

						$apiResponseBuilder = new APIResponseBuilder($exception->getStatusCode(), $message, $data);
						$response->getBody()->write($apiResponseBuilder->build());
						return $response;
					}

					$response = $response->withStatus(500);
					$apiResponseBuilder = new APIResponseBuilder($response->getStatusCode(), $response->getReasonPhrase());
					$response->getBody()->write($apiResponseBuilder->build());
					return $response;
				}
			}
		};
	}

	/**
	 * @param $statusCode
	 * @return MiddlewareInterface
	 */
	private function buildStandardException($statusCode = 400, $message = null): MiddlewareInterface
	{
		return new class ($this->twig, $statusCode, $message) implements MiddlewareInterface {
			protected $twig;
			protected $statusCode;
			protected $message;

			public function __construct(Twig $twig,$statusCode, $message)
			{
				$this->twig = $twig;
				$this->statusCode = $statusCode;
				$this->message = $message;
			}

			public function process(
				ServerRequestInterface  $request,
				RequestHandlerInterface $handler
			): ResponseInterface
			{
				$response = new \Laminas\Diactoros\Response;
				$response = $response->withStatus($this->statusCode);
				if($this->message != null){
					$apiResponseBuilder = new APIResponseBuilder($this->statusCode, $this->message);
				}else{
					$apiResponseBuilder = new APIResponseBuilder($response->getStatusCode(), $response->getReasonPhrase());
				}
				$response->getBody()->write($apiResponseBuilder->build());
				return $response;
			}
		};
	}
}
