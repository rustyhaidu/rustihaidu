<?php
class test{
    function __construct()
    {
        echo '<br>Construct';
    }

    function __destruct()
    {
        echo '<br>Destruct';
    }

    public function __call($function, $arguments)
    {
        $args = implode(',', $arguments);
        echo "<br>Calling <b>$function</b> with: <b>$args</b>";
    }

    function __get($name)
    {
        echo "<br>Trying to get <b>$name</b>";
    }

    function __set($name, $value)
    {
        echo "<br>Trying to set <b>$name</b> => <b>$value</b>";
    }

    function __toString()
    {
        return "<br>Trying to echo out :)";
    }

    public static function __callStatic($name, $arguments)
    {
        $args = implode(',', $arguments);
        echo "<br>Calling static <b>$name</b> with: <b>$args</b>";
    }
}


test::testStaticCall('one', 'two');

$x = new test();
$x->something('one', 'two');
$x->cccc;
$x->bbb = 3;

echo $x;

