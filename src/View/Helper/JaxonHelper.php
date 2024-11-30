<?php

namespace Jaxon\Cake\View\Helper;

use Cake\View\Helper;
use Jaxon\Script\JsExpr;
use Jaxon\Script\JxnCall;
use Jaxon\Utils\Http\UriException;

use function Jaxon\attr;
use function Jaxon\jaxon;

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
    public function bind(JxnCall $xJsCall, string $item = ''): string
    {
        return attr()->bind($xJsCall, $item);
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
    public function on(string|array $on, JsExpr $xJsExpr): string
    {
        return attr()->on($on, $xJsExpr);
    }

    /**
     * Set an event handler
     *
     * @param JsExpr $xJsExpr
     * @param array $options
     *
     * @return string
     */
    public function click(JsExpr $xJsExpr): string
    {
        return attr()->click($xJsExpr);
    }

    /**
     * Set an event handler
     *
     * @param array $on
     * @param JsExpr $xJsExpr
     * @param array $options
     *
     * @return string
     */
    public function event(array $on, JsExpr $xJsExpr): string
    {
        return attr()->event($on, $xJsExpr);
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
     * Get the HTML tags to include Jaxon javascript files into the page.
     *
     * @return string  the javascript code
     */
    public function js(): string
    {
        return jaxon()->getJs();
    }

    /**
     * Get the HTML tags to include Jaxon CSS code and files into the page.
     *
     * @return string
     */
    public function css(): string
    {
        return jaxon()->getCss();
    }

    /**
     * Returns the js header and wrapper code to be printed into the page
     *
     * @param bool $bIncludeJs    Also get the js code
     * @param bool $bIncludeCss    Also get the css code
     *
     * @return string  the javascript code
     * @throws UriException
     */
    public function script(bool $bIncludeJs = false, bool $bIncludeCss = false): string
    {
        return jaxon()->getScript($bIncludeJs, $bIncludeCss);
    }
}
