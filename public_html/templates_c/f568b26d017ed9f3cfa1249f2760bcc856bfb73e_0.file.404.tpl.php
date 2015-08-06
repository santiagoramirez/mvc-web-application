<?php /* Smarty version 3.1.27, created on 2015-08-06 18:49:36
         compiled from "C:\xampp\htdocs\mvc-web-application\core\views\templates\404.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1582255c390209015d7_17546472%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f568b26d017ed9f3cfa1249f2760bcc856bfb73e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mvc-web-application\\core\\views\\templates\\404.tpl',
      1 => 1438879766,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1582255c390209015d7_17546472',
  'variables' => 
  array (
    'template_dir' => 0,
    'STRING' => 0,
    'domain_root' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55c3902095bf31_33957648',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55c3902095bf31_33957648')) {
function content_55c3902095bf31_33957648 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1582255c390209015d7_17546472';
echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['template_dir']->value)."/_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php echo $_smarty_tpl->tpl_vars['STRING']->value['404_MESSAGE'];?>

<br/>
<a href="<?php echo $_smarty_tpl->tpl_vars['domain_root']->value;?>
">Go home >></a>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['template_dir']->value)."/_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>