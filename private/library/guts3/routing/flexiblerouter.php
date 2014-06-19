<?php
namespace Guts3\Routing;

//  Using declarations.
use \Guts3\Routing\IRouterRule;
use \Exception;
use \InvalidArgumentException;

/*
 *  Flexible router.
 */
class FlexibleRouter {
    protected $rules        = array();
    
    /*
     *  Adds a rule to the router.
     */
    public function addRule(IRouterRule $rule) {
        $this->rules[]      = $rule;
    }
    
    /*
     *  Gets a route by iterating over the rule array and testing
     *  each rule.
     */
    public function getRoute(array $route) {
        //  Iterate over the list of rules to check for matches.
        foreach ($this->rules as $rule) {
            if ($found      = $rule->find($route)) {
                return $found;
            }
        }
        
        //  If the default rule is set, use that.
        if (isset($this->rules["default"])) {
            return $this->rules["default"];
        }
        
        throw new Exception("Matching route was not found.");
    }
}