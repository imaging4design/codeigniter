<?php

class MY_Router extends CI_Router
{

    public function __construct($routing = NULL)
    {
        parent::__construct($routing);
    }

    protected function _set_default_controller() 
    {
        $this->directory = 'site/';
        parent::_set_default_controller();
    }

} 