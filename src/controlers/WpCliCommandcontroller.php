<?php

namespace MgTest\controlers;

use WP_CLI;
use MgTest\models\TableData;


class WpCliCommandController
{
    public function wdsCliRegisterCommands() 
    {
        WP_CLI::add_command('reset-aws-table', [$this, 'overwiteTtlFromAweosomeTable']);
    }

    public function overwiteTtlFromAweosomeTable($bypass = false)
    {
        $result = (new TableData())->getData(true);
        if (!empty($result)) {
            WP_CLI::success('Data refresehd from API');
            return;
        }

        WP_CLI::error('Something went wrong, please refer to the logs for more info');
    }
}