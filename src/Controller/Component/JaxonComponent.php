<?php

namespace Jaxon\Cake\Controller\Component;

use Jaxon\Cake\View;
use Jaxon\Cake\Session;
use Jaxon\Cake\Logger;

use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\Core\Configure;

class JaxonComponent extends Component
{
    use \Jaxon\Features\App;

    /**
     * The logger engine
     *
     * By default, Jaxon will use the CakePHP "error" logger.
     *
     * @var string
     */
    protected $loggerEngine = 'error';

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
        if(\array_key_exists('logger', $config))
        {
            $this->loggerEngine = $config['logger'];
        }
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
        $viewManager = $di->getViewManager();
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

        // Set the logger
        /*if(($logger = Log::engine($this->loggerEngine)))
        {
            $this->setLogger($logger);
        }*/
        $this->setLogger(new Logger());

        $this->bootstrap()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            // ->uri($sUri)
            ->js(!$bIsDebug, $sJsUrl, $sJsDir, !$bIsDebug)
            ->run();

        // Prevent the Jaxon library from sending the response or exiting
        $jaxon->setOption('core.response.send', false);
        $jaxon->setOption('core.process.exit', false);
    }

    /**
     * Get the HTTP response
     *
     * @param string    $code       The HTTP response code
     *
     * @return mixed
     */
    public function httpResponse($code = '200')
    {
        $jaxon = jaxon();
        // Get the reponse to the request
        $jaxonResponse = $jaxon->di()->getResponseManager()->getResponse();
        if(!$jaxonResponse)
        {
            $jaxonResponse = $jaxon->getResponse();
        }

        // Fill and return the CakePHP HTTP response
        $this->response->type($jaxonResponse->getContentType());
        $this->response->charset($jaxonResponse->getCharacterEncoding());
        $this->response->body($jaxonResponse->getOutput());
        $this->response->statusCode($code);
        return $this->response;
    }

    /**
     * Process an incoming Jaxon request, and return the response.
     *
     * @return mixed
     */
    public function processRequest()
    {
        // Process the jaxon request
        jaxon()->processRequest();

        // Return the reponse to the request
        return $this->httpResponse();
    }
}
