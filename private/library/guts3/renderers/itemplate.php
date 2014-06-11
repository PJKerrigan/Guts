<?php
namespace Guts3\Renderers;

/*
 *  Interface used by objects that need to load a template from a file.
 */
interface ITemplate {
    /*
     *  Sets the template file.
     */
    public function setFile($filename);
    
    /*
     *  Gets the template file.
     */
    public function getFile();
}