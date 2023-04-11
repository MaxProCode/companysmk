<?php

use Bitrix\Main\Config\Option;

class ComponetMk
{
    public function include()
    {
        $page = self::getCurentPage();
        if ($page == '/stream/') {
            self::checkStatusModule();

            if (CModule::IncludeModule('companysmk')) {
                /** @global \CMain $APPLICATION */
                global $APPLICATION;
                $APPLICATION->IncludeComponent(
                    "mk:companysmk",
                    "widget",
                    [],
                    false
                );
            }
        }
    }

    private static function getCurentPage()
    {
        /** @global \CMain $APPLICATION */
        global $APPLICATION;
        return $APPLICATION->GetCurPage();
    }

    private static function checkStatusModule()
    {
        $status =  Option::get('companysmk', 'switch_on');
        if ($status == 'N') {
            return exit;
        }
    }
}


