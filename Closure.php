<?php namespace index;
use Closure;

class fly
{
	public function active()
	{
		echo 'i am  actived  '  . __FUNCTION__;
	}
}


class person
{
	public function __construct($somePower = '')
	{
		$somePower->active();
	}
}

class app
{

    public function bind ($str, $function)
    {
        if ($function instanceof Closure)
        {
            $this->binds[$str] = $function;
        }
	else
	{
		$this->instances[$str] = $function;
	}
    }

    public function make ($abstract,$parame = [])
    {
		if(isset($this->instances[$abstract]))
		{
			return $this->instances[$abstract];
		}
	
		array_unshift($parame,$this);
	
        return call_user_func_array($this->binds[$abstract], $parame);
    }
}

$app = new app();
//超能力生产脚本
$app->bind('person', function  ($app,$parame)
{
   return new person($app->make($parame));
});
//注入“飞的”超能力
$app->bind('fly',new fly());

$app->make('person',['fly']);
 
?>
