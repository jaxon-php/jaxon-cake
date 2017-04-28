<?php

namespace Jaxon\Cake;

use Jaxon\Module\View\Store;
use Jaxon\Module\Interfaces\View as ViewInterface;

class View implements ViewInterface
{
    protected $view; // CakePHP View object

    public function __construct($view)
    {
        $this->view = $view;
    }

    /**
     * Add a namespace to this view renderer
     *
     * @param string        $sNamespace         The namespace name
     * @param string        $sDirectory         The namespace directory
     * @param string        $sExtension         The extension to append to template names
     *
     * @return void
     */
    public function addNamespace($sNamespace, $sDirectory, $sExtension = '')
    {}

    /**
     * Render a view
     * 
     * @param Store         $store        A store populated with the view data
     * 
     * @return string        The string representation of the view
     */
    public function render(Store $store)
    {
        // Render the template
        return trim($this->view->element($store->getViewName(), $store->getViewData()), " \t\n");
    }
}
