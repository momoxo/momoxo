<?php

function process($xoops_root_path, $xoops_trust_path) {
  // @todo SSL対応
  $xoops_url = sprintf('http://%s/%s', $_SERVER['SERVER_NAME'], str_replace('/install/index.php', '', $_SERVER['SCRIPT_NAME']));
  $xoops_url = preg_replace('/\/$/', '', $xoops_url);

  $errors = array();

  if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    $errors['php_version'] = true;
  }

  $check_extensions = array(
    'gd',
    'mbstring',
    'mysql',
  );
  foreach ($check_extensions as $extension_name) {
    if (extension_loaded($extension_name) === false) {
      if (isset($errors['extension']) === false) {
        $errors['extension'] = array();
      }

      $errors['extension'][] = $extension_name;
    }
  }


  $check_dirs = array(
    $xoops_root_path . '/mainfile.php',
    $xoops_root_path . '/uploads/',

    $xoops_trust_path . '/cache/',
    $xoops_trust_path . '/templates_c/',
    $xoops_trust_path . '/uploads/',
    $xoops_trust_path . '/uploads/xupdate/',
    $xoops_trust_path . '/modules/protector/configs/',
  );
  foreach ($check_dirs as $dir) {
    if (is_writable($dir) === false) {
      if (isset($errors['permission']) === false) {
        $errors['permission'] = array();
      }

      $errors['permission'][] = $dir;
    }
  }

  return array(
    'xoops_url' => $xoops_url,
    'errors'    => $errors,
  );
}
