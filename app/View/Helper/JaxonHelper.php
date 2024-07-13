<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Jaxon\Script\JsExpr;
use Jaxon\Script\JxnCall;

use function Jaxon\attr;

class JaxonHelper extends Helper
{
    /**
     * Get the component HTML code
     *
     * @param JxnCall $xJsCall
     *
     * @return string
     */
    public function html(JxnCall $xJsCall): string
    {
        return attr()->html($xJsCall);
    }

    /**
     * Attach a component to a DOM node
     *
     * @param JxnCall $xJsCall
     * @param string $item
     *
     * @return string
     */
    public function show(JxnCall $xJsCall, string $item = ''): string
    {
        return attr()->show($xJsCall, $item);
    }

    /**
     * Set a node as a target for event handler definitions
     *
     * @param string $name
     *
     * @return string
     */
    public function target(string $name = ''): string
    {
        return attr()->target($name);
    }

    /**
     * Set an event handler
     *
     * @param string|array $on
     * @param JsExpr $xJsExpr
     * @param array $options
     *
     * @return string
     */
    public function on(string|array $on, JsExpr $xJsExpr, array $options = []): string
    {
        return attr()->on($on, $xJsExpr, $options);
    }
}
