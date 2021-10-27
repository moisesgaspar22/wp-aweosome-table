<?php

namespace MgTest\core;

use MgTest\settings\MgTestSettings;
use MgTest\admin\MgTestAdmin;
use MgTest\controlers\AjaxController;
use MgTest\controlers\ShortcodesController;
use MgTest\controlers\WpCliCommandController;
use MgTest\models\TableData;
use MgTest\src\controlers\AdminController;

/**
 * Aplication class
 */
final class App
{

    public $version = '1.0.0';

    /**
     * Initiate Plugin
     *
     * @return void
     */
    public function init()
    {
        $this->_loadActions();
        $this->_loadShortcodes();
    }

    private function _loadActions()
    {
        add_action('admin_menu', [new MgTestAdmin(), 'buildAdminBackEnd']);
        add_action('init', [$this, 'loadLanguages']);
        add_action('init', [new AjaxController(), 'init']);
        add_action('cli_init', [new WpCliCommandController(), 'wdsCliRegisterCommands']);
    }

    private function _loadShortcodes()
    {
        add_shortcode(ShortcodesController::AWEOSOME_TABLE_SHORT_NAME, [new ShortcodesController(), 'aweosomeTableShort']);
    }

    public function loadLanguages()
    {
        load_plugin_textdomain(
            MgTestSettings::LANGUAGE_DOMAIN,
            false,
            dirname(dirname(dirname(plugin_basename(__FILE__)))) . '/languages'
        );
    }

}
