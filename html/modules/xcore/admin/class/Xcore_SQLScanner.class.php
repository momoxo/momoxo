<?php

class Xcore_SQLScanner extends EasyLex_SQLScanner
{
	var $mDB_PREFIX = "";
	var $mDirname = "";
	
	function setDB_PREFIX($prefix)
	{
		$this->mDB_PREFIX = $prefix;
	}
	
	function setDirname($dirname)
	{
		$this->mDirname = $dirname;
	}
	
	function &getOperations()
	{
		$t_lines = array();
		$t_tokens = array();
		$depth = 0;
		
		foreach (array_keys($this->mTokens) as $key) {
			if ($this->mTokens[$key]->mType == EASYLEX_SQL_OPEN_PARENTHESIS) {
				$depth++;
			}
			elseif ($this->mTokens[$key]->mType == EASYLEX_SQL_CLOSE_PARENTHESIS) {
				$depth--;
			}
			
			$t_tokens[] =& $this->mTokens[$key];
			
			if (count($t_tokens) > 1 && $depth == 0) {
				if ($this->mTokens[$key]->mType == EASYLEX_SQL_SEMICOLON) {
					$t_lines[] =& $t_tokens;
					unset($t_tokens);
					$t_tokens = array();
				}
				elseif ($this->mTokens[$key]->mType == EASYLEX_SQL_LETTER && (strtoupper($this->mTokens[$key]->mValue) =='CREATE' || strtoupper($this->mTokens[$key]->mValue) =='ALTER' || strtoupper($this->mTokens[$key]->mValue) =='INSERT')) {
					array_pop($t_tokens);
					$t_lines[] =& $t_tokens;
					unset($t_tokens);
					$t_tokens = array();
					$t_tokens[] =& $this->mTokens[$key];
				}
			}
		}
		
		if (count($t_tokens) > 0) {
			$t_lines[] =& $t_tokens;
			unset($t_tokens);
		}
		
		//
		// Prepare array for str_replace()
		//
		$t_search = array('{prefix}', '{dirname}', '{Dirname}', '{_dirname_}');
		$t_replace = array($this->mDB_PREFIX, strtolower($this->mDirname), ucfirst(strtolower($this->mDirname)), $this->mDirname);
		
		foreach (array_keys($t_lines) as $idx) {
			foreach (array_keys($t_lines[$idx]) as $op_idx) {
				$t_lines[$idx][$op_idx]->mValue = str_replace($t_search, $t_replace, $t_lines[$idx][$op_idx]->mValue);
			}
		}
		
		return $t_lines;
	}
}

?>
