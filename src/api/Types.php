<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 18:20
 */

namespace seretos\testrail\api;


class Types extends AbstractApi
{
    private $cache = null;
    public function all()
    {
        if($this->cache === null) {
            $this->cache =  $this->connector->send_get('get_case_types');
        }
        return $this->cache;
    }

    public function findByName(string $name)
    {
        $types = $this->all();
        foreach ($types as $type) {
            if ($type['name'] === $name) {
                return $type;
            }
        }
        return [];
    }
}