<?php namespace Proengsoft\SMS\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AltiriaSMS implements SmsInterface {

    /**
     * @var \Config
     */
    private $config;

    private $domain;
    private $user;
    private $pwd;
    private $sender;

    private $id = "21341234123";

    const URL = "www.altiria.net";


    public function __construct($config = [])
    {

        $this->config = $config;

        $this->domain = trim($this->config['domain']);
        $this->user = trim($this->config['user']);
        $this->pwd = trim($this->config['pwd']);
        $this->sender = trim($this->config['sender']);
    }

    public function send( $mobile, $params)
    {
        if($this->domain == "" ||
            $this->user == "" ||
            $this->pwd == "") {
            return -1;
        }

        $sData = "cmd=sendsms&domainId=".$this->domain.
            "&ack=true&idAck=".$this->id.
            "&login=".$this->user.
            "&passwd=".$this->pwd.
            "&dest=".str_replace(",","&dest=",$mobile).
            "&msg=".urlencode($params).
            "&senderId=".$this->sender;
        $sData .= "&encoding=unicode&concat=true";

        $fp = fsockopen(self::URL, 80);
        $buf = "POST /api/http HTTP/1.0\r\n";
        $buf .= "Host: ".self::URL."\r\n";
        $buf .= "Content-type: application/x-www-form-urlencoded; charset=UTF-8\r\n";
        $buf .= "Content-length: ".strlen($sData)."\r\n";
        $buf .= "\r\n";
        $buf .= $sData;
        fputs($fp, $buf);
        $buf = "";
        while ($fp && !feof($fp))
            $buf .= fgets($fp,128);
        fclose($fp);

        if (strstr($buf,"ERROR")){
            //$resultat=preg_match("/errNum:([0-9]*)/", $buf, $res);
            return -2;
        }
        return 0;
    }

    public function verify($zone, $mobile, $code)
    {
        throw new NotFoundHttpException("No implementado");
    }
}