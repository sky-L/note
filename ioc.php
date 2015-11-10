<?php
namespace Database;
use ReflectionMethod;

class Database
{

    protected $adapter;

    public function __construct ()
    {}

    public function test (MysqlAdapter $adapter)
    {
        $adapter->test();
    }
}

class MysqlAdapter
{

    public function test ()
    {
        echo "i am MysqlAdapter test";
    }
}

class app
{

    public static function run ($instance, $method)
    {
        if (! method_exists($instance, $method))
            
            return null;
        
        $reflector = new ReflectionMethod($instance, $method);
        
        $parameters = [
                1
        ];
        
        foreach ($reflector->getParameters() as $key => $parameter)
        {
            
            $class = $parameter->getClass();
            
            if ($class)
            {
                array_splice($parameters, $key, 0, [
                        new $class->name()
                ]);
            }
        }
        call_user_func_array([
                $instance,
                $method
        ], $parameters);
    }
}

app::run(new Database(), 'test');











