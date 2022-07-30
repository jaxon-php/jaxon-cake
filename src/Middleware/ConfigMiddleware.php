<?php

/**
 * ConfigMiddleware.php
 *
 * Middleware to load Jaxon config.
 *
 * @package jaxon-core
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2022 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-core
 */

namespace Jaxon\Cake\Middleware;

use Cake\Routing\Router;
use Cake\Core\Configure;
use Jaxon\Cake\CakeView;
use Jaxon\Cake\View;
use Jaxon\Cake\Session;
use Jaxon\Cake\Logger;
use Jaxon\Request\Handler\Psr\PsrConfigMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function Jaxon\jaxon;
use function rtrim;

class ConfigMiddleware extends PsrConfigMiddleware
{
    /**
     * @var CakeView
     */
    private $xView = null;

    /**
     * The constructor
     */
    public function __construct()
    {
        parent::__construct(jaxon()->di(), rtrim(ROOT, '/') . '/config/jaxon.php');
    }

    /**
     * @return CakeView
     */
    private function view()
    {
        return $this->xView ?: ($this->xView = new CakeView());
    }

    /**
     * @inheritDoc
     * @throws SetupException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $xApp = $this->di->getApp();

        // Add the view renderer
        $xApp->addViewRenderer('cakephp', '', function() {
            return new View($this->view());
        });
        // Set the session manager
        $xApp->setSessionManager(function() {
            return new Session($this->view()->getSession());
        });
        // Set the logger
        $xApp->setLogger(new Logger());

        $bExport = $bMinify = (Configure::read('debug') === 0);
        $sJsUrl = rtrim(Router::fullBaseUrl(), '/') . '/jaxon/js';
        $sJsDir = rtrim(WWW_ROOT, '/') . '/jaxon/js';

        $xApp->asset($bExport, $bMinify, $sJsUrl, $sJsDir);

        return parent::process($request, $handler);
    }
}
