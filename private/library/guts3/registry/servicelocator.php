<?php
namespace Guts3\Registry {
    
    //  Using declarations.
    use \Exception;
    use \InvalidArgumentException;
    
    /*
     *  Service locator, instantiates and stores objects.
     */
    class ServiceLocator {
        private static $objects     = array();
        private static $settings    = array();
        private static $instance;
        
        /*
         *  Singleton requires a private constructor.
         */
        private function __construct() { }
        
        /*
         *  Clone method. Simply triggers an E_USER_ERROR if called.
         */
        public function __clone() {
            trigger_error("Singleton pattern mandates only one instance.", E_USER_ERROR);
        }
        
        /*
         *  Stores an object inside of the service-locator.
         */
        public function storeObject($key, $object) {
            self::$objects[$key]    = new $object(self::$instance);
        }
        
        /*
         *  Gets an object from the service-locator.
         */
        public function getObject($key) {
            if (is_object(self::$objects[$key])) {
                return self::$objects[$key];
            }
        }
        
        /*
         *  Stores settings in the settings array.
         */
        public function storeSetting($key, $data) {
            self::$settings[$key]   = $data;
        }
        
        /*
         *  Gets settings from the settings array.
         */
        public function getSetting($key) {
            return self::$settings[$key];
        }
        
        /*
         *  Gets the singleton instance.
         */
        public static function getInstance() {
            return (self::$instance instanceof self) ? self::$instance : (self::$instance = new self());
        }
    }
}