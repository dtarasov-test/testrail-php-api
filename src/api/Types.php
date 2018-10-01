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
    public function all()
    {
        return $this->connector->send_get('get_case_types');
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