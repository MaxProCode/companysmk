<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();
$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);

$aTabs = array(
    array(
        "DIV"       => "edit",
        "TAB"       => Loc::getMessage("COMPANYS_MK_OPTIONS_TAB_NAME"),
        "TITLE"   => Loc::getMessage("COMPANYS_MK_OPTIONS_TAB_NAME"),
        "OPTIONS" => array(
            Loc::getMessage("COMPANYS_MK_OPTIONS_TAB_COMMON"),
            array(
                "switch_on",
                Loc::getMessage("COMPANYS_MK_OPTIONS_TAB_SWITCH_ON"),
                Option::get($module_id, 'switch_on'),
                array("checkbox")
            ),
            Loc::getMessage("COMPANYS_MK_OPTIONS_TAB_APPEARANCE"),
            array(
                "amount",
                Loc::getMessage("COMPANYS_MK_OPTIONS_TAB_AMOUNT_ELEMENTS"),
                Option::get($module_id, 'amount'),
                array("text", 5)
            ),
            array(
                "height",
                Loc::getMessage("COMPANYS_MK_OPTIONS_TAB_HEIGHT"),
                Option::get($module_id, 'height'),
                array("text", 5)
            ),
        )
    )
);

$tabControl = new CAdminTabControl(
    "tabControl",
    $aTabs
);

$tabControl->Begin();

/** @global \CMain $APPLICATION */
global $APPLICATION;
?>

<form action="<?= $APPLICATION->GetCurPage(); ?>?mid=<?= $module_id; ?>&lang=<?= LANG; ?>" method="post">

<?php
foreach($aTabs as $aTab){

   if($aTab["OPTIONS"]){

     $tabControl->BeginNextTab();

     __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
  }
}

$tabControl->Buttons();
?>

   <input type="submit" name="apply" value="<?php echo(Loc::GetMessage("COMPANYS_MK_OPTIONS_INPUT_APPLY")); ?>" class="adm-btn-save" />
   <input type="submit" name="default" value="<?php echo(Loc::GetMessage("COMPANYS_MK_OPTIONS_INPUT_DEFAULT")); ?>" />

<?= bitrix_sessid_post(); ?>

</form>

<?php
$tabControl->End();

if($request->isPost() && check_bitrix_sessid()){
    foreach($aTabs as $aTab){
        foreach($aTab["OPTIONS"] as $arOption){
            if(!is_array($arOption)){
                continue;
            }

            if($arOption["note"]){
                continue;
            }

            if($request["apply"]){
                $optionValue = $request->getPost($arOption[0]);

                if($arOption[0] == "switch_on"){
                    if($optionValue == ""){
                        $optionValue = "N";
                    }
                }

                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
            }elseif($request["default"]){
                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }

    LocalRedirect($APPLICATION->GetCurPage()."?mid=".$module_id."&lang=".LANG);
}