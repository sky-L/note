<?php
require("../lib/UserMQ.php");

   $mq=UserMQ::MQ();

$flag=true;
while($flag){
    $msg = $mq->pop();
    if ($msg!=null){
   
    }
  
}



?>
