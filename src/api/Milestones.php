<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 04.10.18
 * Time: 11:07
 */

namespace seretos\testrail\api;


class Milestones extends AbstractApi
{
    private $cache = null;

    public function all(int $projectId)
    {
        if($this->cache === null) {
            $this->cache = $this->connector->send_get('get_milestones/'.$this->encodePath($projectId));
        }
        return $this->cache;
    }

    public function get(int $milestoneId)
    {
        return $this->connector->send_get('get_milestone/' . $this->encodePath($milestoneId));
    }

    public function findByName(int $projectId, string $name)
    {
        $allMilestones = $this->all($projectId);
        foreach ($allMilestones as $milestone) {
            if ($milestone['name'] === $name) {
                return $milestone;
            }
        }
        return [];
    }

    public function create(int $projectId, string $name, string $description = null, \DateTime $dueOn = null)
    {
        if($dueOn === null){
            $dueOn = new \DateTime();
        }
        $milestone = $this->connector->send_post('add_milestone/'.$this->encodePath($projectId),
            ['name' => $name,
                'description' => $description,
                'due_on' => $dueOn->getTimestamp()]);
        $this->cache = null;
        return $milestone;
    }

    /**
     * @param int $milestoneId
     * @param array $parameters {
     *      @var bool       $is_completed
     *      @var bool       $is_started
     *      @var int        $parent_id
     *      @var timestamp  $start_on
     * }
     */
    public function update(int $milestoneId, array $parameters = []){
        $milestone = $this->connector->send_post('update_milestone/'.$this->encodePath($milestoneId),$parameters);
        $this->cache = null;
        return $milestone;
    }

    public function delete(int $milestoneId){
        $this->connector->send_post('delete_milestone/'.$this->encodePath($milestoneId),[]);
        $this->cache = null;
    }
}