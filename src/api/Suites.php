<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 15:44
 */

namespace seretos\testrail\api;


class Suites extends AbstractApi
{
    public function all(int $projectId)
    {
        return $this->connector->send_get('get_suites/'.$this->encodePath($projectId));
    }

    public function get(int $suiteId)
    {
        return $this->connector->send_get('get_suite/' . $this->encodePath($suiteId));
    }

    public function findByName(int $projectId, string $name)
    {
        $allSuites = $this->all($projectId);
        foreach ($allSuites as $suite) {
            if ($suite['name'] === $name) {
                return $suite;
            }
        }
        return [];
    }

    public function create(int $projectId, string $name, string $description = null)
    {
        return $this->connector->send_post('add_suite/'.$this->encodePath($projectId),
            ['name' => $name,
                'description' => $description]);
    }

    /**
     * @param int $suiteId
     * @param array $parameters {
     * @var string $name
     * @var string $description
     * }
     * @return mixed
     */
    public function update(int $suiteId, array $parameters = []){
        return $this->connector->send_post('update_suite/'.$this->encodePath($suiteId),$parameters);
    }

    public function delete(int $suiteId){
        $this->connector->send_post('delete_suite/'.$this->encodePath($suiteId),[]);
    }
}