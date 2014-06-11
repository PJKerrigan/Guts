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
class HomeViewModel extends ViewModel {
    
    /*
     *  Constructor.
     */
    public function __construct(Model $model) {
        parent::__construct($model);
        
        $this->head_css     = "./public/css/main.css";
    }
    
    /*
     *  Gets the template file to use for the page.
     */
    public function getTemplate() {
        return "./private/templates/grid_layout.php";
    }
    
    /*
     *  Gets the page title.
     */
    public function getTitle() {
        return "Title | " . time(); 
    }
}
