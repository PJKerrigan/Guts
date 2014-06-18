<?php
namespace Guts3\Registry;

interface IRegistry {
    public function set($key, $value);
    public function get($key);
    public function clear();
}