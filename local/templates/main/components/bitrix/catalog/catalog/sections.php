<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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


$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"TopNavigate",
	array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0"
	)
);
?>
<div class="minicatalog">
	<div class="container">
		<h2 class="Unbounded">Каталог товаров</h2><?
													$APPLICATION->IncludeComponent(
														"bitrix:catalog.section.list",
														"CatalogRazdeli",
														[
															"ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
															"ADD_SECTIONS_CHAIN" => "Y",
															"CACHE_FILTER" => "N",
															"CACHE_GROUPS" => "Y",
															"CACHE_TIME" => "36000000",
															"CACHE_TYPE" => "A",
															"COUNT_ELEMENTS" => "Y",
															"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
															"FILTER_NAME" => "sectionsFilter",
															"HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
															"IBLOCK_ID" => "3",
															"IBLOCK_TYPE" => "korall_shop",
															"SECTION_CODE" => "",
															"SECTION_FIELDS" => [
																0 => "NAME",
																1 => "PICTURE",
																2 => "",
															],
															"SECTION_ID" => $_REQUEST["SECTION_ID"],
															"SECTION_URL" => "/catalog/#SECTION_CODE#/",
															"SECTION_USER_FIELDS" => [
																0 => "",
																1 => "",
															],
														
															"SHOW_PARENT_NAME" => "Y",
															"TOP_DEPTH" => "2",
															"VIEW_MODE" => "LINE"
														],
														false
													); ?>
	</div>
</div>



<!-- $APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"CatalogRazdeli", 
	[
		"ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COUNT_ELEMENTS" => "Y",
		"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
		"FILTER_NAME" => "sectionsFilter",
		"HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "korall_shop",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => [
			0 => "",
			1 => "",
		],
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => [
			0 => "",
			1 => "",
		],
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "2",
		"VIEW_MODE" => "LINE"
	],
	false
);  -->