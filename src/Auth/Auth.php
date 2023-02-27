<?php
namespace Metapp\Apollo\Auth;

use Firebase\JWT\Key;
use Metapp\Apollo\Config\Config;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;

class Auth
{
    const JWT = 'JWT';
    const Session = 'Session';
    const Cookie = 'Cookie';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * Auth constructor.
     * @param EntityManagerInterface $entityManager
     * @param Config $config
     */
    public function __construct(EntityManagerInterface $entityManager,Config $config)
    {
        $this->config = $config;
        $this->entityManager = $entityManager;
    }

    public function generateJWT($data = array()){
        $tokenData = $this->config->get(array('jwt','payload'));
        $tokenData["data"] = $data;
        return JWT::encode($tokenData, $this->config->get(array('jwt','key')),'HS256');
    }

    public function validateJWT($token){
		$table = $this->config->get(array('route', 'modules', 'Session', 'entity', 'user'));
		$where = $this->config->get(array('route', 'modules', 'Session', 'entity', 'user_auth_key'), 'email');
		$a = $this->config->get(array('route', 'modules', 'Session', 'entity', 'user_auth_data'), 'email');
        try {
            $decodedData = JWT::decode($token, new Key($this->config->get(array('jwt','key')), 'HS256'));
            if (is_object($decodedData)) {
                $fetchData = $decodedData->data;

                $data = $fetchData->{$a};
                $getUser = $this->entityManager->getRepository($table)->findOneBy(array($where => $data));
                if ($getUser) {
                    return true;
                }
            }
        } catch (\Exception $e) {
        }
        return false;
    }

    public function getUserByJWT($token){
		$table = $this->config->get(array('route', 'modules', 'Session', 'entity', 'user'));
		$where = $this->config->get(array('route', 'modules', 'Session', 'entity', 'user_auth_key'), 'email');
		$a = $this->config->get(array('route', 'modules', 'Session', 'entity', 'user_auth_data'), 'email');
		try {
			$decodedData = JWT::decode($token, new Key($this->config->get(array('jwt','key')), 'HS256'));
			if (is_object($decodedData)) {
				$fetchData = $decodedData->data;

				$data = $fetchData->{$a};
				$getUser = $this->entityManager->getRepository($table)->findOneBy(array($where => $data));
				if ($getUser) {
					return $getUser;
				}
			}
		} catch (\Exception $e) {
		}
		return false;
    }
}
