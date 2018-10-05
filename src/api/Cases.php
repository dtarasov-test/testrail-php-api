<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 17:59
 */

namespace seretos\testrail\api;


class Cases extends AbstractApi
{
    public function all(int $projectId, int $suiteId, int $sectionId = null)
    {
        return $this->connector->send_get('get_cases/' . $this->encodePath($projectId) . '&suite_id=' . $this->encodePath($suiteId) . '&section_id=' . $this->encodePath($sectionId));
    }

    public function get(int $caseId)
    {
        return $this->connector->send_get('get_case/' . $this->encodePath($caseId));
    }

    public function findByField(int $projectId, int $suiteId, int $sectionId, string $field, string $value){
        $allCases = $this->all($projectId,$suiteId, $sectionId);
        foreach ($allCases as $case) {
            if ($case[$field] === $value) {
                return $case;
            }
        }
        return [];
    }

    /**
     * @param int $sectionId
     * @param string $title
     * @param int $templateId
     * @param int $typeId
     * @param array $customFields
     * @return mixed
     */
    public function create(int $sectionId, string $title, int $templateId, int $typeId, array $customFields = [])
    {
        $params = $customFields;
        $params['title'] = $title;
        $params['template_id'] = $templateId;
        $params['type_id'] = $typeId;
        $case = $this->connector->send_post('add_case/'.$this->encodePath($sectionId), $params);
        return $case;
    }

    /**
     * @param int $caseId
     * @param array $parameters {
     * @var string $title
     * @var int $template_id
     * @var int $type_id
     * }
     * @return mixed
     */
    public function update(int $caseId, array $parameters = []){
        $case = $this->connector->send_post('update_case/'.$this->encodePath($caseId),$parameters);
        return $case;
    }

    public function delete(int $caseId){
        $this->connector->send_post('delete_case/'.$this->encodePath($caseId),[]);
    }
}