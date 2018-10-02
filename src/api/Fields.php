<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 02.10.18
 * Time: 10:55
 */

namespace seretos\testrail\api;


class Fields extends AbstractApi
{
    public function all()
    {
        return $this->connector->send_get('get_case_fields');
    }

    public function findByProject(int $projectId){
        $fields = $this->all();
        $resultFields = [];
        foreach($fields as $field){
            if($field['config']['context']['is_global'] === true){
                $resultFields[] = $field;
            }else if(in_array($projectId,$field['config']['context']['project_ids'])){
                $resultFields[] = $field;
            }
        }
        return $resultFields;
    }

    public function findByName(string $name, int $projectId = null){
        if($projectId === null){
            $fields = $this->all();
        }else{
            $fields = $this->findByProject($projectId);
        }

        foreach($fields as $field){
            if($field['name'] === $name){
                return $field;
            }
        }
        return [];
    }

    public function findElementId(string $field, string $value, int $projectId = null){
        $field = $this->findByName($field,$projectId);
        if($field !== []){
            preg_match_all('/^([0-9]*),\s([A-Za-z0-9 ]*)/m', $field['configs']['options']['items'], $matches, PREG_SET_ORDER, 0);
            foreach ($matches as $match) {
                if($match[2] === $value){
                    return (int)$match[1];
                }
            }
        }
        return 0;
    }
}