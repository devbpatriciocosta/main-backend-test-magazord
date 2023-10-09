<?php

    spl_autoload_register(function($class){

        $archive= __DIR__."/".$class.".php";
        $archive=str_replace("\\","/",$archive);

        if(is_file($archive)){
            require_once $archive;
        } 
    });