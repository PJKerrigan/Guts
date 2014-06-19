<?php
namespace Guts3\Routing;

interface IRouterRule {
    public function find(array $route);
}