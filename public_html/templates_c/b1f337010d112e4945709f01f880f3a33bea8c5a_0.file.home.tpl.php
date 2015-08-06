<?php /* Smarty version 3.1.27, created on 2015-08-06 18:42:20
         compiled from "C:\xampp\htdocs\mvc-web-application\core\views\templates\home.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2529655c38e6c7d7624_30061407%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1f337010d112e4945709f01f880f3a33bea8c5a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mvc-web-application\\core\\views\\templates\\home.tpl',
      1 => 1438879336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2529655c38e6c7d7624_30061407',
  'variables' => 
  array (
    'template_dir' => 0,
    'STRING' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55c38e6c83f258_05011080',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55c38e6c83f258_05011080')) {
function content_55c38e6c83f258_05011080 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2529655c38e6c7d7624_30061407';
echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['template_dir']->value)."/_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php echo $_smarty_tpl->tpl_vars['STRING']->value['HELLO_WORLD'];?>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['template_dir']->value)."/_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>