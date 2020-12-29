<?php

if(! function_exists("check")) {

    function check()
    {
        $auth = new Auth();
        return $auth->loginStatus();
    }
}

if(! function_exists("can")) {

   
    function can($permissions)
    {
        $auth = new Auth();
        return $auth->can($permissions);
    }
}

if(! function_exists("hasRole")) {
    
    function hasRole($roles)
    {
        $auth = new Auth();
        return $auth->hasRole($roles);
    }
}