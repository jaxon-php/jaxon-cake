<?php

namespace Jaxon\Cake;

use Jaxon\Module\View\Store;
use Jaxon\Module\View\Facade;

class View extends Facade
{
    protected $view; // CakePHP View object

    public function __construct($view)
    {
        parent::__construct();
        $this->view = $view;
    }

    /**
     * Render a view
     * 
     * @param Store         $store        A store populated with the view data
     * 
     * @return string        The string representation of the view
     */
    public function make(Store $store)
    {
        // Render the template
        return trim($this->view->element($store->getViewPath(), $store->getViewData()), " \t\n");
    }
}
