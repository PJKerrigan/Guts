<?php
namespace Guts3\Cache;

//  Using declarations.

use \Guts3\Cache\ICacheable;
use \Guts3\Cache\Exceptions\ApcCacheException;
use \InvalidArgumentException;

/*
 *  Simple cache class. Wraps the APC extension.
 */
class ApcCache implements ICacheable {
    
    protected $data         = array();
    
    public function __construct() {
        
    }
    
    /*
     *  Sets a value for a key.
     */
    public function set($key, $value) {
        if (!apc_store(strtolower($key), $value)) {
            throw new ApcCacheException("Error setting value with key '$key' to APC cache.");
        }
        return $this;
    }
    
    /*
     *  Gets a value for a key.
     */
    public function get($key) {
        if ($this->exists($key)) {
            if (!$data = apc_fetch($key)) {
                throw new ApcCacheException("Error getting value with key '$key' from APC cache.");
            }
            return $data;
        }
        return NULL;
    }
    
    public function delete($key) {
        if ($this->exists($key)) {
            if (!apc_delete($key)) {
                throw new ApcCacheException("Error deleting value with key '$key' from APC cache.");
            }
        }
        return $this;
    }
    
    /*
     *  Tests whether a key exists.
     */
    public function exists($key) {
        return apc_exists($key);
    }
    
    /*
     *  Clears the cache.
     */
    public function clear($cacheType = "user") {
        return apc_clear_cache($cacheType);
    }
}