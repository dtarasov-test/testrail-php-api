<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 05.10.18
 * Time: 13:42
 */

namespace seretos\testrail\api;


class Statuses extends AbstractApi
{
    private $cache = null;
    public function all()
    {
        if ($this->cache === null) {
            $this->cache = $this->connector->send_get('get_statuses');
        }
        return $this->cache;
    }

    public function findByName(string $name)
    {
        $states = $this->all();
        foreach ($states as $state) {
            if ($state['name'] === $name) {
                return $state;
            }
        }
        return [];
    }
}