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
    public function all()
    {
        return $this->connector->send_get('get_suites');
    }

    public function get(int $suiteId)
    {
        return $this->connector->send_get('get_suite/' . $this->encodePath($suiteId));
    }

    public function findByName(string $name)
    {
        $allProjects = $this->all();
        foreach ($allProjects as $project) {
            if ($project['name'] === $name) {
                return $project;
            }
        }
        return [];
    }

    public function create(string $name, string $description = null)
    {
        return $this->connector->send_post('add_suite',
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