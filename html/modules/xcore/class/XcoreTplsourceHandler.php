<?php

use XCore\Repository\ObjectGenericRepository;

class XcoreTplsourceHandler extends ObjectGenericRepository
{
	var $mTable = "tplsource";
	var $mPrimary = "tpl_id";
	var $mClass = "XcoreTplsourceObject";
}
