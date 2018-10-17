<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 17.10.18
 * Time: 15:54
 */

namespace seretos\testrail\api;


class Users extends AbstractApi
{
    private $cache = null;

    public function all(){
        if($this->cache === null) {
            $this->cache =  $this->connector->send_get('get_users');
        }
        return $this->cache;
    }

    public function find(string $name){
        $users = $this->all();
        foreach ($users as $user) {
            if ($user['name'] === $name || $user['email'] === $name) {
                return $user;
            }
        }
        return [];
    }
}