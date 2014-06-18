<?php
namespace Guts3\Cache;

//  Using declarations.
use \Guts3\Cache\ICacheable;

/*
 *  A simple manager-class for use with ICacheable objects.
 */
class CacheHandler {
    protected $cacheable;
    
    /*
     *  Constructor.
     */
    public function __construct(ICacheable $cacheable) {
        $this->cacheable    = $cacheable;
    }
    
    public function set($key, $value) {
        return $this->cacheable->set($key, $value);
    }
    
    public function get($key) {
        return $this->cacheable->get($key);
    }
    
    public function delete($key) {
        return $this->cacheable->delete($key);
    }
    
    public function clear() {
        return $this->cacheable->clear();
    }
}