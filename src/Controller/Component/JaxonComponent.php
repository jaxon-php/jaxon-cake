<?php

namespace Jaxon\Cake\Controller\Component;

use Jaxon\Cake\View;
use Jaxon\Cake\Session;

use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\Core\Configure;

class JaxonComponent extends Component
{
    use \Jaxon\Features\App;

    /**
     * Constructor hook method.
     *
     * Implement this method to avoid having to overwrite the constructor and call parent.
     *
     * @param array $config The configuration settings provided to this component.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        // Initialize the Jaxon plugin
        $this->setupJaxon();
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * @return void
     */
    protected function setupJaxon()
    {
        $bIsDebug = (Configure::read('debug') > 0);
        $sAppPath = rtrim(ROOT, '/');
        $sJsUrl = rtrim(Router::fullBaseUrl(), '/') . '/jaxon/js';
        $sJsDir = rtrim(WWW_ROOT, '/') . '/jaxon/js';

        $jaxon = jaxon();
        // Read the config options.
        $aOptions = $jaxon->config()->read($sAppPath . '/config/jaxon.php');
        $aLibOptions = key_exists('lib', $aOptions) ? $aOptions['lib'] : [];
        $aAppOptions = key_exists('app', $aOptions) ? $aOptions['app'] : [];

        // The request URI can be set with a named route
        // if(!$jaxon->hasOption('core.request.uri') && ($route = $this->appConfig->getOption('request.route', null)))
        // {
        //     try
        //     {
        //         // This call throws an exception if the named route is not found.
        //         $url = Router::url(['_name' => $route]);
        //         $this->jaxon()->uri($url);
        //     }
        //     catch(\Exception $e){}
        // }

        $di = $jaxon->di();
        $viewManager = $di->getViewmanager();
        // Set the default view namespace
        $viewManager->addNamespace('default', '', '', 'cakephp');
        // Add the view renderer
        $viewManager->addRenderer('cakephp', function () {
            return new View($this->_registry->getController()->createView());
        });

        // Set the session manager
        $di->setSessionManager(function () {
            return new Session($this->request->session());
        });

        $this->jaxon()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            // ->uri($sUri)
            ->js(!$bIsDebug, $sJsUrl, $sJsDir, !$bIsDebug)
            ->bootstrap(false);
    }

    /**
     * Wrap the Jaxon response into an HTTP response.
     *
     * @param  $code        The HTTP Response code
     *
     * @return HTTP Response
     */
    public function httpResponse($code = '200')
    {
        // Fill and return the CakePHP HTTP response
        $this->response->type($this->ajaxResponse()->getContentType());
        $this->response->charset($this->ajaxResponse()->getCharacterEncoding());
        $this->response->body($this->ajaxResponse()->getOutput());
        $this->response->statusCode($code);
        return $this->response;
    }
}
