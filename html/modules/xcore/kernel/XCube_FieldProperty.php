<?php

use XCore\Validator\Validator;
use XCore\Form\ActionForm;

/**
 * @public
 * @brief [Abstract] Used for validating member property values of ActionForm.
 */
class XCube_FieldProperty
{
	/**
	 * @protected
	 * @var ActionForm - Parent form contains this field property.
	 */
	var $mForm;
	
	/**
	 * @protected
	 * @var Validator[]
	 */
	var $mDepends;
	
	/**
	 * @protected
	 * @brief Complex Array
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
	 *	 };
	 * 
	 *   typedef std::map<string, MessageStrage> MessageList;
	 *   MessageList mMessages;
	 * \endcode
	 */
	var $mMessages;
	
	/**
	 * @protected
	 * @brief Hash-Map Array - std::map<string, mixed>
	 */
	var $mVariables;
	
	/**
	 * @public
	 * @brief Constructor.
	 * @param $form ActionForm - Parent form.
	 * @remarks
     *     Only sub-classes of ActionForm calles this constructor.
	 */
	function __construct(&$form)
	{
		$this->mForm =& $form;
	}
	
	/**
	 * @public
	 * @brief Initializes the validator list of this field property with the depend rule name list.
	 * @param $dependsArr string[]
	 * @return void
	 */
	function setDependsByArray($dependsArr)
	{
		foreach ($dependsArr as $dependName) {
			$instance =& XCube_DependClassFactory::factoryClass($dependName);
			if ($instance !== null) {
				$this->mDepends[$dependName] =& $instance;
			}
			
			unset($instance);
		}
	}
	
	/**
	 * @public
	 * @brief Adds an error message which will be used in the case which '$name rule' validation is failed.
	 * @param $name string - Depend rule name.
	 * @param $message string - Error message.
	 * @return void
	 * 
	 *   It's possible to add 3 or greater parameters.
	 *   These additional parameters are used by XCube_Utils::formatString().
	 * \code
	 *   $field->addMessage('required', "{0:ucFirst} is requred.", "name");
	 * \endcode
	 *   This feature is helpful for automatic ActionForm generators.
	 */
	function addMessage($name, $message)
	{
		if (func_num_args() >= 2) {
			$args = func_get_args();
			$this->mMessages[$args[0]]['message'] = $args[1];
			for ($i = 0; isset($args[$i + 2]); $i++) {
				$this->mMessages[$args[0]]['args'][$i] = $args[$i + 2];
			}
		}
	}
	
	/**
	 * @public
	 * @brief Gets the error message rendered by XCube_Utils::formaString().
	 * @param $name string - Depend rule name
	 * @return string
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
	 */
	function renderMessage($name)
	{
		if (!isset($this->mMessages[$name]))
			return null;
		
		$message = $this->mMessages[$name]['message'];
		
		if (isset($this->mMessages[$name]['args'])) {
			// Use an unity method.
			$message = XCube_Utils::formatString($message, $this->mMessages[$name]['args']);
		}
		
		return $message;
	}
	
	/**
	 * @public
	 * @brief Adds a virtual variable used by validators.
	 * @param $name string - A name of the variable.
	 * @param $value mixed - A value of the variable.
	 * 
	 *   Virtual varialbes are used for validating by validators. For example,
	 *   XCube_MinlengthValidator needs a value indicationg a minimum length.
	 * \code
	 *   $field->addVar('minlength', 2);
	 * \endcode
	 */
	function addVar($name, $value)
	{
		$this->mVariables[$name] = $value;
	}
	
	/**
	 * @public
	 * @brief Validates form-property with validators which this field property holds.
	 * @attention
	 *      Only ActionForm and its sub-classes should call this method.
	 * @todo This class already has form property instance.
	 */
	function validate(&$form)
	{
		if (is_array($this->mDepends) && count($this->mDepends) > 0) {
			foreach ($this->mDepends as $name => $depend) {
				if (!$depend->isValid($form, $this->mVariables)) {
					// Error
					// NOTICE: This is temporary until we will decide the method of managing error.
					$this->mForm->mErrorFlag = true;
					
					// TEST!!
					$this->mForm->addErrorMessage($this->renderMessage($name));
				}
				else {
					// OK
				}
			}
		}
	}
}
