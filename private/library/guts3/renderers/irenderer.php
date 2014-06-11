<?php
namespace Guts3\Renderers;

/*
 *  All objects that output to the screen must implement this interface. Used
 *  by the View.
 */
interface IRenderer {
    /*
     *  Renders the object.
     */
    public function render();
}