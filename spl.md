
###类作为数组访问
```
class config implements ArrayAccess
{
    static $config = null;
    
    private $configArr;
    
    private function __construct()
    
    public static function instance()
    {
        if(self::$config == null){
            self::$config = new config();
        }
        return self::$config;
        
    }
    
    public function offsetExists($offset = '')
    {
        
    }
    public function offsetGet($offset = '')
    {
        return $this->configArr[$offset];
    }
    public function offsetSet($offset, $value)
    {
    
    }
    
    public function offsetUnset($offset = '')
    {
    
    }
    
}

$test = config::instance();

$test['test'] = 'test';//自动调用offsetSet
if(isset($test['test']))//自动调用offsetExists
{
    echo $test['test'];//自动调用offsetGet
    echo '<br />';
    unset($test['test']);//自动调用offsetUnset
    var_dump($test['test']);
}


```
