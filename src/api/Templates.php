<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 18:14
 */

namespace seretos\testrail\api;


class Templates extends AbstractApi
{
    public function all(int $projectId)
    {
        return $this->connector->send_get('get_templates/'.$this->encodePath($projectId));
    }

    public function findByName(int $projectId, string $name)
    {
        $templates = $this->all($projectId);
        foreach ($templates as $template) {
            if ($template['name'] === $name) {
                return $template;
            }
        }
        return [];
    }
}