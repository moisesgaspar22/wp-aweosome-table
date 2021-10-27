<?php

namespace MgTest\models;

use MgTest\admin\MgTestAdmin;

/**
 * Undocumented class
 */
class TableData
{
    public const CACHE_TRANSIENT_MAME = '_mg_aweosome_table_v1';
    
    private $externalApiUrl = 'https://miusage.com/v1/challenge/1/';

    /**
     * Undocumented function
     */
    public function __construct()
    {
        if (!empty($externalApiUrl = get_option(MgTestAdmin::ADMIN_OPTIONS_API_URL))) {
            $this->externalApiUrl = $externalApiUrl;
        }
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getData($bypass = false)
    {
        $response = get_transient($this::CACHE_TRANSIENT_MAME);
        
        if ($response && $bypass === false) {
            return $response;
        }
        
        $response = wp_remote_get($this->externalApiUrl, ['sslverify' => false]);
        
        if (!empty($response) && !is_wp_error($response)) {
            // One hour and expires - this is a ttl
            //@todo Use get_option() to get settings ttl time * 60
            $jsonDto = wp_json_encode(json_decode($response['body'], false));
            set_transient($this::CACHE_TRANSIENT_MAME, $jsonDto, 3600);
            return json_decode($jsonDto);
        }

        // Fail silently - Log information and/or show info settings_error on backend 
    }
}