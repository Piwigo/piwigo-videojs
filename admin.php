<?php
// Chech whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// Fetch the template.
global $template, $conf;

// Load parameter
$skin = $conf['videojs_skin'];

// Available skins
$available_skins = array(
    'vjs-default-skin' => 'default',
    'tubecss' => 'tubecss',
);

// Update conf if submitted in admin site
if (isset($_POST['submit']) && !empty($_POST['skin'])) {
    $query = 'UPDATE ' . CONFIG_TABLE . 
             ' SET value="' . $_POST['skin'] . '" 
              WHERE param="videojs_skin"';
    pwg_query($query);
    // keep this selected in the admin form 
    $skin = $_POST['skin'];
}

// 
$template->assign(array(
    'SELECTED_SKIN'   => $skin,
    'AVAILABLE_SKINS' => $available_skins,
));

// Add our template to the global template
$template->set_filenames(
  array(
    'plugin_admin_content' => dirname(__FILE__).'/admin.tpl'
  )         
);

// Assign the template contents to ADMIN_CONTENT
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>
