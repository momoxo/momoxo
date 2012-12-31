<?php

use XCore\Repository\ObjectGenericRepository;

class XcoreBlock_module_linkHandler extends ObjectGenericRepository
{
	var $mTable = "block_module_link";
	var $mPrimary = "block_id";
	var $mClass = "XcoreBlock_module_linkObject";
}
