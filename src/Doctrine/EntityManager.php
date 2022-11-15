<?php
namespace Metapp\Apollo\Doctrine;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Metapp\Apollo\Logger\Interfaces\LoggerHelperInterface;
use Metapp\Apollo\Logger\Traits\LoggerHelperTrait;

class EntityManager extends \Doctrine\ORM\EntityManager implements LoggerHelperInterface
{
    use LoggerHelperTrait;

    /**
     * @param Connection $conn
     * @param Configuration $config
     */
    public function __construct(Connection $conn, Configuration $config, EventManager $eventManager)
    {
        parent::__construct($conn, $config, $eventManager);
    }
}
