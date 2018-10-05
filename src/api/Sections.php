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
    private $cache = [];
    public function all(int $projectId, int $suiteId)
    {
        if(!isset($this->cache[$projectId][$suiteId])) {
            $this->cache[$projectId][$suiteId] = $this->connector->send_get('get_sections/' . $this->encodePath($projectId) . '&suite_id=' . $this->encodePath($suiteId));
        }
        return $this->cache[$projectId][$suiteId];
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
        $section = $this->connector->send_post('add_section/'.$this->encodePath($projectId),
            ['name' => $name,
                'description' => $description,
                'suite_id' => $suiteId,
                'parent_id' => $parent_id]);
        unset($this->cache[$projectId][$suiteId]);
        return $section;
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
        $section = $this->connector->send_post('update_section/'.$this->encodePath($sectionId),$parameters);
        $this->cache = [];
        return $section;
    }

    public function delete(int $sectionId){
        $this->connector->send_post('delete_section/'.$this->encodePath($sectionId),[]);
        $this->cache = [];
    }
}