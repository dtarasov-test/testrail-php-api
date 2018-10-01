<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 16:59
 */

namespace seretos\testrail\api;


class Sections extends AbstractApi
{
    public function all(int $projectId, int $suiteId)
    {
        return $this->connector->send_get('get_sections/'.$this->encodePath($projectId).'&suite_id='.$this->encodePath($suiteId));
    }

    public function get(int $sectionId)
    {
        return $this->connector->send_get('get_section/' . $this->encodePath($sectionId));
    }

    public function findByName(int $projectId, int $suiteId, string $name)
    {
        $allSections = $this->all($projectId,$suiteId);
        foreach ($allSections as $section) {
            if ($section['name'] === $name) {
                return $section;
            }
        }
        return [];
    }

    public function findByNameAndParent(int $projectId, int $suiteId, string $name, int $parentId=null)
    {
        $allSections = $this->all($projectId,$suiteId);
        foreach ($allSections as $section) {
            if ($section['name'] === $name && $section['parent_id'] == $parentId) {
                return $section;
            }
        }
        return [];
    }

    public function create(int $projectId, int $suiteId, string $name, string $description = null, int $parent_id = null)
    {
        return $this->connector->send_post('add_section/'.$this->encodePath($projectId),
            ['name' => $name,
                'description' => $description,
                'suite_id' => $suiteId,
                'parent_id' => $parent_id]);
    }

    /**
     * @param int $sectionId
     * @param array $parameters {
     * @var string $name
     * @var string $description
     * }
     * @return mixed
     */
    public function update(int $sectionId, array $parameters = []){
        return $this->connector->send_post('update_section/'.$this->encodePath($sectionId),$parameters);
    }

    public function delete(int $sectionId){
        $this->connector->send_post('delete_section/'.$this->encodePath($sectionId),[]);
    }
}