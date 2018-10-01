<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 14:20
 */

namespace seretos\testrail\connector;


interface ApiConnectorInterface
{
    public function get_user();
    public function set_user($user);

    public function get_password();
    public function set_password($password);

    public function send_get($uri);
    public function send_post($uri, $data);
}