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
}