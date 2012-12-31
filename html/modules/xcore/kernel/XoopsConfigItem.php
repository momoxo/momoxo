<?php

/**
 * 
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsConfigItem extends XoopsObject
{

    /**
     * Config options
     * 
     * @var	array
     * @access	private
     */
    var $_confOptions = array();

    /**
     * Constructor
     */
    function __construct()
    {
		static $initVars;
		if (isset($initVars)) {
		    $this->vars = $initVars;
		    return;
		}
        $this->initVar('conf_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('conf_modid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('conf_catid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('conf_name', XOBJ_DTYPE_OTHER);
        $this->initVar('conf_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('conf_value', XOBJ_DTYPE_TXTAREA);
        $this->initVar('conf_desc', XOBJ_DTYPE_OTHER);
        $this->initVar('conf_formtype', XOBJ_DTYPE_OTHER);
        $this->initVar('conf_valuetype', XOBJ_DTYPE_OTHER);
        $this->initVar('conf_order', XOBJ_DTYPE_INT);
        $initVars = $this->vars;
    }
    
    /**
     * Get a constract of title
     */
    function getTitle()
    {
		return defined($this->get('conf_title')) ? constant($this->get('conf_title')) : $this->get('conf_title');
	}
	
    /**
     * Get a constract of description. If it isn't defined, return null.
     */
	function getDesc()
	{
		return defined($this->get('conf_desc')) ? constant($this->get('conf_desc')) : null;
	}
	
	/**
	 * @return array()
	 */
	function &getOptionItems()
	{
		$handler = xoops_gethandler('config');
		$optionArr =& $handler->getConfigOptions(new Criteria('conf_id', $this->get('conf_id')));
		
		return $optionArr;
	}

	/**
	 * @return array()
	 */
	function getRoledModuleList()
	{
		$handler = xoops_gethandler('config');
		$optionArr =& $handler->getConfigOptions(new Criteria('conf_id', $this->get('conf_id')));
		$list = array();
		foreach($optionArr as $opt){
			if($opt->get('confop_value')=='none'){
				$list[] = '';
			}
			else{
				$list = array_merge($list, Xcore_Utils::getCommonModuleList($opt->get('confop_value')));
			}
		}
		return $list;
	}

    /**
     * Get a config value in a format ready for output
     * 
     * @return	string
     */
    function &getConfValueForOutput()
    {
        switch ($this->getVar('conf_valuetype')) {
        case 'int':
            $ret = (int)$this->getVar('conf_value', 'N');
            return $ret;
        case 'array':
            $ret = unserialize($this->getVar('conf_value', 'N'));
            return $ret;
        case 'float':
            $ret = (float)$this->getVar('conf_value', 'N');
            return $ret;
        case 'textarea':
            return $this->getVar('conf_value');
        default:
            return $this->getVar('conf_value', 'N');
        }

        $ret = null;
        return $ret;
    }

    /**
     * Set a config value
     * 
     * @param	mixed   &$value Value
     * @param	bool    $force_slash
     */
    function setConfValueForInput(&$value, $force_slash = false)
    {
        switch($this->getVar('conf_valuetype')) {
        case 'array':
            if (!is_array($value)) {
                $value = explode('|', trim($value));
            }
            $this->setVar('conf_value', serialize($value), $force_slash);
            break;
        case 'text':
            $this->setVar('conf_value', trim($value), $force_slash);
            break;
        default:
            $this->setVar('conf_value', $value, $force_slash);
            break;
        }
    }

    /**
     * Assign one or more {@link XoopsConfigItemOption}s 
     * 
     * @param	mixed   $option either a {@link XoopsConfigItemOption} object or an array of them
     */
    function setConfOptions($option)
    {
        if (is_array($option)) {
            $count = count($option);
            for ($i = 0; $i < $count; $i++) {
                $this->setConfOptions($option[$i]);
            }
        } else {
            if(is_object($option)) {
                $this->_confOptions[] =& $option;
            }
        }
    }

    /**
     * Get the {@link XoopsConfigItemOption}s of this Config
     * 
     * @return	array   array of {@link XoopsConfigItemOption} 
     */
    function &getConfOptions()
    {
        return $this->_confOptions;
    }
	
	/**
	 * Compare with contents of $config object. If it's equal, return true.
	 * This member function doesn't use 'conf_id' & 'conf_value' & 'conf_order' to compare.
	 * 
	 * @param XoopsConfigItem $config
	 * @return bool
	 */
	function isEqual(&$config)
	{
		$flag = true;
		
		$flag &= ($this->get('conf_modid') == $config->get('conf_modid'));
		$flag &= ($this->get('conf_catid') == $config->get('conf_catid'));
		$flag &= ($this->get('conf_name') == $config->get('conf_name'));
		$flag &= ($this->get('conf_title') == $config->get('conf_title'));
		$flag &= ($this->get('conf_desc') == $config->get('conf_desc'));
		$flag &= ($this->get('conf_formtype') == $config->get('conf_formtype'));
		$flag &= ($this->get('conf_valuetype') == $config->get('conf_valuetype'));
		
		//
		// Compare options
		//
		$thisOptions =& $this->getOptionItems();
		$hisOptions =& $config->getConfOptions();
		
		if (count($thisOptions) == count($hisOptions)) {
			foreach (array_keys($thisOptions) as $t_thiskey) {
				$t_okFlag = false;
				foreach (array_keys($hisOptions) as $t_hiskey) {
					if ($thisOptions[$t_thiskey]->isEqual($hisOptions[$t_hiskey])) {
						$t_okFlag = true;
					}
				}
				
				if (!$t_okFlag) {
					$flag = false;
					break;
				}
			}
		}
		else {
			$flag = false;
		}

		return $flag;
	}

	/**
	 * Set values by config info which is array from xoops_version.php.
	 * 
	 * @var int   $modid      ID of the module
	 * @var array $configInfo
	 * @var int   $order      conf_order
	 */	
	function loadFromConfigInfo($mid, &$configInfo, $order = null)
	{
		$this->set('conf_modid', $mid);
		$this->set('conf_catid', 0);
		$this->set('conf_name', $configInfo['name']);
		$this->set('conf_title', $configInfo['title'], true);
		if (isset($configInfo['description'])) {
			$this->set('conf_desc', $configInfo['description'], true);
		}
		$this->set('conf_formtype', $configInfo['formtype'], true);
		$this->set('conf_valuetype', $configInfo['valuetype'], true);
		$this->setConfValueForInput($configInfo['default'], true);
		if (isset($configInfo['order'])) {
			$this->set('conf_order', $configInfo['order']);
		}
		else {
			$this->set('conf_order', $order);
		}
		
		if (isset($configInfo['options']) && is_array($configInfo['options'])) {
			$configHandler = xoops_gethandler('config');
			foreach ($configInfo['options'] as $key => $value) {
				$configOption =& $configHandler->createConfigOption();
				$configOption->setVar('confop_name', $key, true);
				$configOption->setVar('confop_value', $value, true);
				$this->setConfOptions($configOption);
				unset($configOption);
			}
		}
	}
}
