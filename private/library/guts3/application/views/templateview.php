<?php
namespace Guts3\Application\Views;

//  Using declarations.
use \Guts3\Application\View;
use \Guts3\Application\ViewModel;
use \Guts3\Application\ViewModels\HomeViewModel;
use \Guts3\Renderers\CompositeTemplate;
use \Exception;
use \InvalidArgumentException;

/*
 *  View class taking advantage of PHP templates.
 */
class TemplateView extends View {

    /*
     *  Constructor.
     */
    public function __construct($route, ViewModel $viewModel) {
        View::__construct($route, $viewModel);
    }
    
    /*
     *  Output method. Creates a template and loads it.
     */
    public function output() {
        //  Get the template file-path from the ViewModel.
        $filename           = $this->viewModel->get("template");
        
        //  Create an array to fill with our data.
        $data               = array();
        $data["head_title"] = $this->viewModel->get("head_title");
        $data["stylesheet"] = $this->viewModel->get("head_css");
        
        //  Construct the template.
        $template           = new CompositeTemplate($filename, $data);
        
        //  Draw the template.
        return $template->render();
    }
}