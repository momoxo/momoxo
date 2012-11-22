<?php

define('SMILES_SORT_KEY_ID', 1);
define('SMILES_SORT_KEY_CODE', 2);
define('SMILES_SORT_KEY_SMILE_URL', 3);
define('SMILES_SORT_KEY_EMOTION', 4);
define('SMILES_SORT_KEY_DISPLAY', 5);
define('SMILES_SORT_KEY_MAXVALUE', 5);

define('SMILES_SORT_KEY_DEFAULT', SMILES_SORT_KEY_ID);

class Xcore_SmilesFilterForm extends Xcore_AbstractFilterForm
{
	var $mSortKeys = array(
		SMILES_SORT_KEY_ID => 'id',
		SMILES_SORT_KEY_CODE => 'code',
		SMILES_SORT_KEY_SMILE_URL => 'smile_url',
		SMILES_SORT_KEY_EMOTION => 'emotion',
		SMILES_SORT_KEY_DISPLAY => 'display'
	);

	function getDefaultSortKey()
	{
		return SMILES_SORT_KEY_ID;
	}

	function fetch()
	{
		parent::fetch();
	
		if (isset($_REQUEST['target'])) {
			$this->mNavi->addExtra('target', xoops_getrequest('target'));
		}
		
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

