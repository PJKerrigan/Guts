<?php
namespace Guts3\Cache;

/*
 *  Common interface implemented by cache systems.
 */
interface ICacheable {
    public function set($key, $value);
    public function get($key);
    public function delete($key);
    public function exists($key);
    public function clear();
}