<?php

if (!function_exists("chalk")) {

    /**
     * get a new instance of Chalk object
     *
     * @param string $stack_name
     *
     * @return \Dutymess\Chalk\Chalk
     */
    function chalk($stack_name = 'default')
    {
        return new \Dutymess\Chalk\Chalk($stack_name);
    }
}
