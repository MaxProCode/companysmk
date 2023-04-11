<?php

use Bitrix\Main\Config\Option;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$result = \Bitrix\Crm\CompanyTable::getList(array(
    'select'  => ['ID', 'TITLE'],
    'limit'   => Option::get('companysmk', 'amount')
));

$arResult['companysmk'] = $result->fetchAll();
$arResult['height'] = Option::get('companysmk', 'height');

$this->IncludeComponentTemplate();
?>