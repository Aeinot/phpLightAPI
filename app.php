<?php

// Classes
require_once('classes/router.class');
require_once('classes/response.class');
require_once('classes/database.class');

// Config files
require_once('config/config.php');
require_once('config/routes.php');


function app($key){
    
    static $app_container = array("router" => null, "db" => null);

    if($app_container["router"] == null || $app_container["db"] == null){
        $app_container["router"] =  new Router();
        $app_container["db"] =  new Database();
    }

    if(!array_key_exists($key, $app_container)){
        throw new Exception('Unexpected key in app().');
    }

    return $app_container[$key];
}

app('router')->dispatch();