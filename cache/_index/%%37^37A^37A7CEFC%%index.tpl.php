<?php /* Smarty version 2.6.28, created on 2014-09-12 10:19:17
         compiled from F:%5Cwww%5Cframework%5Clib/templates/system/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'tr', 'F:\\www\\framework\\lib/templates/system/index.tpl', 11, false),array('function', 'eval', 'F:\\www\\framework\\lib/templates/system/index.tpl', 13, false),array('modifier', 'default', 'F:\\www\\framework\\lib/templates/system/index.tpl', 29, false),)), $this); ?>
<?php if ($this->_tpl_vars['render_type'] == 'all'): ?>
<?php echo $this->_tpl_vars['p']['doctype']; ?>

<?php echo $this->_tpl_vars['p']['html_tag']; ?>

<head>
<meta http-equiv="Content-Type" content="<?php echo $this->_tpl_vars['p']['content_type']; ?>
" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php $_from = $this->_tpl_vars['p']['meta_tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
<meta name="<?php echo $this->_tpl_vars['tag']['name']; ?>
" content="<?php echo $this->_tpl_vars['tag']['content']; ?>
" />
<?php endforeach; endif; unset($_from); ?>

<title><?php $this->_tag_stack[] = array('tr', array('tags' => 'titles')); $_block_repeat=true;$this->_plugins['block']['tr'][0][0]->tr_v2($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['p']['title']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['tr'][0][0]->tr_v2($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></title>

<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['__before_skin']), $this);?>


<?php $_from = $this->_tpl_vars['p']['css_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['style']):
?>
	<?php if ($this->_tpl_vars['style']['browser_cond']): ?><!--[<?php echo $this->_tpl_vars['style']['browser_cond']; ?>
]><?php endif; ?>
	<link rel="stylesheet" type="<?php echo $this->_tpl_vars['style']['type']; ?>
" href="<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['style']['href']), $this);?>
" media="<?php echo $this->_tpl_vars['style']['media']; ?>
"/>	
	<?php if ($this->_tpl_vars['style']['browser_cond']): ?><![endif]--><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

<?php $_from = $this->_tpl_vars['p']['js_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js']):
?>
	<script src="<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['js']['src']), $this);?>
" type="<?php echo $this->_tpl_vars['js']['type']; ?>
"></script>
<?php endforeach; endif; unset($_from); ?>

<?php if (isset ( $this->_tpl_vars['p']['session']['script'] ) && $this->_tpl_vars['p']['session']['script']): ?>
<script src="<?php echo $this->_tpl_vars['root_module']; ?>
script_file_<?php echo $this->_tpl_vars['random']; ?>
.js" type="text/javascript"></script>
<?php endif; ?>

<?php echo ((is_array($_tmp=@$this->_tpl_vars['page_before_close_head'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>

</head>
<?php echo $this->_tpl_vars['p']['body_tag']; ?>

	<?php echo ((is_array($_tmp=@$this->_tpl_vars['page_after_start_body'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>

	<noscript><?php echo smarty_function_eval(array('var' => ((is_array($_tmp=@$this->_tpl_vars['__noscript'])) ? $this->_run_mod_handler('default', true, $_tmp, ' ') : smarty_modifier_default($_tmp, ' '))), $this);?>
</noscript>
	<?php echo $this->_tpl_vars['p']['settings']['before_page_text']['value']; ?>

	
	<?php echo $this->_tpl_vars['page_trace']; ?>

	
	<?php echo $this->_tpl_vars['page']; ?>

    
	<?php echo $this->_tpl_vars['p']['settings']['after_page_text']['value']; ?>

	<?php echo $this->_tpl_vars['page_before_close_body']; ?>

</body>
<?php echo $this->_tpl_vars['page_after_body']; ?>

</html>
<?php else: ?>
<?php ob_start(); ?><?php echo '{'; ?>
$<?php echo $this->_tpl_vars['render_type']; ?>
<?php echo '}'; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ptemp', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['ptemp']), $this);?>

<?php echo $this->_tpl_vars['bottom_script']; ?>

<?php endif; ?>