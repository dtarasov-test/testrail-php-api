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
    private $cache = [];
    public function all(int $projectId)
    {
        if(!isset($this->cache[$projectId])) {
            $this->cache[$projectId] = $this->connector->send_get('get_milestones/' . $this->encodePath($projectId));
        }
        return $this->cache[$projectId];
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
        unset($this->cache[$projectId]);
        return $milestone;
    }

    /**
     * @param int $milestoneId
     * @param array $parameters {
     *      @var bool       $is_completed
     *      @var bool       $is_started
     *      @var int        $parent_id
     *      @var int        $start_on
     * }
     */
    public function update(int $milestoneId, array $parameters = []){
        $milestone = $this->connector->send_post('update_milestone/'.$this->encodePath($milestoneId),$parameters);
        $this->cache = [];
        return $milestone;
    }

    public function delete(int $milestoneId){
        $this->connector->send_post('delete_milestone/'.$this->encodePath($milestoneId),[]);
        $this->cache = [];
    }
}