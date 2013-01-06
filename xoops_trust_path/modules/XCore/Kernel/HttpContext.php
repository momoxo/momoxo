<?php

namespace XCore\Kernel;

use XCore\Kernel\AbstractRequest;
use XCore\Kernel\Principal;

/**
 * Encapsulates major HTTP specific information about a HTTP request.
 */
class HttpContext
{
    const TYPE_DEFAULT = 'web_browser';
    const TYPE_WEB_SERVICE = 'web_service';

    /**
     * Hash map that can be used to organize and share data. Use setAttribute()
     * and get Attribute() to access this member property. But, direct access
     * is allowed, because PHP4 is impossible to handle reference well.
     * @var array
     * @todo protectedにするためにこのメンバ変数を直接参照している処理をゲッター・セッター経由に変更する
     */
    public $mAttributes = array();

    /**
     * The object which enables to read the request values.
     * @var AbstractRequest
     * @todo protectedにするためにこのメンバ変数を直接参照している処理をゲッター・セッター経由に変更する
     */
    public $mRequest = null;

    /**
     * @var Principal
     * @todo protectedにするためにこのメンバ変数を直接参照している処理をゲッター・セッター経由に変更する
     */
    public $mUser = null;

    /**
     * String which expresses the type of the current request.
     * @var string
     */
    public $mType = self::TYPE_DEFAULT;

    /**
     * The theme is one in one time of request.
     * A decided theme is registered with this property
     * @var string
     */
    private $mThemeName = null;

    /**
     * @public
     * @brief [READ ONLY] User - The current user profile object.
     */
    public $mXoopsUser = null;

    /**
     * @public
     * @brief [READ ONLY] Xcore_AbstractModule - The current module instance.
     */
    public $mModule = null;

    /**
     * @public
     * @brief [READ ONLY] Module - The current Xoops Module object.
     * @remarks
     *     This is a shortcut to mModule->mXoopsModule.
     */
    public $mXoopsModule = null;

    /**
     * @public
     * @brief [READ ONLY] Map Array - std::map<string, mixed>
     *
     *     This is string collection which indicates site configurations by a site owner.
     *     Those configuration informations are loaded by the controller, and set. This
     *     configuration and the site configuration of Root are different.
     *
     *     The array for Xoops, which is configured in the preference of the base. This
     *     property and $xoopsConfig (X2) is the same.
     */
    public $mXoopsConfig = array();

    /**
     * @public
     * @var [READ ONLY] Map Array - std::map<string, mixed> - The array for Xoops Module Config.
     * @remarks
     *     This is a short cut to mModule->mConfig.
     */
    public $mModuleConfig = array();

    /**
     * @public
     * @internal
     * @brief [Secret Agreement] A name of the render system used by the controller strategy.
     * @attention
     *     This member is used for only Controller.
     */
    public $mBaseRenderSystemName = "";

    /**
     * Sets $value with $key to attributes. Use direct access to $mAttributes
     * if references are must, because PHP4 can't handle reference in the
     * signature of this member function.
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        $this->mAttributes[$key] = $value;
    }

    /**
     * Gets a value indicating whether the value specified by $key exists.
     * @param  string $key
     * @return bool
     */
    public function hasAttribute($key)
    {
        return isset($this->mAttributes[$key]);
    }

    /**
     * Gets a value of attributes with $key. If the value specified by $key
     * doesn't exist in attributes, gets null.
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return isset($this->mAttributes[$key]) ? $this->mAttributes[$key] : null;
    }

    /**
     * Sets the object which has a interface of AbstractRequest.
     * @param  AbstractRequest $request
     * @return void
     */
    public function setRequest(AbstractRequest $request)
    {
        $this->mRequest = $request;
    }

    /**
     * Gets the object which has a interface of AbstractRequest.
     * @return AbstractRequest
     */
    public function getRequest()
    {
        return $this->mRequest;
    }

    /**
     * Sets the object which has a interface of Principal.
     * @param  Principal $principal
     * @return void
     */
    public function setUser(Principal $principal)
    {
        $this->mUser = $principal;
    }

    /**
     * Gets the object which has a interface of Principal.
     * @return Principal
     */
    public function getUser()
    {
        return $this->mUser;
    }

    /**
     * Set the theme name.
     * @param string $theme
     * @deprecated
     */
    public function setThemeName($theme)
    {
        $this->mThemeName = $theme;
        $this->mXoopsConfig['theme_set'] = $theme;
        $GLOBALS['xoopsConfig']['theme_set'] = $theme;
    }

    /**
     * Return the theme name.
     * @return string
     * @deprecated
     */
    public function getThemeName()
    {
        return $this->mThemeName;
    }

    /**
     * @public
     * @brief Gets a value of XoopsConfig by $id.
     * @param $id string
     * @return mixed
     */
    function getXoopsConfig($id = null)
    {
        if ($id != null) {
            return isset($this->mXoopsConfig[$id]) ? $this->mXoopsConfig[$id] : null;
        }

        return $this->mXoopsConfig;
    }

    /**
     * Set XOOPS config
     * @param array $xoopsConfig
     */
    public function setXoopsConfig(array $xoopsConfig)
    {
        $this->mXoopsConfig = $xoopsConfig;
    }

    /**
     * Return XoopsUser object
     * @return \XCore\Entity\User
     */
    public function getXoopsUser()
    {
        return $this->mXoopsUser;
    }

    public function getModule()
    {
        return $this->mModule;
    }
}
