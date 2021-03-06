<?php
/**
 *
 * @package Xcore
 * @version $Id: xoops_version.php,v 1.13 2008/09/25 14:31:43 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momoxo/momoxo>
 * @license https://github.com/momoxo/momoxo/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

$modversion['name'] = _MI_XCORE_NAME;
$modversion['version'] = 2.02;
$modversion['description'] = _MI_XCORE_NAME_DESC;
$modversion['author'] = "";
$modversion['credits'] = "XOOPS Cube Project";
$modversion['help'] = "help.html";
$modversion['license'] = "GPL see LICENSE";
$modversion['image'] = "images/xcore.png";
$modversion['dirname'] = "xcore";

// System Module
$modversion['issystem'] = 1;

$modversion['cube_style'] = true;

// Custom installer
$modversion['xcore_installer']['updater']['class'] = 'ModuleUpdater';
$modversion['xcore_installer']['updater']['filepath'] = XOOPS_XCORE_PATH . '/admin/class/Xcore_Updater.class.php';

//
// Database Setting
//

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Templates
$modversion['templates'][1]['file'] = 'xcore_misc_ssllogin.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'xcore_misc_smilies.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'xcore_search_form.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'xcore_comment_edit.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'xcore_xoops_result.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'xcore_xoops_error.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'xcore_xoops_confirm.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'xcore_comment_navi.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = 'xcore_comment.html';
$modversion['templates'][9]['description'] = '';
$modversion['templates'][10]['file'] = 'xcore_comments_flat.html';
$modversion['templates'][10]['description'] = '';
$modversion['templates'][11]['file'] = 'xcore_comments_nest.html';
$modversion['templates'][11]['description'] = '';
$modversion['templates'][12]['file'] = 'xcore_comments_thread.html';
$modversion['templates'][12]['description'] = '';
$modversion['templates'][13]['file'] = 'xcore_notification_select.html';
$modversion['templates'][13]['description'] = '';
$modversion['templates'][14]['file'] = 'xcore_dummy.html';
$modversion['templates'][14]['description'] = '';
$modversion['templates'][15]['file'] = 'xcore_redirect.html';
$modversion['templates'][15]['description'] = '';
$modversion['templates'][16]['file'] = 'xcore_image_list.html';
$modversion['templates'][16]['description'] = '';
$modversion['templates'][17]['file'] = 'xcore_image_upload.html';
$modversion['templates'][17]['description'] = '';
$modversion['templates'][18]['file'] = 'xcore_rss.html';
$modversion['templates'][18]['description'] = '';
$modversion['templates'][19]['file'] = 'xcore_search_results.html';
$modversion['templates'][19]['description'] = '';
$modversion['templates'][20]['file'] = 'xcore_search_showall.html';
$modversion['templates'][20]['description'] = '';
$modversion['templates'][21]['file'] = 'xcore_search_showallbyuser.html';
$modversion['templates'][21]['description'] = '';
$modversion['templates'][22]['file'] = 'xcore_notification_list.html';
$modversion['templates'][22]['description'] = '';
$modversion['templates'][23]['file'] = 'xcore_notification_delete.html';
$modversion['templates'][23]['description'] = '';
$modversion['templates'][24]['file'] = 'xcore_notification_select_form.html';
$modversion['templates'][24]['description'] = '';
$modversion['templates'][25]['file'] = 'xcore_misc_friend.html';
$modversion['templates'][25]['description'] = '';
$modversion['templates'][26]['file'] = 'xcore_misc_friend_success.html';
$modversion['templates'][26]['description'] = '';
$modversion['templates'][27]['file'] = 'xcore_misc_friend_error.html';
$modversion['templates'][27]['description'] = '';
$modversion['templates'][28]['file'] = 'xcore_xoopsform_checkbox.html';
$modversion['templates'][28]['description'] = 'The embedded template for the checkbox of the xoopsform.';
$modversion['templates'][29]['file'] = 'xcore_xoopsform_button.html';
$modversion['templates'][29]['description'] = 'The embedded template for the button of the xoopsform.';
$modversion['templates'][30]['file'] = 'xcore_xoopsform_text.html';
$modversion['templates'][30]['description'] = 'The embedded template for the text of the xoopsform.';
$modversion['templates'][31]['file'] = 'xcore_xoopsform_select.html';
$modversion['templates'][31]['description'] = 'The embedded template for the select of the xoopsform.';
$modversion['templates'][32]['file'] = 'xcore_xoopsform_file.html';
$modversion['templates'][32]['description'] = 'The embedded template for the file of the xoopsform.';
$modversion['templates'][33]['file'] = 'xcore_xoopsform_hidden.html';
$modversion['templates'][33]['description'] = 'The embedded template for the hidden of the xoopsform.';
$modversion['templates'][34]['file'] = 'xcore_xoopsform_radio.html';
$modversion['templates'][34]['description'] = 'The embedded template for the hidden of the xoopsform.';
$modversion['templates'][35]['file'] = 'xcore_xoopsform_label.html';
$modversion['templates'][35]['description'] = 'The embedded template for the label of the xoopsform.';
$modversion['templates'][36]['file'] = 'xcore_xoopsform_password.html';
$modversion['templates'][36]['description'] = 'The embedded template for the password of the xoopsform.';
$modversion['templates'][37]['file'] = 'xcore_xoopsform_textarea.html';
$modversion['templates'][37]['description'] = 'The embedded template for the textarea of the xoopsform.';
$modversion['templates'][38]['file'] = 'xcore_xoopsform_simpleform.html';
$modversion['templates'][38]['description'] = 'The embedded template for the simple form of the xoopsform.';
$modversion['templates'][39]['file'] = 'xcore_xoopsform_tableform.html';
$modversion['templates'][39]['description'] = 'The embedded template for the table form of the xoopsform.';
$modversion['templates'][40]['file'] = 'xcore_xoopsform_themeform.html';
$modversion['templates'][40]['description'] = 'The embedded template for the theme form of the xoopsform.';
$modversion['templates'][41]['file'] = 'xcore_xoopsform_elementtray.html';
$modversion['templates'][41]['description'] = 'The embedded template for the element tray of the xoopsform.';
$modversion['templates'][42]['file'] = 'xcore_xoopsform_textdateselect.html';
$modversion['templates'][42]['description'] = 'The embedded template for the text date select of the xoopsform.';
$modversion['templates'][43]['file'] = 'xcore_xoopsform_dhtmltextarea.html';
$modversion['templates'][43]['description'] = 'The embedded template for the dhtml text area of the xoopsform.';
$modversion['templates'][44]['file'] = 'xcore_xoopsform_opt_smileys.html';
$modversion['templates'][44]['description'] = 'The embedded template for the smiles list of the dhtml text area of the xoopsform.';
$modversion['templates'][45]['file'] = 'xcore_xoopsform_opt_validationjs.html';
$modversion['templates'][45]['description'] = 'The embedded template for the javascriot of the the xoopsform to validation the input value.';
$modversion['templates'][46]['file'] = 'xcore_xoopsform_grouppermform.html';
$modversion['templates'][46]['description'] = 'The embedded template for the groupperm form of the the xoopsform.';
$modversion['templates'][47]['file'] = 'xcore_inc_tree.html';
$modversion['templates'][47]['description'] = 'xcore_tree default template';
$modversion['templates'][48]['file'] = 'xcore_inc_tag_select.html';
$modversion['templates'][48]['description'] = 'xcore_tag_select default template';
$modversion['templates'][49]['file'] = 'xcore_inc_tag_cloud.html';
$modversion['templates'][49]['description'] = 'xcore_tag_cloud default template';

$modversion['templates'][50]['file']="xcore_dialog.html";


// Menu
$modversion['hasMain'] = 0;

// Blocks
$modversion['blocks'][1]['func_num'] = 1;
$modversion['blocks'][1]['file'] = "xcore_usermenu.php";
$modversion['blocks'][1]['name'] = _MI_XCORE_BLOCK_USERMENU_NAME;
$modversion['blocks'][1]['description'] = _MI_XCORE_BLOCK_USERMENU_DESC;
$modversion['blocks'][1]['show_func'] = "b_xcore_usermenu_show";
$modversion['blocks'][1]['template'] = 'xcore_block_usermenu.html';
$modversion['blocks'][1]['visible_any'] = true;
$modversion['blocks'][1]['show_all_module'] = true;

$modversion['blocks'][2]['func_num'] = 2;
$modversion['blocks'][2]['file'] = "xcore_mainmenu.php";
$modversion['blocks'][2]['name'] = _MI_XCORE_BLOCK_MAINMENU_NAME;
$modversion['blocks'][2]['description'] = _MI_XCORE_BLOCK_MAINMENU_DESC;
$modversion['blocks'][2]['show_func'] = "b_xcore_mainmenu_show";
$modversion['blocks'][2]['edit_func'] = "b_xcore_mainmenu_edit";
$modversion['blocks'][2]['template'] = 'xcore_block_mainmenu.html';
$modversion['blocks'][2]['visible_any'] = true;
$modversion['blocks'][2]['show_all_module'] = true;
$modversion['blocks'][2]['options'] = '0';

$modversion['blocks'][3]['func_num'] = 3;
$modversion['blocks'][3]['file'] = "xcore_search.php";
$modversion['blocks'][3]['name'] = _MI_XCORE_BLOCK_SEARCH_NAME;
$modversion['blocks'][3]['description'] = _MI_XCORE_BLOCK_SEARCH_DESC;
$modversion['blocks'][3]['show_func'] = "b_xcore_search_show";
$modversion['blocks'][3]['template'] = 'xcore_block_search.html';
$modversion['blocks'][3]['show_all_module'] = true;

$modversion['blocks'][4]['func_num'] = 4;
$modversion['blocks'][4]['file'] = "xcore_waiting.php";
$modversion['blocks'][4]['name'] = _MI_XCORE_BLOCK_WAITING_NAME;
$modversion['blocks'][4]['description'] = _MI_XCORE_BLOCK_WAITING_DESC;
$modversion['blocks'][4]['show_func'] = "b_xcore_waiting_show";
$modversion['blocks'][4]['template'] = 'xcore_block_waiting.html';

$modversion['blocks'][5]['func_num'] = 5;
$modversion['blocks'][5]['file'] = "xcore_siteinfo.php";
$modversion['blocks'][5]['name'] = _MI_XCORE_BLOCK_SITEINFO_NAME;
$modversion['blocks'][5]['description'] = _MI_XCORE_BLOCK_SITEINFO_DESC;
$modversion['blocks'][5]['show_func'] = "b_xcore_siteinfo_show";
$modversion['blocks'][5]['edit_func'] = "b_xcore_siteinfo_edit";
$modversion['blocks'][5]['options'] = "320|190|s_poweredby.gif|1";
$modversion['blocks'][5]['template'] = 'xcore_block_siteinfo.html';
$modversion['blocks'][5]['show_all_module'] = true;

$modversion['blocks'][6]['func_num'] = 6;
$modversion['blocks'][6]['file'] = "xcore_comments.php";
$modversion['blocks'][6]['name'] = _MI_XCORE_BLOCK_COMMENTS_NAME;
$modversion['blocks'][6]['description'] = _MI_XCORE_BLOCK_COMMENTS_DESC;
$modversion['blocks'][6]['show_func'] = "b_xcore_comments_show";
$modversion['blocks'][6]['options'] = "10";
$modversion['blocks'][6]['edit_func'] = "b_xcore_comments_edit";
$modversion['blocks'][6]['template'] = 'xcore_block_comments.html';
$modversion['blocks'][6]['show_all_module'] = true;

$modversion['blocks'][7]['func_num'] = 7;
$modversion['blocks'][7]['file'] = "xcore_notification.php";
$modversion['blocks'][7]['name'] = _MI_XCORE_BLOCK_NOTIFICATION_NAME;
$modversion['blocks'][7]['description'] = _MI_XCORE_BLOCK_NOTIFICATION_DESC;
$modversion['blocks'][7]['show_func'] = "b_xcore_notification_show";
$modversion['blocks'][7]['template'] = 'xcore_block_notification.html';

$modversion['blocks'][8]['func_num'] = 8;
$modversion['blocks'][8]['file'] = "xcore_themes.php";
$modversion['blocks'][8]['name'] = _MI_XCORE_BLOCK_THEMES_NAME;
$modversion['blocks'][8]['description'] = _MI_XCORE_BLOCK_THEMES_DESC;
$modversion['blocks'][8]['show_func'] = "b_xcore_themes_show";
$modversion['blocks'][8]['options'] = "0|80";
$modversion['blocks'][8]['edit_func'] = "b_xcore_themes_edit";
$modversion['blocks'][8]['template'] = 'xcore_block_themes.html';

