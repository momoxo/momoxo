<?php

namespace XCore\Form;

use XCore\Kernel\Root;
use XCore\Kernel\HttpContext;
use XCore\Kernel\Principal;
use XCore\Kernel\Service;
use XCore\Property\AbstractProperty;
use XCore\Form\FieldProperty;

/**
 * Fetches input values, validates fetched values and passes them to some object.
 *
 * This class fetches the input value from the request value through the
 * current context object and validate those values. It separates fetching &
 * validating from your main logic. Such classes is important in web
 * program.
 *
 * Plus, this action form has features of one time token. It seems one kinds of
 * validations. The token is registered in templates.
 *
 * This is suggestion of a simple action form. We do not force a module
 * developer to use this. You can learn more full-scale action forms from JAVA
 * and .NET and other PHP. And, you must use auto-generating tool when you need
 * to ActionForm that is sub-class of this class.
 *
 * ActionForm contains the one-time token feature for CSRF. But, if the
 * current HTTP request is from the web service, the token isn't needed.
 * Therefore, this class decides whether to use the token with the information
 * of the context.
 *
 * This class is diable for Service, because the class uses SESSION
 * directly. ActionForm will be changed in the near feature. Developers
 * need to pay attention to spec change.
 *
 * @todo The difference of array and no-array is too big.
 * @todo Form object should have getValue(), isNull(), toString().
 * @todo This form is impossible to be used in Service SOAP mode.
 */
abstract class ActionForm
{
	/**
	 * The context object. Enables to access the HTTP-request information.
	 * Basically, this member property is read only. Initialized in the constructor.
	 * @var HttpContext
	 */
	protected $mContext;

	/**
	 * The object which has a interface of Principal. Enables to check
	 * permissions of the current HTTP-request through principal object.
	 * Basically, this member property is read only. Initialized in constructor.
	 * @var Principal
	 */
	protected $mUser;

	/**
	 * @var AbstractProperty[]
	 */
	protected $mFormProperties = array();

	/**
	 * @var FieldProperty[]
	 */
	protected $mFieldProperties = array();

	/**
	 * Attention: This is temporary until we will decide the method of managing error.
	 * @var bool
	 */
	public $mErrorFlag = false;

	/**
	 * @var string[]
	 */
	protected $mErrorMessages = array();

