<?php

namespace Jaxon\Cake;

use Cake\View\View as CakeView;
use Jaxon\App\View\Store;
use Jaxon\App\View\ViewInterface;

use function trim;

class View implements ViewInterface
{
    /**
     * @var CakeView
     */
    protected $xView;

    /**
     * The constructor
     *
     * @param CakeView $xView
     */
    public function __construct(CakeView $xView)
    {
        $this->xView = $xView;
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
    public function addNamespace(string $sNamespace, string $sDirectory, string $sExtension = '')
    {}

    /**
     * Render a view
     *
     * @param Store         $store        A store populated with the view data
     *
     * @return string
     */
    public function render(Store $store): string
    {
        // Render the template
        return trim($this->xView->element($store->getViewName(), $store->getViewData()), " \t\n");
    }
}
