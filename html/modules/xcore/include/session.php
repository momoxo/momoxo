<?php

/**
  * Regenerate New Session ID & Delete OLD Session
  * @deprecated
  */

use XCore\Kernel\Root;

function xoops_session_regenerate()
{
    $root =& Root::getSingleton();
    $root->mSession->regenerate();
}

