<?php 

class Router {

    public $request;
    public $method;
    public $requestUri;


    function __construct($request, $method) {
        $this->requestUri = filter_var($request, FILTER_SANITIZE_URL);
        $request = strtolower($request);
        $request = rtrim($request, '/');
        $request = filter_var($request, FILTER_SANITIZE_URL);
        $this->request = $request;
        $this->method = trim($method);
    }


    public function controller() {
        if ( $this->requestUri == '/' || $this->requestUri == '') {
            return 'index';
        } else {
            return explode('/', $this->request)[1];
        }
    }
   
}