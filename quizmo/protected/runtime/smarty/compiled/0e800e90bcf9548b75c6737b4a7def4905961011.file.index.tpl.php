<?php /* Smarty version Smarty-3.1.8, created on 2012-04-23 17:44:07
         compiled from "/Applications/MAMP/htdocs/Quizmo/app/quizmo/protected/views/collection/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8963247834f95cd2775fdd3-22301710%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e800e90bcf9548b75c6737b4a7def4905961011' => 
    array (
      0 => '/Applications/MAMP/htdocs/Quizmo/app/quizmo/protected/views/collection/index.tpl',
      1 => 1335214091,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8963247834f95cd2775fdd3-22301710',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'collections' => 0,
    'collection' => 0,
    'this' => 0,
    'collectionLinks' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f95cd2789daa9_23762454',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f95cd2789daa9_23762454')) {function content_4f95cd2789daa9_23762454($_smarty_tpl) {?><h1>Collections</h1>

<div id="collections-container">
<?php  $_smarty_tpl->tpl_vars['collection'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['collection']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['collections']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['collection']->key => $_smarty_tpl->tpl_vars['collection']->value){
$_smarty_tpl->tpl_vars['collection']->_loop = true;
?>
	<div>

		<!-- <?php echo $_smarty_tpl->tpl_vars['this']->value->widget('LinkWidget',array('href'=>$_smarty_tpl->tpl_vars['collection']->value['ID'],'text'=>$_smarty_tpl->tpl_vars['collection']->value['TITLE']),true);?>
<br/> -->
		<a href="<?php echo $_smarty_tpl->tpl_vars['collectionLinks']->value[$_smarty_tpl->tpl_vars['collection']->value['ID']];?>
"><?php echo $_smarty_tpl->tpl_vars['collection']->value['TITLE'];?>
:<?php echo $_smarty_tpl->tpl_vars['collectionLinks']->value[$_smarty_tpl->tpl_vars['collection']->value['ID']];?>
</a>
	</div>
<?php } ?>
</div>
<?php }} ?>