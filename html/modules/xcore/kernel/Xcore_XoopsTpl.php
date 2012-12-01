<?php

/**
 * @brief The sub-class for Xcore_RenderSystem.
 * 
 * Because XoopsTpl class may be used without Cube's boot, this is declared.
 */
use XCore\Kernel\Root;

class Xcore_XoopsTpl extends XoopsTpl
{
	/**
	 * @private
	 * If variables having the following key are assigned, converts value with
	 * htmlspecialchars_decode, and set it to the context for compatibility.
	 */
	var $_mContextReserve = array();
	
	function Xcore_XoopsTpl()
	{
		$this->_mContextReserve = array ('xoops_pagetitle' => 'xcore_pagetitle');
		parent::XoopsTpl();
	}
	
	function assign($tpl_var, $value = null)
	{
		if (is_array($tpl_var)){
			$root = Root::getSingleton();
			$context = $root->mContext;
			$reserve = $this->_mContextReserve;
			foreach ($tpl_var as $key => $val) {
				if ($key != '') {
					if (isset($reserve[$key])) {
						$context->setAttribute($reserve[$key], htmlspecialchars_decode($val));
					}
					$this->_tpl_vars[$key] = $val;
				}
			}
		}
		else {
			if ($tpl_var) {
				if (isset($this->_mContextReserve[$tpl_var])) {
					$root = Root::getSingleton();
					$root->mContext->setAttribute($this->_mContextReserve[$tpl_var], htmlspecialchars_decode($value));
				}
				$this->_tpl_vars[$tpl_var] = $value;
			}
		}
	}
	
	function assign_by_ref($tpl_var, &$value)
	{
		if ($tpl_var != '') {
			if (isset($this->_mContextReserve[$tpl_var])) {
				$root = Root::getSingleton();
				$root->mContext->setAttribute($this->_mContextReserve[$tpl_var], htmlspecialchars_decode($value));
			}
			$this->_tpl_vars[$tpl_var] =& $value;
		}
	}
	
	function &get_template_vars($name = null)
	{
		$root = Root::getSingleton();
		if (!isset($name)) {
			foreach ($this->_mContextReserve as $t_key => $t_value) {
				if (isset($this->_mContextReserve[$t_value])) {
					$this->_tpl_vars[$t_key] = htmlspecialchars($root->mContext->getAttribute($this->_mContextReserve[$t_value]), ENT_QUOTES);
				}
			}
			$value =& parent::get_template_vars($name);
		}
		elseif (isset($this->_mContextReserve[$name])) {
			$value = htmlspecialchars($root->mContext->getAttribute($this->_mContextReserve[$name]), ENT_QUOTES);
		}
		else {
			$value =& parent::get_template_vars($name);
		}
		return $value;
	}
}
