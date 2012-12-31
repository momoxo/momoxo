<?php

namespace XCore\Kernel;

use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;

class Session
{
    /**
     * @var string
     * @readonly
     */
    public $mSessionName = '';

    /**
     * @var int
     * @readonly
     */
    public $mSessionLifetime = 0;

    /**
     * @var Delegate
     * @readonly
     */
    public $mSetupSessionHandler = null;

    /**
     * @var Delegate
     * @readonly
     */
    public $mGetSessionCookiePath = null;

    /**
     * Return new Session instance
     * @param string $sessionName
     * @param int    $sessionExpire
     */
    public function __construct($sessionName = '', $sessionExpire = 0)
    {
        $this->setParam($sessionName, $sessionExpire);

        $this->mSetupSessionHandler = new Delegate();
        $this->mSetupSessionHandler->register('XCore.Kernel.Session.SetupSessionHandler');

        $this->mGetSessionCookiePath = new Delegate();
        $this->mGetSessionCookiePath->register('XCore.Kernel.Session.GetSessionCookiePath');
    }

    /**
     * @param  string $sessionName
     * @param  int    $sessionExpire
     * @return void
     */
    public function setParam($sessionName = '', $sessionExpire = 0)
    {
        $allIniArray = ini_get_all();

        if ($sessionName != '') {
            $this->mSessionName = $sessionName;
        } else {
            $this->mSessionName = $allIniArray['session.name']['global_value'];
        }

        if ( !empty($sessionExpire) ) {
            $this->mSessionLifetime = 60 * $sessionExpire;
        } else {
            $this->mSessionLifetime = $allIniArray['session.cookie_lifetime']['global_value'];
        }
    }

    /**
     * @return void
     */
    public function start()
    {
        $this->mSetupSessionHandler->call();

        session_name($this->mSessionName);
        session_set_cookie_params($this->mSessionLifetime, $this->_cookiePath());

        session_start();

        if ( !empty($this->mSessionLifetime) && isset($_COOKIE[$this->mSessionName]) ) {
            // Refresh lifetime of Session Cookie
            setcookie($this->mSessionName, session_id(), time() + $this->mSessionLifetime, $this->_cookiePath());
        }
    }

    /**
     * @param  bool $forceCookieClear
     * @return void
     */
    public function destroy($forceCookieClear = false)
    {
        // If current session name is not same as config value.
        // Session cookie should be clear
        // (This case will occur when session config params are changed in preference screen.)
        $currentSessionName = session_name();
        if ( isset($_COOKIE[$currentSessionName]) ) {
            if ( $forceCookieClear || ($currentSessionName != $this->mSessionName) ) {
                // Clearing Session Cookie
                setcookie($currentSessionName, '', time() - 86400, $this->_cookiePath());
            }
        }
        session_destroy();
    }

    /**
     * @return void
     */
    public function regenerate()
    {
        $oldSessionID = session_id();
        session_regenerate_id();
        $newSessionID = session_id();
        session_id($oldSessionID);
        $this->destroy();
        $oldSession = $_SESSION;
        session_id($newSessionID);
        $this->start();
        $_SESSION = array();
        foreach (array_keys($oldSession) as $key) {
            $_SESSION[$key] = $oldSession[$key];
        }
    }

    /**
     * @return void
     */
    public function rename()
    {
        if ( session_name() != $this->mSessionName ) {
            $oldSessionID = session_id();
            $oldSession = $_SESSION;
            $this->destroy();
            session_id($oldSessionID);
            $this->start();
            $_SESSION = array();
            foreach (array_keys($oldSession) as $key) {
                $_SESSION[$key] = $oldSession[$key];
            }
        }
    }

    /**
     * @return string
     */
    private function _cookiePath()
    {
        static $sessionCookiePath = null;
        if ( empty($sessionCookiePath) ) {
            $this->mGetSessionCookiePath->call(new Ref($sessionCookiePath));
            if ( empty($sessionCookiePath) ) {
                $sessionCookiePath = '/';
            }
        }

        return $sessionCookiePath;
    }
}
