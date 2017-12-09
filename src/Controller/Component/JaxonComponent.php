<?php

namespace Jaxon\Cake\Controller\Component;

use Jaxon\Cake\View;
use Jaxon\Cake\Session;

use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\Core\Configure;

class JaxonComponent extends Component
{
    use \Jaxon\Sentry\Traits\Armada;

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
        $this->_jaxonSetup();
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * @return void
     */
    protected function jaxonSetup()
    {
        $isDebug = (Configure::read('debug') > 0);
        $appPath = rtrim(ROOT, '/');
        $baseUrl = rtrim(Router::fullBaseUrl(), '/');
        $baseDir = rtrim(WWW_ROOT, '/');

        $jaxon = jaxon();
        $sentry = $jaxon->sentry();

        // Read and set the config options from the config file
        $this->appConfig = $jaxon->readConfigFile($appPath . '/config/jaxon.php', 'lib', 'app');
        // The request URI can be set with a named route
        if(!$jaxon->hasOption('core.request.uri') && ($route = $this->appConfig->getOption('request.route', null)))
        {
            try
            {
                // This call throws an exception if the named route is not found.
                $url = Router::url(['_name' => $route]);
                $jaxon->setOption('core.request.uri', $url);
            }
            catch(\Exception $e){}
        }

        // Jaxon library default settings
        $sentry->setLibraryOptions(!$isDebug, !$isDebug, $baseUrl . '/jaxon/js', $baseDir . '/jaxon/js');

        // Set the default view namespace
        $sentry->addViewNamespace('default', '', '', 'cakephp');
        $this->appConfig->setOption('options.views.default', 'default');

        // Add the view renderer
        $registry = $this->_registry;
        $sentry->addViewRenderer('cakephp', function () use ($registry) {
            return new View($registry->getController()->createView());
        });

        // Set the session manager
        $session = $this->request->session();
        $sentry->setSessionManager(function () use ($session) {
            return new Session($session);
        });
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * This method needs to set at least the Jaxon request URI.
     *
     * @return void
     */
    protected function jaxonCheck()
    {
        // Todo: check the mandatory options
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
