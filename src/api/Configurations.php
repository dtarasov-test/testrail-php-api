<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 04.10.18
 * Time: 11:49
 */

namespace seretos\testrail\api;


class Configurations extends AbstractApi
{
    private $cache = null;

    public function all(int $projectId)
    {
        if($this->cache === null) {
            $this->cache = $this->connector->send_get('get_configs/'.$this->encodePath($projectId));
        }
        return $this->cache;
    }

    public function findByGroupName(int $projectId, string $name){
        $configurations = $this->all($projectId);
        foreach ($configurations as $configuration) {
            if ($configuration['name'] === $name) {
                return $configuration;
            }
        }
        return [];
    }

    public function findByName(int $projectId, string $fieldName, string $name){
        $configurations = $this->all($projectId);
        foreach ($configurations as $configuration) {
            if($configuration['name'] == $fieldName) {
                foreach ($configuration['configs'] as $config) {
                    if ($config['name'] === $name) {
                        return $config;
                    }
                }
            }
        }
        return [];
    }

    public function createGroup(int $projectId, string $name)
    {
        $group = $this->connector->send_post('add_config_group/'.$this->encodePath($projectId),
            ['name' => $name]);
        $this->cache = null;
        return $group;
    }

    public function updateGroup(int $groupId, string $name){
        $group = $this->connector->send_post('update_config_group/'.$this->encodePath($groupId),['name' => $name]);
        $this->cache = null;
        return $group;
    }

    public function deleteGroup(int $groupId){
        $this->connector->send_post('delete_config_group/'.$this->encodePath($groupId),[]);
        $this->cache = null;
    }

    public function create(int $groupId, string $name)
    {
        $config = $this->connector->send_post('add_config/'.$this->encodePath($groupId),
            ['name' => $name]);
        $this->cache = null;
        return $config;
    }

    public function update(int $configId, string $name){
        $this->connector->send_post('update_config/'.$this->encodePath($configId),
            ['name' => $name]);
        $this->cache = null;
    }

    public function delete(int $configId){
        $this->connector->send_post('delete_config/'.$this->encodePath($configId),[]);
        $this->cache = null;
    }
}