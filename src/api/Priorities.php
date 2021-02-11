<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 02.10.18
 * Time: 14:28
 */

namespace seretos\testrail\api;


class Priorities extends AbstractApi
{
    private $cache = null;
    public function all()
    {
        if ($this->cache === null) {
            $this->cache = $this->connector->send_get('get_priorities');
        }
        return $this->cache;
    }

    public function findByName(string $name)
    {
        $priorities = $this->all();
        foreach ($priorities as $priority) {
            if ($priority['name'] === $name) {
                return $priority;
            }
        }
        return [];
    }

    public function getDefaultPriority() {
        $priorities = $this->all();
        foreach ($priorities as $priority) {
            if ($priority['is_default'] === true) {
                return $priority;
            }
        }
        return [];
    }
}