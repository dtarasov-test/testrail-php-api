<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 14:26
 */

namespace seretos\testrail\api;


use seretos\testrail\connector\ApiConnectorInterface;

abstract class AbstractApi
{
    /**
     * @var ApiConnectorInterface
     */
    protected $connector;

    public function __construct(ApiConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function encodePath($path)
    {
        $path = rawurlencode($path);
        return str_replace('.', '%2E', $path);
    }
}