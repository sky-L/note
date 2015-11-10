<?php

define("DSN","mysql:host=localhost;dbname=tredis");
define("USER","root");
define("PASS","123456");



require 'RedisPool.php';
if(isset($_POST["username"])){
/*
    try{
        $pdo=new PDO(DSN,USER,PASS);    
    }catch(PDOException $e){
        die($e->getMessage);
    }
*/
    $conf=array(
    'FA'=>array('127.0.0.1',6379)
    );

    RedisPool::addServer($conf);
    $redis= RedisPool::getRedis('FA');
    $username=$_POST["username"];
    $password=$_POST["password"];
    $data=array();
    $data["username"]=$username;
    $data["password"]=$password;
    require '../../lib/UserMQ.php';
    UserMQ:MQ()->push($data);
  //  $sql = "insert into tb_user values(null,?,?)";
  //  $stmt = $pdo->prepare($sql);
  //  $stmt->execute(array($username,$password));

    $redis->set("string:user:".$username,$password);
    
   //$redis->rpush("list:users",$username);
}


?>
<html>
<head></head>
<body>
<form action="" method="post">
username:<input name="username" /><br>
password:<input name="password" /><br>
<input type="submit" />
</form>
</body>
</html>
