<?php

namespace MgTest\controlers;

use MgTest\models\TableData;

final class AjaxController extends MainController
{   
    public function init()
    {
        $this->enqueueScripts();
    }

    private function enqueueScripts()
    {
        add_action('wp_ajax_table_data', [$this, 'handleRequest']);
        add_action('wp_ajax_nopriv_table_data', [$this, 'handleRequest']);
        add_action('wp_ajax_table_data_html', [$this, 'handleRequestHtml']);
        add_action('wp_ajax_nopriv_table_data_html', [$this, 'handleRequestHtml']);
    }

    public function handleRequest($internal=false)
    {
        // Get data from the model
        $data = (new TableData())->getData();
       
        if (!$internal) {
             // Set headers
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            // This is already a json
            print_r($data);
            wp_die();
        }
        return $data;
    }

    public function handleRequestHtml($internal=false)
    {
        // Set headers
        if (!$internal) {
            header('HTTP/1.1 200 OK');
            header('Content-Type: text/html');
        }

        $this->view(
            'admin/partials/table',
            [
                'table_data' => json_decode($this->handleRequest(true), true)
            ]
        );
        
        if (!$internal) {
            wp_die();
        }
    }
}