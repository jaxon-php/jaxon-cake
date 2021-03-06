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
    public function initialize(): void
    {
        parent::initialize();
        // Load the Jaxon plugin
        $this->loadComponent('Jaxon/Cake.Jaxon');
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
        $this->viewBuilder()->setLayout('ajax');

        // $this->Jaxon->callback()->before(function ($target, &$bEndRequest) {
        //     if($target->isFunction())
        //     {
        //         $function = $target->getFunctionName();
        //     }
        //     elseif($target->isClass())
        //     {
        //         $class = $target->getClassName();
        //         $method = $target->getMethodName();
        //         // $instance = $this->Jaxon->instance($class);
        //     }
        // });
        // $this->Jaxon->callback()->after(function ($target, $bEndRequest) {
        //     if($target->isFunction())
        //     {
        //         $function = $target->getFunctionName();
        //     }
        //     elseif($target->isClass())
        //     {
        //         $class = $target->getClassName();
        //         $method = $target->getMethodName();
        //     }
        // });

        // Process Jaxon request
        if($this->Jaxon->canProcessRequest())
        {
            return $this->Jaxon->processRequest();
        }
    }
}
