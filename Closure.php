<?php namespace index;
use Closure;

class person
{

    public function test ()
    {
        echo 'i am the person obj';
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
    }

    public function make ($abstract)
    {
        return call_user_func_array($this->binds[$abstract], [
                1
        ]);
    }
}

$app = new app();

$app->bind('person', function  ()
{
    return new person();
});

$person = $app->make('person');

$person->test();
?>