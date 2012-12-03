<?php

/**
 * @public
 * @brief Provides base action-form class for module developers
 * 
 * This class keeps the spec which was defined at Legacy 2.1 release.
 * ActionForm will be changed. This class will change to adapt the base
 * class & will provide uniformed spec to developers.
 * 
 * @todo All actionforms of Package_Legacy have to Inheritance this class.
 */
use XCore\Form\ActionForm;

class Xcore_ActionForm extends ActionForm
{
	/**
	 * @public
	 * @brief Constructor.
	 */
	function Xcore_ActionForm()
	{
		parent::__construct();
	}
}
