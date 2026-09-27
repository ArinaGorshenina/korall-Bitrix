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
<?php if (!empty($arResult['ID'])): ?>
	<div class="news-detail">
		<div class="container">
			<div class="news-detail-content-box">
				<? $APPLICATION->IncludeComponent(
					"bitrix:breadcrumb",
					"TopNavigate_NewsDetail",
					array(
						"PATH" => "",
						"SITE_ID" => "s1",
						"START_FROM" => "0"
					)
				); ?>

				<div class="news-detail-content">
					<div class="news-detail-img-box">
						<img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?? ''; ?>" alt="news">
					</div>
					<h1 class="Unbounded"><?= isset($arResult['NAME']) ? $arResult['NAME'] : ''; ?></h1>
					<div class="news-detail-desc-box">
					<?= isset($arResult['DETAIL_TEXT']) ? $arResult['DETAIL_TEXT'] : ''; ?>
					</div>
					<div class="news-detail-v-cat">
						<p class="news-detail-v-cat-desc Unbounded">Подберите декоративный карнизы для себя в нашем каталоге</p>
						<a href="/katalog-kategoriy/index.php" class="news-detail-v-cat-link">
							<p>В каталог</p>
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/news/arrow-right.svg" alt="arrow-right">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="minicatalog-popul">
		<div class="container">
			<h2 class="Unbounded">Другие новости </h2>
		<? $APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"NewsElementsList",
				array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "N",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "N",
					"CHECK_DATES" => "Y",
				"DETAIL_URL" => "/news/#ELEMENT_CODE#/",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"DISPLAY_DATE" => "N",
					"DISPLAY_NAME" => "N",
					"DISPLAY_PICTURE" => "N",
					"DISPLAY_PREVIEW_TEXT" => "N",
					"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DATE_CREATE", ""),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "1",
					"IBLOCK_TYPE" => "content",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"INCLUDE_SUBSECTIONS" => "N",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "4",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => "",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array("", ""),
					"SET_BROWSER_TITLE" => "N",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_STATUS_404" => "Y",
					"SET_TITLE" => "N",
					"SHOW_404" => "N",
					"SORT_BY1" => "SORT",
					"SORT_BY2" => "",
					"SORT_ORDER1" => "ASC",
					"SORT_ORDER2" => "",
					"STRICT_SECTION_CHECK" => "N"
				)
			); ?>
		</div>
	</div>
<?php endif; ?>