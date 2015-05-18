<?php
 
interface Hash{
    public function hash($key);
}

class crc32Hash implements Hash{
    public function hash($key){
        return sprintf("%u",crc32($key));
    }
}

class Consistent{
    
    protected $hash_function;
    
    protected $virtual_num = 200;
    
    public  $server_nodes = array();
    
    public function __construct(Hash $hash_function){
        $this->hash_function = $hash_function;
    }
    
    protected function getServerPosition($str){
        return $this->hash_function->hash($str);
    }
    
    protected function sortServer(){
        ksort($this->server_nodes);
    }
    
    public function find($key){
        $positon = $this->hash_function->hash($key);

        $server = current($this->server_nodes);
        
        foreach($this->server_nodes as $k=>$v){
            
            if($key > $positon){
                $server = $v;
                break;
            }
        }
        
        return $server;
    }
    
    
    public  function add($ip,$port){
        for($i = 0;$i<$this->virtual_num;$i++){
            $this->server_nodes[$this->getServerPosition($ip.":".$port.':'.$ip)] = array('ip'=>$ip,'port'=>$port); 
        }
        $this->sortServer();
    }
    
    public function remover($ip,$port){
        for ($i = 0;$i<$this->virtual_num;$i++){
            unset($this->server_nodes[$this->getServerPosition($ip.':'.$port .':' .$i)]);
        }
    }
    
}


$s = new Consistent(new crc32Hash());

$s->add("192.168.1.1",'11211');
$s->add("192.168.2.1",'11211');
$s->add("192.168.3.1",'11211');
$s->add("192.168.4.1",'11211');
$s->add("192.168.5.1",'11211');

$a = $s->find("key");

$s->remover("192.168.2.1", '11211');
$b = $s->find("key");
var_dump($a);
var_dump($b);

$tmp = sprintf("%u",crc32('abc'));


class team{
    
    public $arr = array();
    public function add($arr)
    {
        if(in_array($arr, $this->arr)) return true;
        $this->arr[] = $arr;
    }
    
    public function remove($arr)
    {
       $this->arr = array_diff($this->arr,array($arr));
    }
    
    
    
}


$team = new team();
$team->add('c');
$team->add('b');
$team->add('a');

$team->remove('b');
//var_dump($team->arr);


//装饰者
abstract class Beverage{
    public $_name;
    abstract public function cost();
}

//被装饰者

class Coffee extends Beverage{
    public function __construct(){
        $this->_name = 'Coffee';
    }
    public function cost(){
        return  2;
    }
}

class Milk extends Beverage{
    public $_beverage;
    public function __construct($beverage){
        $this->_name = 'Milk';
        $this->_beverage = $beverage;
    }
    
    public function cost(){
        return  $this->_beverage->cost() + 1;
    }
    
}


$coffee = new Coffee();
$coffee = new Milk($coffee);
//var_dump($coffee->cost());











 

 

 

?>