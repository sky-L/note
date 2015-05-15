<?php
require("../lib/PHPMQ.php");

class UserMQ extends PHPMQ 
{
    use SingletonTrait;
    
   abstract protected function getKey()
   {
       return 'list:user:reg';
   }
   abstract protected function package($data)
   
       return "";
   }
   abstract protected tion unpackage($msg)
   {
      return array();
   }
    
}

?>
