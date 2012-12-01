<?php

use XCore\Kernel\Root;

class Xcore_SearchModule extends XCube_Object
{
    function getPropertyDefinition()
    {
        $ret = array(
            S_PUBLIC_VAR("int mid"),
            S_PUBLIC_VAR("string name")
        );
        
        return $ret;
    }
}

class Xcore_SearchModuleArray extends XCube_ObjectArray
{
    function getClassName()
    {
        return "Xcore_SearchModule";
    }
}


class Xcore_SearchItem extends XCube_Object
{
    function getPropertyDefinition()
    {
        $ret = array(
            S_PUBLIC_VAR("string image"),
            S_PUBLIC_VAR("string link"),
            S_PUBLIC_VAR("string title"),
            S_PUBLIC_VAR("int uid"),
            S_PUBLIC_VAR("int time")
        );
        
        return $ret;
    }
}

class Xcore_SearchItemArray extends XCube_ObjectArray
{
    function getClassName()
    {
        return "Xcore_SearchItem";
    }
}

class Xcore_SearchModuleResult extends XCube_Object
{
    function getPropertyDefinition()
    {
        $ret = array(
            S_PUBLIC_VAR("int mid"),
            S_PUBLIC_VAR("string name"),
            S_PUBLIC_VAR("int has_more"),
            S_PUBLIC_VAR("Xcore_SearchItemArray results"),
            S_PUBLIC_VAR("string showall_link")
        );
        
        return $ret;
    }
}

class Xcore_SearchModuleResultArray extends XCube_ObjectArray
{
    function getClassName()
    {
        return "Xcore_SearchModuleResult";
    }
}

class Xcore_ArrayOfInt extends XCube_ObjectArray
{
    function getClassName()
    {
        return "int";
    }
}

class Xcore_ArrayOfString extends XCube_ObjectArray
{
    function getClassName()
    {
        return "string";
    }
}

/**
 * Sample class
 */
class Xcore_SearchService extends XCube_Service
{
    var $mServiceName = "Xcore_SearchService";
    var $mNameSpace = "Xcore";
    var $mClassName = "Xcore_SearchService";
    
    function prepare()
    {
        $this->addType('Xcore_SearchModule');
        $this->addType('Xcore_SearchModuleArray');
        $this->addType('Xcore_SearchItem');
        $this->addType('Xcore_SearchItemArray');
        $this->addType('Xcore_SearchModuleResult');
        $this->addType('Xcore_SearchModuleResultArray');
        $this->addType('Xcore_ArrayOfInt');
        $this->addType('Xcore_ArrayOfString');
    
        $this->addFunction(S_PUBLIC_FUNC('Xcore_SearchItemArray searchItems(int mid, Xcore_ArrayOfString queries, string andor, int maxhit, int start)'));
        $this->addFunction(S_PUBLIC_FUNC('Xcore_SearchItemArray searchItemsOfUser(int mid, int uid, int maxhit, int start)'));
        $this->addFunction(S_PUBLIC_FUNC('Xcore_SearchModuleArray getActiveModules()'));
    }
    
    function getActiveModules()
    {
        //
        // At first, get active module IDs.
        //
        static $ret;
        if (isset($ret)) return $ret;

        $handler =& xoops_gethandler('module');
        
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('isactive', 1));
        $criteria->add(new Criteria('hassearch', 1));

		// shortcut for speedup
		$db = $handler->db;

		$sort = $criteria->getSort();
		$sql = 'SELECT mid,name FROM '.$db->prefix('modules').' '.$criteria->renderWhere().
			($sort?' ORDER BY '.$sort.' '.$criteria->getOrder():' ORDER BY weight '.$criteria->getOrder().', mid ASC');

		$result = $db->query($sql);

        $handler =& xoops_gethandler('groupperm');
        $groupArr = Xcore_SearchUtils::getUserGroups();

        $ret = array();
        while (list($mid, $name) = $db->fetchRow($result)) {
            if ($handler->checkRight('module_read', $mid, $groupArr)) {
				$ret[] = array('mid' => $mid, 'name' => $name);
			}
        }
        
        return $ret;
    }
    
    function searchItems()
    {
        //
        // TODO Need validation
        //
        $root =& Root::getSingleton();
        $request =& $root->mContext->mRequest;
        
        return $this->_searchItems((int)$request->getRequest('mid'), $request->getRequest('queries'), $request->getRequest('andor'), (int)$request->getRequest('maxhit'), (int)$request->getRequest('start'), 0);
    }
    
    function searchItemsOfUser()
    {
        //
        // TODO Need validation
        //
        $root =& Root::getSingleton();
        $request =& $root->mContext->mRequest;
        
        return $this->_searchItems((int)$request->getRequest('mid'), null, 'and', (int)$request->getRequest('maxhit'), (int)$request->getRequest('start'), (int)$request->getRequest('uid'));
    }
    
    /**
     * @access private
     */
    private function _searchItems($mid, $queries, $andor, $max_hit, $start, $uid)
    {
        $ret = array();

		static $moduleArr;
		if (!isset($moduleArr)) {
			$moduleArr = array();
			foreach ($this->getActiveModules() as $mod) {
				$moduleArr[$mod['mid']] = $mod['name'];
			}
		}

        if (!isset($moduleArr[$mid])) return $ret;

        static $timezone;
        if (!isset($timezone)) {
            $root =& Root::getSingleton();
            $timezone = $root->mContext->getXoopsConfig('server_TZ') * 3600;
        }

        $handler =& xoops_gethandler('module');
        $xoopsModule =& $handler->get($mid);
        if (!is_object($xoopsModule)) {
            return $ret;
        }
        
        if (!$xoopsModule->get('isactive') || !$xoopsModule->get('hassearch')) {
            return $ret;
        }

        $module =& Xcore_Utils::createModule($xoopsModule, false);
        $results = $module->doXcoreGlobalSearch($queries, $andor, $max_hit, $start, $uid);
                
        if (is_array($results) && count($results) > 0) {
            foreach (array_keys($results) as $key) {
                $timeval =& $results[$key]['time'];
                //
                // TODO If this service will come to web service, we should
                // change format from unixtime to string by timeoffset.
                //
                if ($timeval) $timeval -= $timezone;
            }
        }
        
        return $results;
    }
}

class Xcore_SearchUtils
{
   public static function getUserGroups()
    {
        $root =& Root::getSingleton();
        $user =& $root->mController->mRoot->mContext->mXoopsUser;
        $groups = array();
        
        if (!is_object($user)) {
            $groups = XOOPS_GROUP_ANONYMOUS;
        }
        else {
            $groups = $user->getGroups();
        }
        
        return $groups;
    }
}

