<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 14:19
 */

namespace seretos\testrail;


use seretos\testrail\api\Projects;
use seretos\testrail\api\Suites;
use seretos\testrail\connector\ApiConnectorInterface;
use seretos\testrail\connector\TestRailAPIClient;

class Client
{
    /**
     * @var ApiConnectorInterface
     */
    private $connector;

    public function __construct(ApiConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    public static function create(string $url, string $user, string $password){
        $connector = new TestRailAPIClient($url);
        $connector->set_user($user);
        $connector->set_password($password);
        return new self($connector);
    }

    public function projects(){
        return new Projects($this->connector);
    }

    public function suites(){
        return new Suites($this->connector);
    }

    public function api($name){
        switch ($name){
            case 'projects':
                return $this->projects();
            case 'suites':
                return $this->suites();
        }
        return null;
    }
}