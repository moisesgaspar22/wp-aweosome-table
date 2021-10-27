<?php

namespace MgTest\admin;

use MgTest\settings\MgTestSettings;
use MgTest\controlers\AdminController;
use MgTest\models\TableData;
use MgTest\traits\Sanitizers;

/**
 * Admin Class | Responsible for loading all actions on the admin side
 */
class MgTestAdmin
{
    use Sanitizers;

    private const MENU_SLUG               = 'mg-aweosome-table-settings-page';
    private const ADMIN_MENU_GROUP        = 'mg-aweosome-table-plugin';
    private const ADMIN_OPTIONS_PAGE_SLUG = 'mg-aweosome-table-options-subpage';
    /* sections */
    private const ADMIN_OPTIONS_PAGE_SECTIONS = [
        'A' => 'mg_aweosome_table_section_a',
        'B' => 'mg_aweosome_table_section_b'
    ];
    /* settings */
    public const ADMIN_OPTIONS_API_URL       = 'mg_aweosome_table_api_url';
    public const ADMIN_OPTIONS_API_CACHE_TTL = 'mg_aweosome_table_api_data_ttl';



    /**
     * Undocumented function
     *
     * @return void
     */
    public function buildAdminBackEnd()
    {
        $this->adminMenu();
        $this->adminBackEnd();
    }

    /**
     * Add admin menu option
     *
     * @return void
     */
    protected function adminMenu()
    {
        add_menu_page(
            esc_html__('Aweosome Table', MgTestSettings::LANGUAGE_DOMAIN),
            esc_html__('Aweosome Table', MgTestSettings::LANGUAGE_DOMAIN),
            'manage_options',
            $this::MENU_SLUG,
            [$this, 'buildAdminTablePageHtml'],
            //'dashicons-smiley',
            sprintf('data:image/svg+xml;base64,%s', MgTestSettings::ADMIN_MENU_ICON),
            50
        );

        add_submenu_page(
            $this::MENU_SLUG,
            esc_html__('Aweosome Table Options', MgTestSettings::LANGUAGE_DOMAIN),
            esc_html__('Show Table', MgTestSettings::LANGUAGE_DOMAIN),
            'manage_options',
            $this::MENU_SLUG,
            [$this, 'buildAdminTablePageHtml'],
        );

        add_submenu_page(
            $this::MENU_SLUG,
            esc_html__('Aweosome Table Options', MgTestSettings::LANGUAGE_DOMAIN),
            esc_html__('Options', MgTestSettings::LANGUAGE_DOMAIN),
            'manage_options',
            $this::ADMIN_OPTIONS_PAGE_SLUG,
            [$this, 'buildAdminTableOptionsPageHtml']
        );
    }

    /**
     * Load Admin actions
     * 
     * @return void
     */
    protected function adminBackEnd()
    {
        add_action('admin_init', [$this, 'buildAweosomTableSettings']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function buildAweosomTableSettings()
    {
        add_settings_section(
            $this::ADMIN_OPTIONS_PAGE_SECTIONS['A'],
            null,
            null,
            $this::ADMIN_OPTIONS_PAGE_SLUG
        );

        add_settings_field(
            $this::ADMIN_OPTIONS_API_URL,
            esc_html__(
                'External Api url',
                MgTestSettings::LANGUAGE_DOMAIN
            ),
            [$this, 'settingFieldsHtml'],
            $this::ADMIN_OPTIONS_PAGE_SLUG,
            $this::ADMIN_OPTIONS_PAGE_SECTIONS['A'],
            $this::ADMIN_OPTIONS_API_URL
        );

        add_settings_field(
            $this::ADMIN_OPTIONS_API_CACHE_TTL,
            esc_html__(
                'Get new fresh data every minutes',
                MgTestSettings::LANGUAGE_DOMAIN
            ),
            [$this, 'settingFieldsHtml'],
            $this::ADMIN_OPTIONS_PAGE_SLUG,
            $this::ADMIN_OPTIONS_PAGE_SECTIONS['A'],
            $this::ADMIN_OPTIONS_API_CACHE_TTL
        );

        register_setting(
            $this::ADMIN_MENU_GROUP,
            $this::ADMIN_OPTIONS_API_URL,
            [
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => ''
            ]
        );

        register_setting(
            $this::ADMIN_MENU_GROUP,
            $this::ADMIN_OPTIONS_API_CACHE_TTL,
            [
                'sanitize_callback' => [$this, 'sanitizeTtlSettingsField'],
                'default'           => ''
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return void
     */
    public function settingFieldsHtml($name)
    {
        AdminController::getInstance()->view(
            'admin/OptionsPageFields/InputField', [
                'settings_field_name' => $name
            ]
        );
    }

    /**
     * Build Admin Page for Aweosome Table
     *
     * @return void
     */
    public function buildAdminTablePageHtml()
    {
        AdminController::getInstance()->view(
            'admin/AdminTableShowTablePage', [
                'language_domain' => MgTestSettings::LANGUAGE_DOMAIN,
                'table_data'      => json_decode((new TableData())->getData(), true)
            ]
        );
    }

    /**
     * Build Admin Page for Aweosome Table
     *
     * @return void
     */
    public function buildAdminTableOptionsPageHtml()
    {
        AdminController::getInstance()->view(
            'admin/AdminTableOptionsPage', [
                'language_domain'         => MgTestSettings::LANGUAGE_DOMAIN,
                'admin_options_page_slug' => $this::ADMIN_OPTIONS_PAGE_SLUG,
                'settings_group_name'     => $this::ADMIN_MENU_GROUP
            ]
        );
    }
}
