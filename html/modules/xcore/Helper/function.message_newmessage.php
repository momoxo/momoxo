<?php

use XCore\Kernel\Root;

function smarty_function_message_newmessage($params, &$smarty)
{
  $name = isset($params['name']) ? trim($params['name']) : 'new_messages';
  $open = isset($params['open']) ? trim($params['open']) : 'open_message_alert';
  
  $new_messages = false;
  $root = Root::getSingleton();
  if ($root->mContext->mUser->isInRole('Site.RegisteredUser')) {
    $modHand = xoops_getmodulehandler('inbox', 'message');
    $new_messages = $modHand->getCountUnreadByFromUid($root->mContext->mKarimojiUser->get('uid'));
    if ( empty($_SESSION[$name]) ) {
      $_SESSION[$name] = 0;
    }
    if ( $_SESSION['new_messages'] < $new_messages ) {
      $smarty->assign($open, 1);
    }
    $_SESSION[$name] = $new_messages ;
  }
  $smarty->assign($name, $new_messages);
}
