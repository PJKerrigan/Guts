<?php
namespace Guts3\Application\ViewModels;

//  Using declarations.
use \Guts3\Application\Model;
use \Guts3\Application\ViewModel;
use \Exception;
use \InvalidArgumentException;

/*
 *  ViewModel used for errors.
 */
class ErrorViewModel extends ViewModel {
    
    public function getData() {
        return "here is some data, monkey.";
    }
}