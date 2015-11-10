<?php
require("./RedisPool.php");

trait SingletonTrait
{
   private static $instance=null;
   public static function MQ()
   {
       if(self::$instance==null){
       	   self::$instance=new self;
           self::$instance->init();
       }
       return self::$instance;
   }

}



abstract class PHPMQ
{
   abstract protected function getKey();
   abstract protected function package();
   abstract protected function unpackage();
   protected $redis;

   public function init()
   {
        RedisPool::addServer(array("F1"=>array('127.0.0.1',6379)));
	$redis=RedisPool::getRedis("F1");
   }   

   public function push($msg)
   {
        $redis->rpush($this->getKey(),$this->package($msg));
   }
   
   public function pop($msg)
   {
        $this->unpackage($redis->lpop($this->getKey()));
   }
}
