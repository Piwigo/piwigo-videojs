<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

/**
 * This class is used to expose maintenance methods to the plugins manager
 * It must extends PluginMaintain and be named "PLUGINID_maintain"
 * where PLUGINID is the directory name of your plugin.
 */
class piwigo_videojs_maintain extends PluginMaintain
{
  private $default_conf = array(
    'skin' => 'vjs-default-skin',
    'max_height' => '720',
    'preload' => 'auto',
    'controls' => true,
    'autoplay' => false,
    'loop' => false,
    'volume' => '1',
    'upscale' => false,
    'plugins' => array(
      'zoomrotate' => false,
      'thumbnails' => false,
      'watermark' => false,
      'resolution' => false,
    ),
    'player' => 'html5-player.tpl',
    'metadata' => true,
  );

  private $default_sync_options = array(
    'mediainfo' => 'mediainfo',
    'ffmpeg' => 'ffmpeg',
    'exiftool' => 'exiftool',
    'ffprobe' => 'ffprobe',
    'metadata' => true,
    'representative' => true,
    'poster' => true,
    'postersec' => 4,
    'output' => 'jpg',
    'posteroverlay' => false,
    'posteroverwrite' => false,
    'thumb' => false,
    'thumbsec' => 5,
    'thumbsize' => "120x68",
    'simulate' => true,
    'cat_id' => 0,
    'subcats_included' => true,
  );

  private $table;

  function __construct($plugin_id)
  {
    parent::__construct($plugin_id); // always call parent constructor

    global $prefixeTable;

    // Class members can't be declared with computed values so initialization is done here
    $this->table = $prefixeTable . 'image_videojs';
  }

  /**
   * Plugin installation
   *
   * Perform here all needed step for the plugin installation such as create default config,
   * add database tables, add fields to existing tables, create local folders...
   */
  function install($plugin_version, &$errors=array())
  {
    global $conf;

    // add config parameter
    if (empty($conf['vjs_conf']))
    {
      conf_update_param('vjs_conf', $this->default_conf, true);
      
      /* Add a comment to the entry */
      $q = 'UPDATE '.CONFIG_TABLE.' SET `comment` = "Player settings for piwigo-videojs plugin" WHERE `param` = "vjs_conf";';
      pwg_query( $q );
    }
    else
    {
      $old_conf = safe_unserialize($conf['vjs_conf']);

      foreach ($this->default_conf as $conf_settings_group_key => $conf_settings_group_value)
      {
        if (!isset($old_conf[$conf_settings_group_key]))
        {
          $old_conf[$conf_settings_group_key] = $conf_settings_group_value;
        }
        else
        {
          if (is_array($conf_settings_group_value))
          {
            foreach ($conf_settings_group_value as $key => $value)
            {
              if (!isset($old_conf[$conf_settings_group_key][$key]))
              {
                $old_conf[$conf_settings_group_key][$key] = $value;
              }
            }
          }
        }
      }

      conf_update_param('vjs_conf', $old_conf, true);
    }

    // add sync parameters (why a second parameter ?!?). Simpler than vjs_conf because a simpler array
    // with scalar value. No sub-arrays.
    if (empty($conf['vjs_sync']))
    {
      conf_update_param('vjs_sync', $this->default_sync_options, true);

      /* Add a comment to the entry */
      $q = 'UPDATE '.CONFIG_TABLE.' SET `comment` = "Sync settings for piwigo-videojs plugin" WHERE `param` = "vjs_sync";';
      pwg_query( $q );
    }
    else
    {
      $old_conf = safe_unserialize($conf['vjs_sync']);

      foreach ($this->default_sync_options as $sync_option_key => $sync_option_value)
      {
        if (!isset($old_conf[$sync_option_key]))
        {
          $old_conf[$sync_option_key] = $sync_option_value;
        }
      }

      conf_update_param('vjs_sync', $old_conf, true);
    }

    // Keep customCSS separate as it can be big entry
    if (empty($conf['vjs_customcss']))
    {
      conf_update_param('vjs_customcss', '');
    }

    // add a new table
    pwg_query('
CREATE TABLE IF NOT EXISTS `'.$this->table.'` (
  `id` mediumint(8) unsigned NOT NULL,
  `metadata` text DEFAULT NULL,
  `date_metadata_update` DATE DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
;');
  }

  /**
   * Plugin activation
   *
   * This function is triggered after installation, by manual activation or after a plugin update
   * for this last case you must manage updates tasks of your plugin in this function
   */
  function activate($plugin_version, &$errors=array())
  {
  }

  /**
   * Plugin deactivation
   *
   * Triggered before uninstallation or by manual deactivation
   */
  function deactivate()
  {
  }

  /**
   * Plugin (auto)update
   *
   * This function is called when Piwigo detects that the registered version of
   * the plugin is older than the version exposed in main.inc.php
   * Thus it's called after a plugin update from admin panel or a manual update by FTP
   */
  function update($old_version, $new_version, &$errors=array())
  {
    // I (mistic100) chosed to handle install and update in the same method
    // you are free to do otherwize
    $this->install($new_version, $errors);
  }

  /**
   * Plugin uninstallation
   *
   * Perform here all cleaning tasks when the plugin is removed
   * you should revert all changes made in 'install'
   */
  function uninstall()
  {
    // delete configuration
    conf_delete_param('vjs_conf');
    conf_delete_param('vjs_sync');
    conf_delete_param('vjs_customcss');

    // delete table
    pwg_query('DROP TABLE `'. $this->table .'`;');
  }
}
