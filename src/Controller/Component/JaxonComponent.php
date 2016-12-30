<?php

namespace Jaxon\Cake\Controller\Component;

use Jaxon\Config\Php as Config;
use Jaxon\Cake\View;

use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\Core\Configure;

class JaxonComponent extends Component
{
    use \Jaxon\Module\Traits\Module;

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

        // Read and set the config options from the config file
        $this->appConfig = Config::read($appPath . '/config/jaxon.php', 'lib', 'app');

        // Jaxon library default settings
        $this->setLibraryOptions(!$isDebug, !$isDebug, $baseUrl . '/jaxon/js', $baseDir . '/jaxon/js');

        // Jaxon application default settings
        $this->setApplicationOptions($appPath . '/jaxon/Controller', '\\Jaxon\\App');

        // Jaxon controller class
        $this->setControllerClass('\\Jaxon\\Cake\\Controller');
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
     * Return the view renderer.
     *
     * @return void
     */
    protected function jaxonView()
    {
        if($this->jaxonViewRenderer == null)
        {
            $this->jaxonViewRenderer = new View($this->_registry->getController()->createView());
        }
        return $this->jaxonViewRenderer;
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
        $this->response->type($this->jaxonResponse->getContentType());
        $this->response->charset($this->jaxonResponse->getCharacterEncoding());
        $this->response->body($this->jaxonResponse->getOutput());
        $this->response->statusCode($code);
        return $this->response;
    }
}
