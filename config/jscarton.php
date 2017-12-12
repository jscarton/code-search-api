<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    |
    | Here you will define which services are enabled for code search.
    | You should create CodeSearchApiWrapper descendant class
    | named as "CodeSearch{ServiceName}". 
    |
    | in example for github the class name for the wrapper is CodeSearchGithub.
    |
    | Currently supported services are: Github and Bitbucket    
    */

    'services' => ['Github']
];