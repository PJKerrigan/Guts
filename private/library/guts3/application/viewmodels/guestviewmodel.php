<?php
namespace Guts3\Application\ViewModels;

//  Using declarations.
use \Guts3\Application\Model;
use \Guts3\Application\ViewModel;
use \Exception;
use \InvalidArgumentException;

class GuestViewModel extends ViewModel {
    
    /*
     *  Constructor.
     */
    public function __construct(Model $model) {
        parent::__construct($model);
        
        $this->set("template", "./private/templates/grid_layout.php");
    }
}