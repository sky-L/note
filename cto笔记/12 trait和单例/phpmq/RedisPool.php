<?php

class RedisPool 
{
	private static $connections =  array();
        private static $servers =  array();
       
        public static  function addServer($conf)
	{
		foreach ($conf as $alias => $data){
			self::$servers[$alias]=$data;
		}	
	
	}

	public static  function getRedis($alias,$select=0)
	{
		if(!array_key_exists($alias,self::$connections)){
			$redis=new Redis();
			$redis->connect(self::$servers[$alias][0],self::$servers[$alias][1]);
			self::$connections[$alias]=$redis;
			if(isset(self::$servers[$alias][2]) && self::$servers[$alias][2]!=""){
				self::$connections[$alias]->auth(self::$servers[$alias][2]);
			}
		}
		self::$connections[$alias]->select($select);
		return self::$connections[$alias];

	}






}


