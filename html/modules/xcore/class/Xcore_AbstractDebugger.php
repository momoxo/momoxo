<?php

class Xcore_AbstractDebugger
{
	function Xcore_AbstractDebugger()
	{
	}

	function prepare()
	{
	}
	
	function isDebugRenderSystem()
	{
		return false;
	}

	/***
	 * @return string Log as html code.
	 */	
	function renderLog()
	{
	}
	
	function displayLog()
	{
	}
}
