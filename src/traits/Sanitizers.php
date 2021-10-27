<?php

namespace MgTest\traits;

use MgTest\admin\MgTestAdmin;
use MgTest\settings\MgTestSettings;

/**
 * Undocumented trait
 */
trait Sanitizers
{
    /**
     * Undocumented function
     *
     * @param [type] $input
     * @return void
     */
    public function sanitizeTtlSettingsField($input)
    {
        if (!is_numeric($input)) {
            add_settings_error(
                MgTestAdmin::ADMIN_OPTIONS_API_CACHE_TTL,
                'data_ttl_error',
                esc_html__(
                    'Please use only numbers for the data ttl option',
                    MgTestSettings::LANGUAGE_DOMAIN
                )
            );
            return get_option(MgTestAdmin::ADMIN_OPTIONS_API_CACHE_TTL);
        }
        
        return $input;
    }
}