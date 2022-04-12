<?php

namespace Jaxon\Cake\Controller\Component;

use Jaxon\Cake\View;
use Jaxon\Cake\Session;
use Jaxon\Cake\Logger;

use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\Core\Configure;

use function rtrim;
use function intval;
use function jaxon;

class JaxonComponent extends Component
{
    use \Jaxon\App\AppTrait;

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
    public function initialize(array $config): void
    {
        if(isset($config['logger']))
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
        // Set the default view namespace
        $this->addViewNamespace('default', '', '', 'cakephp');
        // Add the view renderer
        $this->addViewRenderer('cakephp', function () {
            return new View($this->getController()->createView());
        });
        // Set the session manager
        $this->setSessionManager(function () {
            return new Session($this->getController()->getRequest()->getSession());
        });
        // Set the logger
        /*if(($logger = Log::engine($this->loggerEngine)))
        {
            $this->setLogger($logger);
        }*/
        $this->setLogger(new Logger());

        $bIsDebug = (Configure::read('debug') > 0);
        $sAppPath = rtrim(ROOT, '/');
        $sJsUrl = rtrim(Router::fullBaseUrl(), '/') . '/jaxon/js';
        $sJsDir = rtrim(WWW_ROOT, '/') . '/jaxon/js';

        // Read the config options.
        $aOptions = $this->jaxon->readConfig($sAppPath . '/config/jaxon.php');
        $aLibOptions = $aOptions['lib'] ?? [];
        $aAppOptions = $aOptions['app'] ?? [];

        $this->bootstrap()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            ->asset(!$bIsDebug, !$bIsDebug, $sJsUrl, $sJsDir)
            ->setup();
    }

    /**
     * @inheritDoc
     */
    public function httpResponse(string $sCode = '200')
    {
        // Get the reponse to the request
        $ajaxResponse = $this->ajaxResponse();

        // Fill and return the CakePHP HTTP response
        return $this->getController()->getResponse()
            ->withType($ajaxResponse->getContentType())
            ->withCharset($this->getCharacterEncoding())
            ->withStringBody($ajaxResponse->getOutput())
            ->withStatus(intval($sCode));
    }
}
