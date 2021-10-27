<?php

namespace MgTest\controlers;

/**
 * Undocumented class
 */
class ShortcodesController extends MainController
{
    public const AWEOSOME_TABLE_SHORT_NAME = 'aweosome_table_short';

    public function aweosomeTableShort()
    {
        (new AjaxController())->handleRequestHtml(true);
    }
}