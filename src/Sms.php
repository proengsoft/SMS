<?php namespace Proengsoft\SMS;


use Proengsoft\SMS\Services\AltiriaSMS;

class Sms
{
    protected $broker;

    public function __construct($config = [])
    {
        $this->broker = new AltiriaSMS($config);
    }

    public function send($mobile, $params)
    {
        return $this->broker->send($mobile, $params);
    }

    public function verify($zone, $mobile, $code)
    {
    }
}