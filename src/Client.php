<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 14:19
 */

namespace seretos\testrail;


use seretos\testrail\api\Cases;
use seretos\testrail\api\Configurations;
use seretos\testrail\api\Fields;
use seretos\testrail\api\Milestones;
use seretos\testrail\api\Plans;
use seretos\testrail\api\Priorities;
use seretos\testrail\api\Projects;
use seretos\testrail\api\Results;
use seretos\testrail\api\Sections;
use seretos\testrail\api\Statuses;
use seretos\testrail\api\Suites;
use seretos\testrail\api\Templates;
use seretos\testrail\api\Types;
use seretos\testrail\api\Users;
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

    /**
     * @return string
     */
    public function getUser(){
        return $this->connector->get_user();
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

    public function fields(){
        return new Fields($this->connector);
    }

    public function priorities(){
        return new Priorities($this->connector);
    }

    public function milestones(){
        return new Milestones($this->connector);
    }

    public function plans(){
        return new Plans($this->connector);
    }

    public function configurations(){
        return new Configurations($this->connector);
    }

    public function results(){
        return new Results($this->connector);
    }

    public function statuses(){
        return new Statuses($this->connector);
    }

    public function users(){
        return new Users($this->connector);
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
            case 'fields':
                return $this->fields();
            case 'priorities':
                return $this->priorities();
            case 'milestones':
                return $this->milestones();
            case 'plans':
                return $this->plans();
            case 'configurations':
                return $this->configurations();
            case 'results':
                return $this->results();
            case 'statuses':
                return $this->statuses();
            case 'users':
                return $this->users();
        }
        return null;
    }
}