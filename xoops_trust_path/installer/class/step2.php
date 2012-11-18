<?php

function process($xoops_root_path, $xoops_trust_path, $config_path) {
  extract($_POST, EXTR_OVERWRITE);
  $salt = sha1(microtime() . var_export($_POST, 1));

  if ($admin_password !== $admin_password_confirm) {
    // return new Error('パスワードが一致しません');
  }

  ob_start();
  include INSTALLER_DIR.'/config.dist.php';
  $contents = ob_get_clean();
  file_put_contents($config_path, $contents);
  include_once $config_path;

  // DB Insert
  include_once INSTALLER_DIR . '/lib/db_manager.php';
  $dbm = new db_manager();

  if ($dbm->dbExists() === false) {
    return new Error('DB設定が間違っています.');
  }

  $result = $dbm->queryFromFile(INSTALLER_DIR . '/sql/mysql.structure.sql');
  if ($result === false) {
    die("テーブルの作成に失敗しました.");
  }

  $time_diff = date('Z') / 3600;
  $temp = md5($admin_password);
  $regdate = time();
  $result = $dbm->insert('users', " VALUES (1,'','".addslashes($admin_uname)."','".addslashes($admin_email)."','".XOOPS_URL."/','blank.gif','".$regdate."','','','',1,'','','','','".$temp."',0,0,7,5,'','".$time_diff."',".time().",'thread',0,1,0,'','','',0)");
  if ($result !== 1) {
    die("データの挿入に失敗しました.");
  }

  $result = $dbm->queryFromFile(INSTALLER_DIR . '/sql/mysql.data.sql');
  if ($result === false) {
    die("データの挿入に失敗しました.");
  }

  return array(
    'xoops_url'      => $xoops_url,
    'admin_uname'    => $admin_uname,
    'admin_password' => $admin_password,
  );
}
