<?php

namespace XCore\Kernel;

use XCore\Kernel\Root;
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;

/**
 * Used for the simple mechanism for common delegation in XCore.
 *
 * A delegate can have $callback as connected function, $filepath for lazy
 * loading and $priority as order indicated.
 *
 * Priority
 *
 * Default of this parameter is XCUBE_DELEGATE_PRIORITY_NORMAL. Usually, this
 * parameter isn't specified. Plus, the magic number should be used to specify
 * priority. Use XCUBE_DELEGATE_PRIORITY_FIRST or XCUBE_DELEGATE_PRIORITY_FINAL
 * with Addition and Subtraction. (e.x. XCUBE_DELEGATE_PRIORITY_NORMAL - 1 )
 *
 * This is the candidate as new delegate style, which has foolish name to escape
 * conflict with old Delegate. After replacing, we'll change all.
 */
final class Delegate
{
    /**
     * The list of type of parameters.
     * @var array
     */
    private $_mSignatures = array();

    /**
     * This is Array for callback type data.
     * @var callable[]
     */
    private $_mCallbacks = array();

    /**
     * @var bool
     */
    private $_mHasCheckSignatures = false;

    /**
     * If register() is failed, this flag become true. That problem is raised,
     * when register() is called before $root come to have the delegate
     * manager.
     * @var bool
     */
    private $_mIsLazyRegister = false;

    /**
     * This is register name for lazy registering.
     * @var string
     */
    private $_mLazyRegisterName = null;

    /**
     * @var string
     */
    private $_mUniqueID;

    /**
     * Constructor.
     *
     * The parameter of the constructor is a variable argument style to specify
     * the signature of this delegate. If the argument is empty, signature checking
     * doesn't work. Empty arguments are good to use in many cases. But, that's
     * important to accent a delegate for making rightly connected functions.
     *
     * ```
     * $delegate = new Delegate("string", "string");
     * ```
     */
    public function __construct()
    {
        if ( func_num_args() ) {
            $this->_setSignatures(func_get_args());
        }
        $this->_mUniqueID = uniqid(rand(), true);
    }

    /**
     * Set signatures for this delegate.
     *
     * By this method, this function will come to check arguments with following
     * signatures at call().
     *
     * @param  array $args
     * @return void
     */
    private function _setSignatures($args)
    {
        $this->_mSignatures =& $args;
        for ($i = 0, $max = count($args); $i < $max; $i++) {
            $arg = $args[$i];
            $idx = strpos($arg, ' &');
            if ($idx !== false) {
                $args[$i] = substr($arg, 0, $idx);
            }
        }
        $this->_mHasCheckSignatures = true;
    }

    /**
     * Registers this object to delegate manager of root.
     * @param  string $delegateName
     * @return bool
     */
    public function register($delegateName)
    {
        $root = Root::getSingleton();
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
     * Connects functions to this object as callback functions
     *
     * This method is virtual overload by signatures.
     *
     * ```
     * add(callback $callback, int priority = XCUBE_DELEGATE_PRIORITY_NORMAL);
     * add(callback $callback, string filepath = null);
     * add(callback $callback, int priority =... , string filepath=...);
     * ```
     *
     * @param  callable $callback
     * @param  null     $param2
     * @param  null     $param3
     * @return void
     * @overload
     */
    public function add($callback, $param2 = null, $param3 = null)
    {
        $priority = XCUBE_DELEGATE_PRIORITY_NORMAL;
        $filepath = null;

        if ( !is_array($callback) && strstr($callback, '::') ) {
            if ( count($tmp = explode('::', $callback)) == 2 ) $callback = $tmp;
        }

        if ($param2 !== null) {
            if ( is_int($param2) ) {
                $priority = $param2;
                $filepath = ($param3 !== null && is_string($param3)) ? $param3 : null;
            } elseif ( is_string($param2) ) {
                $filepath = $param2;
            }
        }

        $this->_mCallbacks[$priority][] = array($callback, $filepath);
        ksort($this->_mCallbacks);
    }

    /**
     * Disconnects a function from this object.
     * @param $delcallback
     * @return void
     */
    public function delete($delcallback)
    {
        foreach (array_keys($this->_mCallbacks) as $priority) {
            foreach (array_keys($this->_mCallbacks[$priority]) as $idx) {
                $callback = $this->_mCallbacks[$priority][$idx][0];
                if ( DelegateUtils::_compareCallback($callback, $delcallback) ) {
                    unset($this->_mCallbacks[$priority][$idx]);
                }
                if ( count($this->_mCallbacks[$priority]) == 0 ) {
                    unset($this->_mCallbacks[$priority]);
                }
            }
        }
    }

    /**
     * Resets all delegate functions from this object.
     *
     * This is the special method, so XCore doesn't recommend using this.
     *
     * @return void
     */
    public function reset()
    {
        unset($this->_mCallbacks);
        $this->_mCallbacks = array();
    }

    /**
     * Calls connected functions of this object.
     */
    public function call()
    {
        $args = func_get_args();
        $num = func_num_args();

        if ($this->_mIsLazyRegister) {
            $this->register($this->_mLazyRegisterName);
        }

        if ($hasSig = $this->_mHasCheckSignatures) {
            if ( count($mSigs = & $this->_mSignatures) != $num ) return false;
        }

        for ($i = 0; $i < $num; $i++) {
            $arg = & $args[$i];
            if ( $arg instanceof Ref ) $args[$i] =& $arg->getObject();

            if ($hasSig) {
                if ( !isset($mSigs[$i]) ) return false;
                switch ($mSigs[$i]) {
                    case 'void':
                        break;

                    case 'bool':
                        if ( !empty($arg) ) $args[$i] = $arg ? true : false;
                        break;

                    case 'int':
                        if ( !empty($arg) ) $args[$i] = (int) $arg;
                        break;

                    case 'float':
                        if ( !empty($arg) ) $args[$i] = (float) $arg;
                        break;

                    case 'string':
                        if ( !empty($arg) && !is_string($arg) ) return false;
                        break;

                    default:
                        if ( !is_a($arg, $mSigs[$i]) ) return false;
                }
            }
        }

        foreach ($this->_mCallbacks as $callback_arrays) {
            foreach ($callback_arrays as $callback_array) {
                list($callback, $file) = $callback_array;

                if ( $file ) require_once $file;
                if ( is_callable($callback) ) call_user_func_array($callback, $args);
            }
        }
    }

    /**
     * Gets a value indicating whether this object has callback functions.
     * @return bool
     */
    public function isEmpty()
    {
        return (count($this->_mCallbacks) == 0);
    }

    /**
     * Gets the unique ID of this object.
     *
     * This is the special method, so XCore doesn't recommend using this.
     *
     * @internal
     * @return string
     */
    public function getID()
    {
        return $this->_mUniqueID;
    }
}
