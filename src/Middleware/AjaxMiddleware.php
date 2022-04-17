<?php

/**
 * AjaxMiddleware.php
 *
 * Middleware to process Jaxon ajax request.
 *
 * @package jaxon-core
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2022 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-core
 */

namespace Jaxon\Cake\Middleware;

use Jaxon\Request\Handler\Psr\PsrAjaxMiddleware;
 
class AjaxMiddleware extends PsrAjaxMiddleware
{
    /**
     * The constructor
     */
    public function __construct()
    {
        $di = \jaxon()->di();
        parent::__construct($di, $di->getRequestHandler(), $di->getResponseManager());
    }
}