	/**
	 * Token string as one time token.
	 * @var string
	 */
	protected $_mToken = null;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$root = Root::getSingleton();
		$this->mContext =& $root->getContext();
		$this->mUser =& $this->mContext->getUser();
	}

	/**
	 * Set up form properties and field properties.
	 */
	public function prepare()
	{
		// template method
	}

	/**
	 * Gets the token name of this actionform's token.
	 *
	 * Return token name. If the sub-class doesn't override this member
	 * function, features about one time tokens aren't used.
	 *
	 * @return string
	 */
	public function getTokenName()
	{
		return null;
	}

	/**
	 * Gets the token value of this actionform's token.
	 *
	 * Generate token value, register it to sessions, return it. This member
	 * function should be called in templates. The subclass can override this
	 * to change the logic for generating token value.
	 *
	 * @return string
	 */
	public function getToken()
	{
		if ( $this->_mToken == null ) {
			srand(microtime() * 100000);
			$root = Root::getSingleton();
			$salt = $root->getSiteConfig('Cube', 'Salt');
			$this->_mToken = md5($salt.uniqid(rand(), true));

			$_SESSION['XCUBE_TOKEN'][$this->getTokenName()] = $this->_mToken;
		}

		return $this->_mToken;
	}

	/**
	 * Gets message about the failed validation of token.
	 * @return string
	 */
	public function getTokenErrorMessage()
	{
		return _TOKEN_ERROR; //< FIXME
	}

	/**
	 * Set raw value as the value of the form property.
	 *
	 * This method is overloaded function.
	 *
	 * \par ActionForm::set($name, $value)
	 *   Set $value to $name property.
	 *   \code
	 *     $this->set('name', 'Bob');  // Set 'Bob' to 'name'.
	 *   \endcode
	 *
	 * \par ActionForm::set($name, $index, $value)
	 *   Set $value to $name array property[$index].
	 *   \code
	 *     $this->set('names', 0, 'Bob');  // Set 'Bob' to 'names[0]'.
	 *   \endcode
	 */
	public function set()
	{
		if ( isset($this->mFormProperties[func_get_arg(0)]) ) {
			if ( func_num_args() == 2 ) {
				$value = func_get_arg(1);
				$this->mFormProperties[func_get_arg(0)]->setValue($value);
			} elseif ( func_num_args() == 3 ) {
				$index = func_get_arg(1);
				$value = func_get_arg(2);
				$this->mFormProperties[func_get_arg(0)]->setValue($index, $value);
			}
		}
	}

	/**
	 * @deprecated
	 */
	public function setVar()
	{
		if ( isset($this->mFormProperties[func_get_arg(0)]) ) {
			if ( func_num_args() == 2 ) {
				$this->mFormProperties[func_get_arg(0)]->setValue(func_get_arg(1));
			} elseif ( func_num_args() == 3 ) {
				$this->mFormProperties[func_get_arg(0)]->setValue(func_get_arg(1), func_get_arg(2));
			}
		}
	}

	/**
	 * Gets raw value.
	 *
	 * Attention:
	 * This method returns raw values. Therefore if the value is used in templates,
	 * it must needs escaping.
	 *
	 * @param string $key   Name of form property.
	 * @param string $index Subscript for array.
	 * @return mixed
	 */
	public function get($key, $index = null)
	{
		return isset($this->mFormProperties[$key]) ? $this->mFormProperties[$key]->getValue($index) : null;
	}

	/**
	 * @deprecated
	 */
	public function getVar($key, $index = null)
	{
		return $this->get($key, $index);
	}

	/**
	 * Gets form properties of this member property.
	 *
	 * Attention:
	 * This method may not be must. So it will be renamed in the near future.
	 * @return AbstractProperty[]
	 * @todo Check whether this method is must.
	 */
	public function &getFormProperties()
	{
		return $this->mFormProperties;
	}

	/**
	 * Fetches values through the request object.
	 *
	 * Fetch the input value, set it and form properties. Those values can be
	 * got, through get() method. the sub-class can define own member function
	 * to fetch. Define member functions whose name is "fetch" + "form name".
	 * For example, to fetch "message" define "fetchMessage()" function. Those
	 * function of the sub-class set value to this action form.
	 *
	 * ```
	 * public function fetchModifytime()
	 * {
	 *     $this->set('modifytime', time());
	 * }
	 * ```
	 *
	 * @return void
	 * @see getFromRequest
	 */
	public function fetch()
	{
		foreach (array_keys($this->mFormProperties) as $name) {
			if ( $this->mFormProperties[$name]->hasFetchControl() ) {
				$this->mFormProperties[$name]->fetch($this);
			} else {
				$value = $this->mContext->mRequest->getRequest($name);
				$this->mFormProperties[$name]->set($value);
			}
			$methodName = "fetch".ucfirst($name);
			if ( method_exists($this, $methodName) ) {
				// call_user_func(array($this,$methodName));
				$this->$methodName();
			}
		}
	}

	/**
	 * Validates the token.
	 *
	 * Validates the token. This method is deprecated, because XCube_Action will
	 * be changed for multi-layer. So this method is called by only this class.
	 * @return void
	 * @todo This method has to be remove, because it is using session directly.
	 */
	protected function _validateToken()
	{
		//
		// check onetime & transaction token
		//
		if ( $this->getTokenName() != null ) {
			$key = strtr($this->getTokenName(), '.', '_');
			$token = isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;

			if ( get_magic_quotes_gpc() ) {
				$token = stripslashes($token);
			}

			$flag = true;

			if ( !isset($_SESSION['XCUBE_TOKEN'][$this->getTokenName()]) ) {
				$flag = false;
			} elseif ( $_SESSION['XCUBE_TOKEN'][$this->getTokenName()] != $token ) {
				unset($_SESSION['XCUBE_TOKEN'][$this->getTokenName()]);
				$flag = false;
			}

			if ( !$flag ) {
				$message = $this->getTokenErrorMessage();
				if ( $message == null ) {
					$this->mErrorFlag = true;
				} else {
					$this->addErrorMessage($message);
				}
			}

			//
			// clear token
			//
			unset($_SESSION['XCUBE_TOKEN'][$this->getTokenName()]);
		}
	}

	/**
	 * Validates fetched values.
	 *
	 * Execute validation, so if a input value is wrong, error messages are
	 * added to error message buffer. The procedure of validation is the
	 * following:
	 *
	 * 1. If this object have token name, validate one time tokens.
	 * 2. Call the validation member function of all field properties.
	 * 3. Call the member function that is defined in the sub-class.
	 *
	 * For a basis, validations are done by functions of each field properties.
	 * But, the sub-class can define own validation logic. Define member
	 * functions whose name is "validate" + "form name". For example, to
	 * validate "message" define "validateMessage()" function.
	 * @return void
	 */
	public function validate()
	{
		$this->_validateToken();

		foreach (array_keys($this->mFormProperties) as $name) {
			if ( isset($this->mFieldProperties[$name]) ) {
				if ( $this->mFormProperties[$name]->isArray() ) {
					foreach (array_keys($this->mFormProperties[$name]->mProperties) as $_name) {
						$this->mFieldProperties[$name]->validate($this->mFormProperties[$name]->mProperties[$_name]);
					}
				} else {
					$this->mFieldProperties[$name]->validate($this->mFormProperties[$name]);
				}
			}
		}

		//
		// If this class has original validation methods, call it.
		//
		foreach (array_keys($this->mFormProperties) as $name) {
			$methodName = "validate".ucfirst($name);
			if ( method_exists($this, $methodName) ) {
				// call_user_func(array($this,$methodName));
				$this->$methodName();
			}
		}
	}

	/**
	 * Gets a value indicating whether this action form keeps error messages or error flag.
	 * @return bool If the action form is error status, returns true.
	 */
	public function hasError()
	{
		return (count($this->mErrorMessages) > 0 || $this->mErrorFlag);
	}

	/**
	 * Adds an message to error message buffer of the form.
	 * @param $message string
	 */
	public function addErrorMessage($message)
	{
		$this->mErrorMessages[] = $message;
	}

	/**
	 * Gets error messages.
	 * @return string[]
	 */
	public function getErrorMessages()
	{
		return $this->mErrorMessages;
	}

	/**
	 * Initializes properties' values from an object.
	 *
	 * Set initial values to this action form from a object. This member
	 * function mediates between the logic and the validation. For example,
	 * developers can use this method to load values from XoopsSimpleObject.
	 *
	 * This member function is abstract. But, the sub-class of this class
	 * doesn't have to implement this.
	 *
	 * @param $obj mixed
	 * @return void
	 */
	public function load(&$obj)
	{
		// template method
	}

	/**
	 * Updates an object with properties' values.
	 *
	 * Set input values to a object from this action form. This member function
	 * mediates between the logic and the result of validations. For example,
	 * developers can use this method to set values to XoopsSimpleObject.
	 *
	 * This member function is abstract. But, the sub-class of this class
	 * doesn't have to implement this.
	 * @param $obj mixed
	 * @return void
	 */
	public function update(&$obj)
	{
		// template method
	}
}
