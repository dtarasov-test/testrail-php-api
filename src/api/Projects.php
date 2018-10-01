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

    public function all()
    {
        return $this->connector->send_get('get_projects');
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
        return $this->connector->send_post('add_project',
            ['name' => $name,
                'announcement' => $announcement,
                'show_announcement' => $show_announcement,
                'suite_mode' => $suite_mode]);
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
        return $this->connector->send_post('update_project/'.$this->encodePath($projectId),$parameters);
    }

    public function delete(int $projectId){
        $this->connector->send_post('delete_project/'.$this->encodePath($projectId),[]);
    }
}