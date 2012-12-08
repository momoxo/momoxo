<?php

namespace XCore\Form;

use XCube_DependClassFactory;
use XCube_Utils;
use XCore\Validator\Validator;
use XCore\Form\ActionForm;
use XCore\Validator\MinlengthValidator;

/**
 * Used for validating member property values of ActionForm.
 */
class FieldProperty
{
	/**
	 * Parent form contains this field property.
	 * @var ActionForm
	 */
	protected $mForm;

	/**
	 * @var Validator[]
	 */
	protected $mDepends = array();

	/**
	 * Complex Array
	 * @section section1 Complex Array
	 *   $mMessages[$name]['message'] - string \n
	 *   $mMessages[$name]['args'][]  - string
	 *
	 * \code
	 *   // Reference Define
	 *   typedef std::map<int, string> ArgumentMap;
	 *   struct MessageStrage
	 *   {
	 *     string Message;
	 *     ArgumentMap args;
	 *     };
	 *
	 *   typedef std::map<string, MessageStrage> MessageList;
	 *   MessageList mMessages;
	 * \endcode
	 */
	protected $mMessages = array();

	/**
	 * @var array
	 */
	protected $mVariables;

	/**
	 * Constructor.
	 *
	 * Remarks:
	 * Only sub-classes of ActionForm calls this constructor.
	 * @param ActionForm $form Parent form.
	 */
	public function __construct(&$form)
	{
		$this->mForm =& $form;
	}

	/**
	 * Initializes the validator list of this field property with the depend rule name list.
	 * @param string[] $dependsArr
	 * @return void
	 */
	public function setDependsByArray($dependsArr)
	{
		foreach ($dependsArr as $dependName) {
			$instance =& XCube_DependClassFactory::factoryClass($dependName);
			if ( $instance !== null ) {
				$this->mDepends[$dependName] =& $instance;
			}

			unset($instance);
		}
	}

	/**
	 * Adds an error message which will be used in the case which '$name rule' validation is failed.
	 *
	 *   It's possible to add 3 or greater parameters.
	 *   These additional parameters are used by XCube_Utils::formatString().
	 * \code
	 *   $field->addMessage('required', "{0:ucFirst} is requred.", "name");
	 * \endcode
	 *   This feature is helpful for automatic ActionForm generators.
	 * @param string $name    Depend rule name.
	 * @param string $message Error message.
	 * @return void
	 */
	public function addMessage($name, $message)
	{
		if ( func_num_args() >= 2 ) {
			$args = func_get_args();
			$this->mMessages[$args[0]]['message'] = $args[1];
			for ($i = 0; isset($args[$i + 2]); $i++) {
				$this->mMessages[$args[0]]['args'][$i] = $args[$i + 2];
			}
		}
	}

	/**
	 * Gets the error message rendered by XCube_Utils::formaString().
	 *
	 *   Gets the error message registered at addMessage(). If the message setting has some
	 *   arguments, messages are rendered by XCube_Utils::formatString().
	 * \code
	 *   $field->addMessage('required', "{0:ucFirst} is requred.", "name");
	 *
	 *   // Gets "Name is required."
	 *   $field->renderMessage('required');
	 * \endcode
	 *   This feature is helpful for automatic ActionForm generators.
	 * @param string $name Depend rule name
	 * @return string
	 */
	public function renderMessage($name)
	{
		if ( !isset($this->mMessages[$name]) ) {
			return null;
		}

		$message = $this->mMessages[$name]['message'];

		if ( isset($this->mMessages[$name]['args']) ) {
			// Use an unity method.
			$message = XCube_Utils::formatString($message, $this->mMessages[$name]['args']);
		}

		return $message;
	}

	/**
	 * Adds a virtual variable used by validators.
	 *
	 *   Virtual variables are used for validating by validators. For example,
	 *   MinlengthValidator needs a value indication a minimum length.
	 * \code
	 *   $field->addVar('minlength', 2);
	 * \endcode
	 * @param string $name A name of the variable.
	 * @param mixed $value A value of the variable.
	 */
	public function addVar($name, $value)
	{
		$this->mVariables[$name] = $value;
	}

	/**
	 * Validates form-property with validators which this field property holds.
	 * Attention:
	 * Only ActionForm and its sub-classes should call this method.
	 * @todo This class already has form property instance.
	 */
	public function validate(&$form)
	{
		if ( is_array($this->mDepends) && count($this->mDepends) > 0 ) {
			foreach ($this->mDepends as $name => $depend) {
				if ( !$depend->isValid($form, $this->mVariables) ) {
					// Error
					// NOTICE: This is temporary until we will decide the method of managing error.
					$this->mForm->mErrorFlag = true;

					// TEST!!
					$this->mForm->addErrorMessage($this->renderMessage($name));
				} else {
					// OK
				}
			}
		}
	}
}

