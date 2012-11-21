<?php

/**
  * Regenerate New Session ID & Delete OLD Session
  * @deprecated
  */

function xoops_session_regenerate()
{
    $root =& XCube_Root::getSingleton();
    $root->mSession->regenerate();
}

