<?php

namespace Jaxon\Cake;

class View
{
    protected $data;
    protected $view; // CakePHP View object

    public function __construct($view)
    {
        $this->data = array();
        $this->view = $view;
    }

    /**
     * Make a piece of data available for all views
     *
     * @param string        $name            The data name
     * @param string        $value           The data value
     * 
     * @return void
     */
    public function share($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Render a template, without a layout
     *
     * @param string        $template        The template path
     * @param string        $data            The template data
     * 
     * @return mixed        The rendered template
     */
    public function render($template, array $data = array())
    {
        return trim($this->view->element($template, array_merge($this->data, $data)), "\n");
    }
}
