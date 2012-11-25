<?php

/**
 * @public
 * @brief [Final] Used for the simple mechanism for common delegation in XCube.
 * 
 * A delegate can have $callback as connected function, $filepath for lazy
 * loading and $priority as order indicated.
 * 
 * \par Priority
 * 
 * Default of this parameter is XCUBE_DELEGATE_PRIORITY_NORMAL. Usually, this
 * parameter isn't specified. Plus, the magic number should be used to specify
 * priority. Use XCUBE_DELEGATE_PRIORITY_FIRST or XCUBE_DELEGATE_PRIORITY_FINAL
 * with Addition and Subtraction. (e.x. XCUBE_DELEGATE_PRIORITY_NORMAL - 1 )
 * 
 * @attention
 *     This is the candidate as new delegate style, which has foolish name to escape
 *     conflict with old XCube_Delegate. After replacing, we'll change all.
 */
class XCube_Delegate
{
	/**
	 * @private
	 * @brief Vector Array - The list of type of parameters.
	 */
	var $_mSignatures = array();
	
	/**
	 * @private
	 * @brief Complex Array - This is Array for callback type data.
	 */
	var $_mCallbacks = array();
	
	/**
	 * @private
	 * @brief bool
	 */	
	var $_mHasCheckSignatures = false;
	
	/**
	 * @private
	 * @brief bool
	 * 
	 * If register() is failed, this flag become true. That problem is raised,
	 * when register() is called before $root come to have the delegate
	 * manager.
	 * 
	 * @var bool
	 */
	var $_mIsLazyRegister = false;
	
	/**
	 * @private
	 * @brief string - This is register name for lazy registering.
	 */
	var $_mLazyRegisterName = null;

	/**
	 * @private
	 */
    var $_mUniqueID;
    
	/**
	 * @public
	 * @brief Constructor.
	 * 
	 * The parameter of the constructor is a variable argument style to specify
	 * the sigunature of this delegate. If the argument is empty, signature checking
	 * doesn't work. Empty arguments are good to use in many cases. But, that's
	 * important to accent a delegate for making rightly connected functions.
	 * 
	 * \code
	 *   $delegate =new XCube_Delegate("string", "string");
	 * \endcode
	 */
	function XCube_Delegate()
	{
		if (func_num_args()) {
			$this->_setSignatures(func_get_args());
		}
		$this->_mUniqueID = uniqid(rand(), true);
	}
	
	/**
	 * @private
	 * @brief Set signatures for this delegate.
	 * @param $args Vector Array - std::vector<string>
	 * @return void
	 * 
	 * By this method, this function will come to check arguments with following
	 * signatures at call().
	 */
	function _setSignatures($args)
	{
		$this->_mSignatures =& $args;
		for ($i=0, $max=count($args); $i<$max ; $i++) {
			$arg = $args[$i];
			$idx = strpos($arg, ' &');
			if ($idx !== false) $args[$i] = substr($arg, 0, $idx);
		}
		$this->_mHasCheckSignatures = true;
	}
	
	/**
	 * @public
	 * @brief Registers this object to delegate manager of root.
	 * @param $delegateName string
	 * @return bool
	 */
	function register($delegateName)
	{
		$root =& XCube_Root::getSingleton();
		if ($root->mDelegateManager != null) {
			$this->_mIsLazyRegister = false;
			$this->_mLazyRegisterName = null;
		
			return $root->mDelegateManager->register($delegateName, $this);
		}
		
		$this->_mIsLazyRegister = true;
		$this->_mLazyRegisterName = $delegateName;

		return false;
	}

	/**
	 * @public
	 * @brief [Overload] Connects functions to this object as callbacked functions
	 * @return void
	 * 
	 * This method is virtual overload by sigunatures.
	 * 
	 * \code
	 *   add(callback $callback, int priority = XCUBE_DELEGATE_PRIORITY_NORMAL);
	 *   add(callback $callback, string filepath = null);
	 *   add(callback $callback, int priority =... , string filepath=...);
	 * \endcode
	 */
	function add($callback, $param2 = null, $param3 = null)
	{
		$priority = XCUBE_DELEGATE_PRIORITY_NORMAL;
		$filepath = null;
		
		if (!is_array($callback) && strstr($callback, '::')) {
			if (count($tmp = explode('::', $callback)) == 2) $callback = $tmp;
		}
		
		if ($param2 !== null) {
			if (is_int($param2)) {
				$priority = $param2;
				$filepath = ($param3 !== null && is_string($param3)) ? $param3 : null;
			} elseif (is_string($param2)) {
				$filepath = $param2;
			}
		}
		
		$this->_mCallbacks[$priority][] = array($callback, $filepath);
        ksort($this->_mCallbacks);
	}
	
	/**
	 * @public
	 * @brief Disconnects a function from this object.
	 * @return void
	 */
	function delete($delcallback)
	{
		foreach (array_keys($this->_mCallbacks) as $priority) {
            foreach (array_keys($this->_mCallbacks[$priority]) as $idx) {
                $callback = $this->_mCallbacks[$priority][$idx][0];
                if (XCube_DelegateUtils::_compareCallback($callback, $delcallback)) {
                    unset($this->_mCallbacks[$priority][$idx]);
                }
                if (count($this->_mCallbacks[$priority])==0) {
                    unset($this->_mCallbacks[$priority]);
                }
            }
        }
    }

	/**
	 * @public
	 * @brief Resets all delegate functions from this object.
	 * @return void
	 * @attention
	 *     This is the special method, so XCube doesn't recommend using this.
	 */
	function reset()
	{
	    unset($this->_mCallbacks);
	    $this->_mCallbacks = array();
    }

	/**
	 * @public
	 * @brief Calls connected functions of this object.
	 */
	function call()
	{
		$args = func_get_args();
		$num = func_num_args();
		
		if ($this->_mIsLazyRegister) {
			$this->register($this->_mLazyRegisterName);
		}
		
		if ($hasSig = $this->_mHasCheckSignatures) {
			if (count($mSigs = &$this->_mSignatures) != $num) return false;
		}
		
		for ($i=0 ; $i<$num ;$i++) {
			$arg = &$args[$i];
			if ($arg instanceof XCube_Ref) $args[$i] =& $arg->getObject();

			if ($hasSig) {
				if (!isset($mSigs[$i])) return false;
				switch ($mSigs[$i]) {
					case 'void':
						break;
					
					case 'bool':
						if (!empty($arg)) $args[$i] = $arg? true : false;
						break;

					case 'int':
						if (!empty($arg)) $args[$i] = (int)$arg;
						break;
					
					case 'float':
						if (!empty($arg)) $args[$i] = (float)$arg;
						break;

					case 'string':
						if (!empty($arg) && !is_string($arg)) return false;
						break;
					
					default:
						if (!is_a($arg, $mSigs[$i])) return false;
				}
			}
		}
		
		foreach ($this->_mCallbacks as $callback_arrays) {
            foreach ($callback_arrays as $callback_array) {
                list($callback, $file) = $callback_array;

               	if ($file) require_once $file;
               	if (is_callable($callback)) call_user_func_array($callback, $args);
            }
		}
	}
	
	/**
	 * @public
	 * @brief Gets a value indicating whether this object has callback functions.
	 * @return bool
	 */    
    function isEmpty()
    {
    	return (count($this->_mCallbacks) == 0);
    }

	/**
	 * @public
	 * @internal
	 * @brief Gets the unique ID of this object.
	 * @attention
	 *     This is the special method, so XCube doesn't recommend using this.
	 */    
	function getID()
	{
	    return $this->_mUniqueID;
	}
}
