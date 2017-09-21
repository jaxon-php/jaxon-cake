<?php

namespace Jaxon\Cake\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;

class JaxonController extends AppController
{
    /**
     * Load the Jaxon component.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        // Load the Jaxon plugin
        $this->loadComponent('Jaxon/Cake.Jaxon');
    }

    /**
     * Callback for initializing a Jaxon class instance.
     * 
     * This function is called anytime a Jaxon class is instanciated.
     *
     * @param object            $instance               The Jaxon class instance
     *
     * @return void
     */
    public function initInstance($instance)
    {
    }

    /**
     * Callback before processing a Jaxon request.
     *
     * @param object            $instance               The Jaxon class instance to call
     * @param string            $method                 The Jaxon class method to call
     * @param boolean           $bEndRequest            Whether to end the request or not
     *
     * @return void
     */
    public function beforeRequest($instance, $method, &$bEndRequest)
    {
    }

    /**
     * Callback after processing a Jaxon request.
     *
     * @param object            $instance               The Jaxon class instance called
     * @param string            $method                 The Jaxon class method called
     *
     * @return void
     */
    public function afterRequest($instance, $method)
    {
    }

    /**
     * Process a Jaxon request.
     * 
     * The HTTP response is automatically sent back to the browser
     *
     * @return void
     */
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

        $this->Jaxon->onInit(function($instance){
            $this->initInstance($instance);
        });
        $this->Jaxon->onBefore(function($instance, $method, &$bEndRequest){
            $this->beforeRequest($instance, $method, $bEndRequest);
        });
        $this->Jaxon->onAfter(function($instance, $method){
            $this->afterRequest($instance, $method);
        });

        // Process Jaxon request
        if($this->Jaxon->canProcessRequest())
        {
            $this->Jaxon->processRequest();
        }
    }
}
