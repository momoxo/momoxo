<?php /* Smarty version 2.6.27, created on 2012-11-17 16:07:24
         compiled from file:module_information.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'file:module_information.html', 24, false),array('modifier', 'xoops_formattimestamp', 'file:module_information.html', 55, false),array('function', 'cycle', 'file:module_information.html', 27, false),array('function', 'math', 'file:module_information.html', 35, false),)), $this); ?>
<div class="adminnavi">
  <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <a href="./index.php?action=ModuleList"><?php echo @_MI_LEGACY_MENU_MODULELIST; ?>
</a>
  <?php if (! $this->_tpl_vars['installed']): ?>
    &raquo;&raquo; <span class="adminnaviTitle"><a href="./index.php?action=InstallList"><?php echo @_AD_LEGACY_LANG_MODINSTALL; ?>
</a></span>
  <?php endif; ?>
  &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_AD_LEGACY_LANG_INFORMATION; ?>
</span>
</div>

<h3 class="admintitle"><?php echo @_AD_LEGACY_LANG_INFORMATION; ?>
</h3>

<h4 class="admintitle"><?php echo @_AD_LEGACY_LANG_MOD_BASIC_INFO; ?>
</h4>
<table class="outer">
  <tr>
    <th colspan="3"><?php echo @_AD_LEGACY_LANG_MOD_BASIC_INFO; ?>
</th>
  </tr>
  <tr>
    <td class="head legacy_list_image" rowspan="6">
<?php if ($this->_tpl_vars['installed'] && $this->_tpl_vars['module']->get('hasmain')): ?>
      <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/<?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
/"><img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/<?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
/<?php echo $this->_tpl_vars['module']->modinfo['image']; ?>
" alt="<?php echo $this->_tpl_vars['module']->getShow('name'); ?>
" title="<?php echo $this->_tpl_vars['module']->getShow('name'); ?>
" /></a>
<?php else: ?>
      <img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/<?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
/<?php echo $this->_tpl_vars['module']->modinfo['image']; ?>
" alt="<?php echo $this->_tpl_vars['module']->getShow('name'); ?>
" title="<?php echo $this->_tpl_vars['module']->getShow('name'); ?>
" />
<?php endif; ?>
      <div class="legacy_list_imagetitle"><?php echo ((is_array($_tmp=$this->_tpl_vars['module']->modinfo['name'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</div>
    </td>
	<td class="head"><?php echo @_AD_LEGACY_LANG_MOD_NAME; ?>
</td>
	<td class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
"><?php echo $this->_tpl_vars['module']->getShow('name'); ?>
</td>
  </tr>
  <tr>
	<td class="head"><?php echo @_AD_LEGACY_LANG_MOD_DIR_NAME; ?>
</td>
	<td class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
"><?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
</td>
  </tr>
  <tr>
	<td class="head"><?php echo @_AD_LEGACY_LANG_VERSION; ?>
</td>
	<td class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
"><?php echo smarty_function_math(array('equation' => "v/100",'v' => $this->_tpl_vars['module']->get('version'),'format' => "%.2f"), $this);?>

	<?php if ($this->_tpl_vars['module']->get('version')/100 != $this->_tpl_vars['module']->modinfo['version']): ?>
	  &raquo; <b class="legacy_module_warning"><?php echo smarty_function_math(array('equation' => $this->_tpl_vars['module']->modinfo['version'],'format' => "%.2f"), $this);?>
</b>
	<?php endif; ?>
	</td>
  </tr>
  <tr>
	<td class="head"><?php echo @_AD_LEGACY_LANG_MOD_MID; ?>
</td>
	<td class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	  <?php if ($this->_tpl_vars['module']->get('mid')): ?>
	    <?php echo $this->_tpl_vars['module']->getShow('mid'); ?>

	  <?php else: ?>
	    --
	  <?php endif; ?>
	</td>
  </tr>
  <tr>
	<td class="head"><?php echo @_AD_LEGACY_LANG_LASTUPDATE; ?>
</td>
	<td class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	  <?php if ($this->_tpl_vars['module']->get('last_update')): ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['module']->get('last_update'))) ? $this->_run_mod_handler('xoops_formattimestamp', true, $_tmp, 'l') : smarty_modifier_xoops_formattimestamp($_tmp, 'l')); ?>

      <?php else: ?>
        --
      <?php endif; ?>
    </td>
  </tr>
  <tr>
	<td class="head"><?php echo @_AD_LEGACY_LANG_MOD_DESC; ?>
</td>
	<td class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
"><?php echo $this->_tpl_vars['module']->modinfo['description']; ?>
</td>
  </tr>
</table>

<div class="return_top"><a href="#container"><?php echo @_RETURN_TOP; ?>
</a></div>
<hr />
<h4 class="admintitle"><?php echo @_AD_LEGACY_LANG_MOD_LICENSE_INFO; ?>
</h4>
<table class="outer">
  <tr>
    <th colspan="2"><?php echo @_AD_LEGACY_LANG_MOD_LICENSE_INFO; ?>
</th>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_AD_LEGACY_LANG_MODULE_LICENSE; ?>
</td>
	<td><?php echo $this->_tpl_vars['module']->modinfo['license']; ?>
</td>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_AD_LEGACY_LANG_MOD_AUTHOR; ?>
</td>
	<td><?php echo $this->_tpl_vars['module']->modinfo['author']; ?>
</td>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_AD_LEGACY_LANG_MOD_CREDITS; ?>
</td>
	<td><?php echo $this->_tpl_vars['module']->modinfo['credits']; ?>
</td>
  </tr>
</table>

<div class="return_top"><a href="#container"><?php echo @_RETURN_TOP; ?>
</a></div>
<hr />
<h4 class="admintitle"><?php echo @_AD_LEGACY_LANG_SQL_INFO; ?>
</h4>
<?php if ($this->_tpl_vars['module']->modinfo['tables']): ?>
<table class="outer">
  <tr>
    <th colspan="2"><?php echo @_AD_LEGACY_LANG_SQL_INFO; ?>
</th>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head" style="width:30%;"><?php echo @_AD_LEGACY_LANG_SQL_HAS_MAIN; ?>
</td>
	<td><?php echo @_AD_LEGACY_LANG_ACTIVE; ?>
</td>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_AD_LEGACY_LANG_SQL_ENGINE; ?>
</td>
	<td><?php echo @_AD_LEGACY_LANG_SQL_MYSQL; ?>
</td>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_AD_LEGACY_LANG_SQL_FILE_NAME; ?>
</td>
	<td><?php echo $this->_tpl_vars['module']->modinfo['sqlfile']['mysql']; ?>
</td>
  </tr>
</table>
<br />
<table class="outer">
  <tr>
	<th><?php echo @_AD_LEGACY_LANG_TABLE_NUM; ?>
</th>
	<th><?php echo @_AD_LEGACY_LANG_TABLE_NAME; ?>
</th>
	<th><?php echo @_AD_LEGACY_LANG_TABLE_PROPERTIES; ?>
</th>
  </tr>
<?php $_from = $this->_tpl_vars['module']->modinfo['tables']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['table_key'] => $this->_tpl_vars['table']):
?>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head legacy_list_id"><?php echo $this->_tpl_vars['table_key']; ?>
</td>
	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['table'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
	<td></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php else: ?>
  <div class="legacy_modinfo_notmounted"><?php echo @_AD_LEGACY_LANG_NO_SQL; ?>
</div>
<?php endif; ?>

<div class="return_top"><a href="#container"><?php echo @_RETURN_TOP; ?>
</a></div>
<hr />
<h4 class="admintitle"><?php echo @_AD_LEGACY_LANG_MAINMENU_INFO; ?>
</h4>
<?php if ($this->_tpl_vars['module']->get('hasmain')): ?>

<table class="outer">
  <tr>
    <th colspan="2"><?php echo @_AD_LEGACY_LANG_MAINMENU_INFO; ?>
</th>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head" style="width:30%;"><?php echo @_AD_LEGACY_LANG_MAINMENU_HAS_MAIN; ?>
</td>
	<td><?php echo @_AD_LEGACY_LANG_ACTIVE; ?>
</td>
  </tr>
</table>

<br />
<table class="outer">
  <tr>
	<th><?php echo @_AD_LEGACY_LANG_SUBMENU_NAME; ?>
</th>
	<th><?php echo @_AD_LEGACY_LANG_SUBMENU_URL; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['module']->modinfo['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub']):
?>
  <tr class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
    <td><?php echo $this->_tpl_vars['sub']['name']; ?>
</td>
    <td><?php echo $this->_tpl_vars['sub']['url']; ?>
</td>
  </tr>
  <?php endforeach; else: ?>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
    <td colspan="2"><?php echo @_AD_LEGACY_LANG_NO_SUBMENU; ?>
</td>
  </tr>
  <?php endif; unset($_from); ?>
</table>

<?php else: ?>
<div class="legacy_modinfo_notmounted"><?php echo @_AD_LEGACY_LANG_NO_MAINMENU; ?>
</div>
<?php endif; ?>

<div class="return_top"><a href="#container"><?php echo @_RETURN_TOP; ?>
</a></div>
<hr />
<h4 class="admintitle"><?php echo @_AD_LEGACY_LANG_ADMIN_MENU; ?>
</h4>
<?php if ($this->_tpl_vars['module']->get('hasadmin')): ?>
<table class="outer">
  <tr>
    <th colspan="2"><?php echo @_AD_LEGACY_LANG_ADMIN_MENU; ?>
</th>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head" style="width:30%;"><?php echo @_AD_LEGACY_LANG_ADMINMENU_HAS_MAIN; ?>
</td>
	<td><?php echo @_AD_LEGACY_LANG_ACTIVE; ?>
</td>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_AD_LEGACY_LANG_ADMINMENU_INDEX; ?>
</td>
	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['module']->modinfo['adminindex'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_AD_LEGACY_LANG_ADMINMENU_MENU; ?>
</td>
	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['module']->modinfo['adminmenu'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_HELP; ?>
</td>
	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['module']->modinfo['help'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
  </tr>
</table>
<?php if ($this->_tpl_vars['module']->adminmenu): ?>
<br />
<table class="outer">
  <tr>
	<th><?php echo @_AD_LEGACY_LANG_TEMPLATE_KEY; ?>
</th>
	<th><?php echo @_AD_LEGACY_LANG_ADMINMENU_NAME; ?>
</th>
	<th><?php echo @_AD_LEGACY_LANG_ADMINMENU_URL; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['module']->adminmenu; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['admin_key'] => $this->_tpl_vars['admin']):
?>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head legacy_list_id"><?php echo ((is_array($_tmp=$this->_tpl_vars['admin_key'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['admin']['title'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['admin']['link'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>
<?php else: ?>
  <div class="legacy_modinfo_notmounted"><?php echo @_AD_LEGACY_LANG_NO_ADMINMENU; ?>
</div>
<?php endif; ?>

<div class="return_top"><a href="#container"><?php echo @_RETURN_TOP; ?>
</a></div>
<hr />
<h4 class="admintitle"><?php echo @_AD_LEGACY_LANG_TEMPLATE_INFO; ?>
</h4>
<?php if ($this->_tpl_vars['module']->modinfo['templates']): ?>
<table class="outer">
  <tr>
    <th colspan="2"><?php echo @_AD_LEGACY_LANG_TEMPLATE_INFO; ?>
</th>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head" style="width:30%;"><?php echo @_AD_LEGACY_LANG_TEMPLATE_HAS_MAIN; ?>
</td>
	<td><?php echo @_AD_LEGACY_LANG_ACTIVE; ?>
</td>
  </tr>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head"><?php echo @_AD_LEGACY_LANG_TEMPLATE_ENGINE; ?>
</td>
	<td><?php echo @_AD_LEGACY_LANG_SMARTY; ?>
</td>
  </tr>
</table>
<br />
<table class="outer">
  <tr>
	<th><?php echo @_AD_LEGACY_LANG_TEMPLATE_KEY; ?>
</th>
	<th><?php echo @_AD_LEGACY_LANG_TEMPLATE_FILE; ?>
</th>
	<th><?php echo @_AD_LEGACY_LANG_TEMPLATE_DESC; ?>
</th>
  </tr>
<?php $_from = $this->_tpl_vars['module']->modinfo['templates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['template_key'] => $this->_tpl_vars['template']):
?>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
	<td class="head legacy_list_id"><?php echo $this->_tpl_vars['template_key']; ?>
</td>
	<td>
	<?php if ($this->_tpl_vars['installed']): ?>
	<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacyRender/admin/index.php?action=TplfileList&amp;tpl_file=<?php echo $this->_tpl_vars['template']['file']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['template']['file'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</a>
	<?php else: ?>
	<?php echo ((is_array($_tmp=$this->_tpl_vars['template']['file'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>

	<?php endif; ?>
	</td>
	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['template']['description'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php else: ?>
  <div class="legacy_modinfo_notmounted"><?php echo @_AD_LEGACY_LANG_NO_TEMPLATE; ?>
</div>
<?php endif; ?>

<div class="return_top"><a href="#container"><?php echo @_RETURN_TOP; ?>
</a></div>
<hr />
<h4 class="admintitle"><?php echo @_AD_LEGACY_LANG_BLOCKS_INFO; ?>
</h4>

<?php $_from = $this->_tpl_vars['module']->modinfo['blocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block_num'] => $this->_tpl_vars['block']):
?>
<table class="outer">
  <tr>
	<th><?php echo @_AD_LEGACY_LANG_BLOCK_KEY; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['block_num'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
)</th>
	<th><?php echo @_AD_LEGACY_LANG_BLOCK_VAL; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['block']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['block'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['block']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['block_key'] => $this->_tpl_vars['block_val']):
        $this->_foreach['block']['iteration']++;
?>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even','name' => 'block'), $this);?>
">
	<td class="head legacy_list_name" style="width:30%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['block_key'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
	<?php if ($this->_tpl_vars['block_key'] == 'name'): ?>
	  <td><b><?php echo ((is_array($_tmp=$this->_tpl_vars['block_val'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</b></td>
	<?php elseif ($this->_tpl_vars['installed'] && $this->_tpl_vars['block_key'] == 'template'): ?>
	  <td><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacyRender/admin/index.php?action=TplfileList&amp;tpl_file=<?php echo $this->_tpl_vars['block_val']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['block_val'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</a></td>
	<?php else: ?>
	  <td><?php echo ((is_array($_tmp=$this->_tpl_vars['block_val'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
	<?php endif; ?>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
<br />
<?php endforeach; else: ?>
  <div class="legacy_modinfo_notmounted"><?php echo @_AD_LEGACY_LANG_NO_BLOCK; ?>
</div>
<?php endif; unset($_from); ?>

<div class="return_top"><a href="#container"><?php echo @_RETURN_TOP; ?>
</a></div>
<hr />
<h4 class="admintitle"><?php echo @_AD_LEGACY_LANG_CONFIG_INFO; ?>
</h4>

<?php $_from = $this->_tpl_vars['module']->modinfo['config']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['conf_num'] => $this->_tpl_vars['config']):
?>
<table class="outer">
  <tr>
	<th><?php echo @_AD_LEGACY_LANG_CONFIG_KEY; ?>
 (<?php echo $this->_tpl_vars['conf_num']; ?>
)</th>
	<th><?php echo @_AD_LEGACY_LANG_CONFIG_VAL; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['config']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['config'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['config']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['config_key'] => $this->_tpl_vars['config_val']):
        $this->_foreach['config']['iteration']++;
?>
  <tr class="<?php echo smarty_function_cycle(array('values' => "odd,even",'name' => 'config'), $this);?>
">
	<td class="head legacy_list_name" style="width:30%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['config_key'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
	<td>
	  <?php if ($this->_tpl_vars['config_key'] == 'name'): ?>
	    <b><?php echo ((is_array($_tmp=$this->_tpl_vars['config_val'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</b>
      <?php elseif ($this->_tpl_vars['config_key'] == options): ?>
	    <?php $_from = $this->_tpl_vars['config_val']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['opt_key'] => $this->_tpl_vars['opt']):
?>
	      <?php echo $this->_tpl_vars['opt_key']; ?>
 &raquo; <?php echo ((is_array($_tmp=$this->_tpl_vars['opt'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
<br />
	    <?php endforeach; endif; unset($_from); ?>
	  <?php else: ?>
	    <?php echo ((is_array($_tmp=$this->_tpl_vars['config_val'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>

	  <?php endif; ?>
	</td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
<br />
<?php endforeach; else: ?>
  <div class="legacy_modinfo_notmounted"><?php echo @_AD_LEGACY_LANG_NO_CONFIG; ?>
</div>
<?php endif; unset($_from); ?>
