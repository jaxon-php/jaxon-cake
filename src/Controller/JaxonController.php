<?php

namespace Jaxon\Cake\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;

class JaxonController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        // Load the Jaxon plugin
        $this->loadComponent('Jaxon/Cake.Jaxon');
    }

    public function index()
    {
        if(substr(Configure::version(), 0, 3) != '3.0')
        {
            $this->viewBuilder()->layout('ajax');
        }
        else
        {
            $this->layout = 'ajax';
        }
        // Process Jaxon request
        if($this->Jaxon->canProcessRequest())
        {
            $this->Jaxon->processRequest();
        }
    }
}
