<?php

namespace Jaxon\Cake;

use Cake\Http\Session;
use Cake\View\View;

class CakeView extends View
{
    /**
     * Get the session
     *
     * @return Session
     */
    public function getSession()
    {
        return $this->request->getSession();
    }
}
