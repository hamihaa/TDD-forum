<?php
/**
 * Created by PhpStorm.
 * User: Miha
 * Date: 03-May-17
 * Time: 21:39
 */

function create($class, $attributes = [], $quantity = null)
{
    return factory($class, $quantity)->create($attributes);
}




function make($class, $attributes = [], $quantity = null)
{
    return factory($class, $quantity)->make($attributes);
}