<?php

namespace Jaxon\Cake;

use Cake\Utility\Hash;
use Jaxon\App\Session\SessionInterface;

class Session implements SessionInterface
{
    /**
     * The CakePHP session
     *
     * @var object
     */
    protected $xSession = null;

    public function __construct($xSession)
    {
        $this->xSession = $xSession;
    }

    /**
     * Get the current session id
     *
     * @return string           The session id
     */
    public function getId(): string
    {
        return $this->xSession->id();
    }

    /**
     * Generate a new session id
     *
     * @param bool          $bDeleteData         Whether to delete data from the previous session
     *
     * @return void
     */
    public function newId($bDeleteData = false)
    {
        if($bDeleteData)
        {
            $this->clear();
        }
        $this->xSession->renew();
    }

    /**
     * Save data in the session
     *
     * @param string        $sKey                The session key
     * @param string        $xValue              The session value
     *
     * @return void
     */
    public function set($sKey, $xValue)
    {
        $this->xSession->write($sKey, $xValue);
    }

    /**
     * Check if a session key exists
     *
     * @param string        $sKey                The session key
     *
     * @return bool             True if the session key exists, else false
     */
    public function has($sKey): bool
    {
        return $this->xSession->check($sKey);
    }

    /**
     * Get data from the session
     *
     * @param string        $sKey                The session key
     * @param string        $xDefault            The default value
     *
     * @return mixed|$xDefault             The data under the session key, or the $xDefault parameter
     */
    public function get($sKey, $xDefault = null)
    {
        return $this->has($sKey) ? $this->xSession->read($sKey) : $xDefault;
    }

    /**
     * Get all data in the session
     *
     * @return array             An array of all data in the session
     */
    public function all(): array
    {
        return $this->xSession->read();
    }

    /**
     * Delete a session key and its data
     *
     * @param string        $sKey                The session key
     *
     * @return void
     */
    public function delete($sKey)
    {
        $this->xSession->delete($sKey);
    }

    /**
     * Delete all data in the session
     *
     * @return void
     */
    public function clear()
    {
        // $this->xSession->clear(); // This does not work
        foreach($this->all() as $key => $value)
        {
            $this->delete($key);
        }
    }
}
