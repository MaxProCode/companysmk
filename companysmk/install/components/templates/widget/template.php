<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

$this->setFrameMode(true);
$this->SetViewTarget("sidebar", 100);
$frame = $this->createFrame()->begin();
$this->addExternalCss("/local/components/mk/companysmk/templates/widget/style.css");

?>
<div class="mk-sidebar-widget-top">
    <div class="sidebar-widget-top-title">Список компаний</div>
</div>

<div class="mk-sidebar-widget-item-wrap" style="overflow: scroll; height: <?= $arResult['height'] ?>px;">
    <?php foreach ($arResult['companysmk'] as $company) : ?>
        <a class="task-item" href="/crm/company/details/<?= $company['ID'] ?>/">
            <span class="task-item-text"><?= $company['TITLE'] ?></span>
        </a>
    <?php endforeach; ?>
</div>
<br>

<?
$frame->end();
$this->EndViewTarget();
?>

