<?php
namespace Guts3;

//  Using declarations.
use \Exception;

/*
 *  Core framework class. Other objects are instantiated from within here:
 *  -   SessionHandler
 *  -   Cache
 *  -   Configuration
 */
class Core {
    //  Set of default paths for autoloader.
    protected $paths    = array(
                                "\private\includes",
                                "\private\library",
                                ""
                            );
    
    /*
     *  Constructor.
     */
    public function __construct() {
        $this->initialize(NULL, NULL);
    }
    
    /*
     *  
     */
    protected function initialize(callable $autoload = NULL, array $paths = NULL) {
        if (!defined("APP_ROOT")) {
            throw new Exception("Constant 'APP_ROOT' not defined.");
        }
        
        //  If paths have been provided, add them here.
        if (!is_null($paths)) {
            $this->addPaths($paths);
        }
        //  Ensure all paths are prefixed with the application-root path.
        $path_array     = array_map(function($item) {
                                        return APP_ROOT . $item;
                                    }, $this->paths);
        $path_array[]   = get_include_path();
        //  Apply our array of paths to the include path.
        set_include_path(join(PATH_SEPARATOR, $path_array));
        //  Register the autoload method.
        if (is_null($autoload)) {
            spl_autoload_register(array($this, "autoload"));
        } else {
            spl_autoload_register($autoload);
        }
    }
    
    /*
     *  Autoload method.
     */
    public function autoload( $class_name ) {
        $paths          = explode(PATH_SEPARATOR, get_include_path());
        $flags          = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
        $file_name      = strtolower(str_replace("\\", DIRECTORY_SEPARATOR, trim($class_name, "\\"))) . ".php";
            foreach ($paths as $path) {
            $combined   = $path . DIRECTORY_SEPARATOR . $file_name;
            if (file_exists($combined)) {
                include_once($combined);
                return TRUE;
            }
        }
        return FALSE;
    }
    
    /*
     *  Helper method. Sets an array of strings to the set of paths.
     */
    protected function addPaths(array $paths) {
        $this->paths    = array_merge($this->paths, $paths);
    }
    
    /*
     *  Gets the array of paths used when loading classes.
     */
    public function getPaths() {
        return $this->paths;
    }
}