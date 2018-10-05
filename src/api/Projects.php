<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 14:24
 */

namespace seretos\testrail\api;


class Projects extends AbstractApi
{
    public const SINGLE_SUITE_MODE = 1;
    public const BASELINE_SUITE_MODE = 2;
    public const MULTI_SUITE_MODE = 3;
    private $cache = null;

    public function all()
    {
        if($this->cache === null) {
            $this->cache = $this->connector->send_get('get_projects');
        }
        return $this->cache;
    }

    public function get(int $projectId)
    {
        return $this->connector->send_get('get_project/' . $this->encodePath($projectId));
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

    public function create(string $name, string $announcement = null, bool $show_announcement = false, int $suite_mode = self::MULTI_SUITE_MODE)
    {
        $project = $this->connector->send_post('add_project',
            ['name' => $name,
                'announcement' => $announcement,
                'show_announcement' => $show_announcement,
                'suite_mode' => $suite_mode]);
        $this->cache = null;
        return $project;
    }

    /**
     * @param int $projectId
     * @param array $parameters {
     *      @var string     $name
     *      @var string     $announcement
     *      @var bool       $show_announcement
     *      @var bool       $suite_mode
     *      @var bool       $is_completed
     * }
     */
    public function update(int $projectId, array $parameters = []){
        $project = $this->connector->send_post('update_project/'.$this->encodePath($projectId),$parameters);
        $this->cache = null;
        return $project;
    }

    public function delete(int $projectId){
        $this->connector->send_post('delete_project/'.$this->encodePath($projectId),[]);
        $this->cache = null;
    }
}