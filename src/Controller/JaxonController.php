<?php

namespace Jaxon\Cake\Controller;

use App\Controller\AppController;

class JaxonController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        // Load the Jaxon plugin
        $this->loadComponent('Jaxon');
    }

    public function index()
    {
        // Process Jaxon request
        if($this->Jaxon->canProcessRequest())
        {
            $this->Jaxon->processRequest();
        }
    }
}
