<?php

use XCore\Repository\ObjectGenericRepository;

class XcoreImagebodyHandler extends ObjectGenericRepository
{
	var $mTable = "imagebody";
	var $mPrimary = "image_id";
	var $mClass = "XcoreImagebodyObject";
}
