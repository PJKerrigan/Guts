<?php
namespace Guts3\Renderers;

//  Using declarations.
use \Guts3\Renderers\ITemplate;
use \Guts3\Renderers\IContainer;
use \Guts3\Renderers\IRenderer;
use \Exception;
use \InvalidArgumentException;

/*
 *  Composite template capable of containing nested instances of itself.
 */
class CompositeTemplate implements IContainer, ITemplate, IRenderer {
    const DEFAULT_FILE      = "./private/templates/grid_layout.php";
    protected $file         = self::DEFAULT_FILE;
    protected $data         = array();
    
    /*
     *  Constructor.
     */
    public function __construct($file, array $data = NULL) {
        $this->setFile($file);
        
        if (!is_null($data)) {
            foreach($data as $field => $value) {
                $this->$field   = $value;
            }
        }
    }
    
    /*
     *  Sets the template file to use.
     */
    public function setFile($file) {
        if (!is_file($file) or !is_readable($file)) {
            throw new InvalidArgumentException("Parameter '{$file}' must point to a valid file.");
        }   
        
        $this->file             = $file;
        return $this;
    }
    
    /*
     *  Gets the template file.
     */
    public function getFile() {
        return $this->file;
    }
    
    /*
     *  Sets a value into the template's collection of values.
     */
    public function __set($key, $value) {
        $this->data[$key]   = $value;   
        return $this;
    }
    
    /*
     *  Gets a value from the template's collection of values.
     */
    public function __get($key) {
        if (!isset($this->data[$key])) {
            throw new InvalidArgumentException("Field '{$key}' not set.");
        }

        $item               = $this->data[$key];
        return $item instanceof Closure ? $item($this) : $item;
    }
    
    /*
     *  Checks if a key has a value assigned to it.
     */
    public function __isset($key) {
        return isset($this->data[$key]);
    }
    
    /*
     *  Unset a key value.
     */
    public function __unset($key) {
        if (!isset($this->data[$key])) {
            throw new InvalidArgumentException("Field '{$key}' not set.");
        }
    }
    
    /*
     *  Renders the composite-template file to the output.
     */
    public function render() {
        extract($this->data);
        ob_start();
        include $this->file;
        return ob_get_clean();
    }
}