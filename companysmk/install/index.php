<?php

use Bitrix\Main\Config\Option;

Class companysmk extends CModule
{
    var $MODULE_ID = "companysmk";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;

    function __construct()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = '1.0.1';
            $this->MODULE_VERSION_DATE = '10.11.2023';
        }

        $this->MODULE_NAME = "Виджет – cписок компаний";
        $this->MODULE_DESCRIPTION = "После установки вы сможете пользоваться Виджетом";
    }

    function InstallFiles()
    {
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/companysmk/install/components",
            $_SERVER["DOCUMENT_ROOT"]."/local/components/mk/companysmk", true, true);
        return true;

    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx("/local/components/mk/companysmk");
        return true;
    }

    function DoInstall()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler('main', 'onEpilog', 'companysmk', 'ComponetMk', 'include', '100', '/local/modules/companysmk/include.php');

        Option::set("companysmk", "amount", "5");
        Option::set("companysmk", "height", "200");
        Option::set("companysmk", "switch_on", "Y");

        global $DOCUMENT_ROOT, $APPLICATION;
        $this->InstallFiles();
        RegisterModule("companysmk");
        $APPLICATION->IncludeAdminFile("Установка модуля companysmk", $DOCUMENT_ROOT."/local/modules/companysmk/install/step.php");
    }

    function DoUninstall()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler('main', 'onEpilog', 'companysmk', 'ComponetMk', 'include', '/local/modules/companysmk/include.php');

        COption::RemoveOption("companysmk", "amount");
        COption::RemoveOption("companysmk", "height");
        COption::RemoveOption("companysmk", "switch_on");

        global $DOCUMENT_ROOT, $APPLICATION;
        $this->UnInstallFiles();
        UnRegisterModule("companysmk");
        $APPLICATION->IncludeAdminFile("Деинсталляция модуля companysmk", $DOCUMENT_ROOT."/local/modules/companysmk/install/unstep.php");
    }
}
?>