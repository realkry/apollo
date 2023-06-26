<?php

namespace Metapp\Apollo\Route;

use Metapp\Apollo\Auth\Auth;
use Metapp\Apollo\Helper\Helper;
use Doctrine\ORM\EntityManagerInterface;
use League\Container\Container;
use Metapp\Apollo\Config\Config;
use Metapp\Apollo\Middlewares\AuthMiddleware;
use Metapp\Apollo\Middlewares\ContentTypeMiddleware;
use Metapp\Apollo\Middlewares\FieldsMiddleware;
use Metapp\Apollo\Middlewares\HeadersMiddleware;
use Metapp\Apollo\Middlewares\PermissionGroupMiddleware;
use Metapp\Apollo\Middlewares\PermissionMiddleware;
use Twig\Environment;
use League\Route\Route;

class RouteValidator implements RouteValidatorInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * RouteValidator constructor.
     * @param Config $config
     * @param \Twig\Environment $twig
     * @param Helper $helper
     * @param Auth $auth
     */
    public function __construct(Config $config, Environment $twig, EntityManagerInterface $entityManager, Helper $helper, Auth $auth)
    {
        $this->config = $config;
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->helper = $helper;
        $this->auth = $auth;
    }

    /**
     * @param Route $map
     * @param array $requires
     * @param array $options
     * @param Container $container
     * @return Route
     */
    public function validate(Route $map, array $requires, array $options, Container $container)
    {
        if (!empty($requires['require_permissions'])) {
            if (!is_array($requires['require_permissions'][0])) {
                $requires['require_permissions'] = array($requires['require_permissions']);
            }
            $options['require_permissions'] = $requires['require_permissions'];
            $map->middleware(new PermissionMiddleware($options, $this->entityManager, $this->config, $this->helper->getSessionUser()));
        }
        if (!empty($requires['required_permission_groups'])) {
            $options['required_permission_groups'] = $requires['required_permission_groups'];
            $map->middleware(new PermissionGroupMiddleware($options, $this->entityManager, $this->config, $this->helper->getSessionUser()));
        }
        if ($requires['require_auth']) {
            $options['require_auth'] = $requires['require_auth'];
            $options['auth_method'] = $requires['auth_method'];
            $map->middleware(new AuthMiddleware($options, $this->entityManager, $this->config));
        }
		if ($requires['middleware']) {
			$middlewareClass = $requires["middleware"];
			$map->middleware(new $middlewareClass($options, $container, $this));
		}
        if (!empty($requires['required_fields'])) {
            $options['required_fields'] = (array)$requires['required_fields'];
            $map->middleware(new FieldsMiddleware($options, $this->entityManager, $this->config, $container));
        }
        if (!empty($requires['required_headers'])) {
            $options['required_headers'] = (array)$requires['required_headers'];
            $map->middleware(new HeadersMiddleware($options, $this->entityManager, $this->config));
        }
        if ($requires['required_ContentType'] && in_array($requires['required_ContentType'], $options['valid_ContentTypes']) && in_array($options['method'], array('POST', 'PUT', 'PATCH', 'DELETE'))) {
            $options['required_ContentType'] = $requires['required_ContentType'];
            $map->middleware(new ContentTypeMiddleware($options, $this->entityManager, $this->config));
        }
        return $map;
    }
}
