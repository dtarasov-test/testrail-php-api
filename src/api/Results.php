<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 04.10.18
 * Time: 17:25
 */

namespace seretos\testrail\api;


class Results extends AbstractApi
{
    public function create(int $runId, int $caseId, int $statusId, array $parameters = []){
        $parameters['status_id'] = $statusId;
        $result = $this->connector->send_post('add_result_for_case/'.$this->encodePath($runId).'/'.$this->encodePath($caseId),
            $parameters);
        return $result;
    }
}