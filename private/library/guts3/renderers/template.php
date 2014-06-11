<?php
namespace Guts3\Renderers;

//  Using declarations.
use \Guts3\Renderers\IRenderer;
use \Exception;
use \InvalidArgumentException;

/*
 *  Simple template class.
 */
class Template implements IRenderer {
    
    protected $file;
    protected $data     = array();
    
    /*
     *  Constructor.
     */
    public function __construct($filename, array $data = NULL) {
        $this->setFile($filename);
        
        if (!is_null($data)) {
            $this->data = $data;
        }
    }
    
    /*
     *  Sets the template file.
     */
    public function setFile($file) {
        if (!is_file($file) or !is_readable($file)) {
            throw new InvalidArgumentException("Parameter ($file) must point to a valid file.");
        }
        $this->file     = $file;
        return $this;
    }
    
    /*
     *  Gets the template file.
     */
    public function getFile() {
        return $this->file;
    }
    
    /*
     *  Render method. Loads a template from a file and displays it.
     */
    public function render() {
        extract($this->data);
        ob_start();
        include($this->file);
        $output     = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}