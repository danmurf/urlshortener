<?php
namespace App\Library;

class Router {

    private $routes;

    /**
     * Register a get route
     * @method get
     * @param  string $path       The URL path
     * @param  string $controller The destination controller
     * @param  string $method     The method within the destination controller
     */
    public function get($path, $controller, $method) {
        $this->registerRoute('GET', $path, $controller, $method);
    }

    /**
     * Register a post route
     * @method post
     * @param  string $path       The URL path
     * @param  string $controller The destination controller
     * @param  string $method     The method within the destination controller
     */
    public function post($path, $controller, $method) {
        $this->registerRoute('POST', $path, $controller, $method);
    }

    /**
     * Register a route
     * @method registerRoute
     * @param  string $type       The request type (GET, POST, etc.)
     * @param  string $path       The URL path
     * @param  string $controller The destination controller
     * @param  string $method     The method within the destination controller
     */
    private function registerRoute($type, $path, $controller, $method) {
        $this->routes[$type][$path]['controller'] = $controller;
        $this->routes[$type][$path]['method'] = $method;
    }

    /**
     * Get the path the user is currently accessing
     * @method path
     * @return string  The URL path
     */
    private function path() {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * Get the request type the user has submitted
     * @method requestType
     * @return string   GET, POST, etc.
     */
    private function requestType() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Extract the destination parameters from the URL path and add them to the
     * destination
     * @method setDestinationParameters
     * @param  array   $destination The URL path the user is accessing
     */
    private function setDestinationParameters($destination) {
        $parameters = explode('/', $this->path());
        $destination['parameter'] = $parameters[1];
        return $destination;
    }

    /**
     * Check to see if there is a named route for the path the user is
     * currently accessing
     * @method checkForMatch
     * @return array        The destination controller, method, and parameter
     */
    private function checkForMatch() {
        foreach ($this->routes[$this->requestType()] as $path => $destination) {
            if ($this->path() === $path) {
                return $destination;
            }
        }

        //No match found, so use the route with the parameter
        return $this->setDestinationParameters($this->routes['GET']['/{param}']);
    }

    /**
     * Start the routing process
     * @method dispatch
     */
    public function dispatch() {
        $destination = $this->checkForMatch();
        $this->handleRequest($destination);
    }

    /**
     * Point the user's request to the correct destination
     * @method handleRequest
     * @param  array        $destination Destination controller, method, and parameter
     */
    private function handleRequest($destination) {

        //Fetch the parameter, if there was one
        if (isset($destination['parameter'])) {
            $parameter = $destination['parameter'];
        }
        else {
            $parameter = null;
        }

        //Fire off the method/controller and pass the parameter
        $controller = new $destination['controller'];
        $controller->{$destination['method']}($parameter);
    }

}
