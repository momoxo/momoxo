<?php

class Xcore_MysqlDebugger extends Xcore_AbstractDebugger
{
	function prepare()
	{
		$GLOBALS['xoopsErrorHandler'] = XoopsErrorHandler::getInstance();
		$GLOBALS['xoopsErrorHandler']->activate(true);
	}
	
	function renderLog()
	{
		$xoopsLogger =& XoopsLogger::instance();
		return $xoopsLogger->dumpAll();
	}
	
	function displayLog()
	{
        echo '<script type="text/javascript">
        <!--//
        debug_window = openWithSelfMain("", "xoops_debug", 680, 600, true);
        ';
        $content = '<html><head><meta http-equiv="content-type" content="text/html; charset='._CHARSET.'" /><meta http-equiv="content-language" content="'._LANGCODE.'" /><title>'.htmlspecialchars($GLOBALS['xoopsConfig']['sitename']).'</title><link rel="stylesheet" type="text/css" media="all" href="'.getcss($GLOBALS['xoopsConfig']['theme_set']).'" /></head><body>'.$this->renderLog().'<div style="text-align:center;"><input class="formButton" value="'._CLOSE.'" type="button" onclick="javascript:window.close();" /></div></body></html>';
        $lines = preg_split("/(\r\n|\r|\n)( *)/", $content);
        foreach ($lines as $line) {
            echo 'debug_window.document.writeln("'.str_replace('"', '\"', $line).'");';
        }
        echo '
        debug_window.document.close();
        //-->
        </script>';
	}
}
