<?php
namespace Guts3\Renderers;

//  Using declarations.
use \Guts3\Renderers\IRenderer;
use \InvalidArgumentException;

abstract class AbstractViewDecorator implements IRenderer {
    const DEFAULT_TEMPLATE      = "./private/templates/default.php";
    protected $file             = self::DEFAULT_TEMPLATE;
    protected $renderer;
    
    /*
     *  Constructor.
     */
    public function __construct(IRenderer $renderer) {
        $this->renderer         = $renderer;
    }
    
    /*
     *  Render method.
     */
    public function render() {
        return $this->renderer->render();
    }
    
    /*
     *  Render method employing a template.
     */
    public function renderTemplate(array $data = array()) {
        if (!is_null($data)) {
            extract($data);        
        }
        ob_start();
        include $this->file;
        return ob_get_clean();
    }
}

class OuterViewDecorator extends AbstractViewDecorator {
    public function render() {
        $data["inner_view"]     = $this->renderer->render();
        return $this->renderTemplate($data);
    }
}

class HeaderViewDecorator extends AbstractViewDecorator {
    public function render() {
        return $this->renderTemplate() . $this->renderer->render();
    }
}