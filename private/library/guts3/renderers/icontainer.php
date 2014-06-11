<?php
namespace Guts3\Renderers;

/*
 *  Container interface for object-access methods ($object->property = $value).
 */
interface IContainer {
    public function __get($key);
    public function __set($key, $value);
    public function __isset($key);
    public function __unset($key);
}