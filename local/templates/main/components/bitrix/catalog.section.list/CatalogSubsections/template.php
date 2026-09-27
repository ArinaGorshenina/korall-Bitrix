<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?if (0 < $arResult["SECTIONS_COUNT"]):?>
<?php
$activeSectionId = isset($arParams["ACTIVE_SECTION_ID"]) ? (int)$arParams["ACTIVE_SECTION_ID"] : 0;
$isAllActive = ($activeSectionId <= 0) || ($activeSectionId == (int)$arResult["SECTION"]["ID"]);
?>
<div class="cat-tab-box">
    <!-- Ссылка "Все" - на родительский раздел -->
    <a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>" class="cat-tab <?=$isAllActive ? 'active' : ''?>">
        Все
    </a>

    <?php foreach ($arResult['SECTIONS'] as &$arSection):?>
        <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="cat-tab <?=((int)$arSection['ID'] == $activeSectionId) ? 'active' : ''?>">
            <?=$arSection['NAME']?>
        </a>
    <?php endforeach;?>
</div>
<?endif;?>