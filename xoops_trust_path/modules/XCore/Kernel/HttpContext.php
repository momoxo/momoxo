<?php

namespace XCore\Kernel;

use XCore\Kernel\AbstractRequest;
use XCore\Kernel\Principal;

/**
 * Encapsulates major HTTP specific information about a HTTP request.
 */
class HttpContext
{
    /**
     * Hash map that can be used to organize and share data. Use setAttribute()
     * and get Attribute() to access this member property. But, direct access
     * is allowed, because PHP4 is impossible to handle reference well.
     * @var array
     * @protected
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
    public $mType = XCUBE_CONTEXT_TYPE_DEFAULT;

    /**
     * The theme is one in one time of request.
     * A decided theme is registered with this property
     * @var string
     */
    private $mThemeName = null;

    /**
     * Return new HttpContext instance
     */
    public function __construct()
    {
    }

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
    public function setRequest(&$request)
    {
        $this->mRequest =& $request;
    }

    /**
     * Gets the object which has a interface of AbstractRequest.
     * @return AbstractRequest
     */
    public function &getRequest()
    {
        return $this->mRequest;
    }

    /**
     * Sets the object which has a interface of Principal.
     * @param  Principal $principal
     * @return void
     */
    public function setUser(&$principal)
    {
        $this->mUser =& $principal;
    }

    /**
     * Gets the object which has a interface of Principal.
     * @return Principal
     */
    public function &getUser()
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
}
