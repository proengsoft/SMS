<?php namespace Proengsoft\SMS\Services;
/**
 * Created by PhpStorm.
 * User: josejuan
 * Date: 04/06/2015
 * Time: 23:42
 */


interface SmsInterface
{
    public function send( $mobile, $params);

    public function verify($zone, $mobile, $code);
}