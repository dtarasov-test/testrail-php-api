<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 14:19
 */

namespace seretos\testrail;


use seretos\testrail\api\Cases;
use seretos\testrail\api\Projects;
use seretos\testrail\api\Sections;
use seretos\testrail\api\Suites;
use seretos\testrail\api\Templates;
use seretos\testrail\api\Types;
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

    public function sections(){
        return new Sections($this->connector);
    }

    public function cases(){
        return new Cases($this->connector);
    }

    public function templates(){
        return new Templates($this->connector);
    }

    public function types(){
        return new Types($this->connector);
    }

    public function api($name){
        switch ($name){
            case 'projects':
                return $this->projects();
            case 'suites':
                return $this->suites();
            case 'sections':
                return $this->sections();
            case 'cases':
                return $this->cases();
            case 'templates':
                return $this->templates();
            case 'types':
                return $this->types();
        }
        return null;
    }
}