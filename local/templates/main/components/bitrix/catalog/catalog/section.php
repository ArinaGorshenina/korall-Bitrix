<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);
// Получаем название раздела
$sectionName = '';
$sectionId = intval($arResult["VARIABLES"]["SECTION_ID"]);
$sectionCode = $arResult["VARIABLES"]["SECTION_CODE"];

if ($sectionId > 0 || !empty($sectionCode)) {
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	if ($sectionId > 0) {
		$arFilter["ID"] = $sectionId;
	} elseif (!empty($sectionCode)) {
		$arFilter["=CODE"] = $sectionCode;
	}

	$dbSection = CIBlockSection::GetList(array(), $arFilter, false, array("ID", "NAME", "IBLOCK_SECTION_ID", "DEPTH_LEVEL"));
	if ($arSection = $dbSection->Fetch()) {
		$sectionId = (int)$arSection["ID"];
		$sectionName = $arSection["NAME"];
	}
	$APPLICATION->AddChainItem($arSection["NAME"]);

	// Если текущий раздел сам является подкатегорией (есть родитель),
	// строку вкладок строим по родителю, чтобы видеть "соседние" подкатегории
	$tabsSectionId = $sectionId;
	if (!empty($arSection["IBLOCK_SECTION_ID"])) {
		$tabsSectionId = (int)$arSection["IBLOCK_SECTION_ID"];
	}
}

$sectionHasProducts = false;
if ($sectionId > 0) {
	$products = CIBlockElement::GetList(
		array(),
		array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $sectionId,
			"INCLUDE_SUBSECTIONS" => "Y",
			"ACTIVE" => "Y",
			"ACTIVE_DATE" => "Y",
		),
		false,
		array("nTopCount" => 1),
		array("ID")
	);
	$sectionHasProducts = (bool)$products->Fetch();
}


?>

<?php
// Хлебные крошки
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
<div class="cart-products">
	<div class="container">
		<h2 class="Unbounded"><?= $sectionName ?></h2>


		<!-- Категории - подразделы текущего раздела -->
		<?php
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"CatalogSubsections",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $tabsSectionId,
				"SECTION_CODE" => "",
				"ACTIVE_SECTION_ID" => $sectionId, // <-- добавили: реально открытый раздел
				"SECTION_URL" => "/catalog/#SECTION_CODE#/",
				"COUNT_ELEMENTS" => "N",
				"TOP_DEPTH" => "2",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => 36000000,
				"CACHE_GROUPS" => "Y",
				"SHOW_PARENT_NAME" => "N",
				"HIDE_SECTION_NAME" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
			),
			$component,
			array('HIDE_ICONS' => 'Y')
		);

		?>

		<div class="cart-products-content-box">
			<!-- Мобильные кнопки фильтров -->
			<div class="filter-buttons-mobile">
				<button class="filter-btn" id="openCatFilter">
					<span>Категории</span>
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none">
						<path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
					</svg>
				</button>
				<?php if ($sectionHasProducts): ?>
					<button class="filter-btn" id="openOptionsFilter">
						<span>Характеристики</span>
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none">
							<path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
						</svg>
					</button>
				<?php endif; ?>
			</div>

			<!-- Затемняющий фон -->
			<div class="filter-overlay" id="filterOverlay"></div>

			<!-- СТВОРКА 1: Категории (слева) -->
			<div class="filter-drawer filter-drawer-left" id="catFilterDrawer">
				<div class="filter-drawer-header">
					<h3>Категории</h3>
					<button class="filter-drawer-close" id="closeCatFilter">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none">
							<path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
						</svg>
					</button>
				</div>
				<div class="filter-drawer-content">
					<!-- Категории - подразделы текущего раздела -->
					<div class="cat-tab-box">
						<?php
						$APPLICATION->IncludeComponent(
							"bitrix:catalog.section.list",
							"CatalogSubsections",
							array(
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"SECTION_ID" => $tabsSectionId,
								"SECTION_CODE" => "",
								"ACTIVE_SECTION_ID" => $sectionId, // <-- добавили: реально открытый раздел
								"SECTION_URL" => "/catalog/#SECTION_CODE#/",
								"COUNT_ELEMENTS" => "N",
								"TOP_DEPTH" => "2",
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => 36000000,
								"CACHE_GROUPS" => "Y",
								"SHOW_PARENT_NAME" => "N",
								"HIDE_SECTION_NAME" => "N",
								"ADD_SECTIONS_CHAIN" => "N",
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);

						?>

					</div>
				</div>
			</div>

			<!-- СТВОРКА 2: Характеристики (справа) - статичная верстка -->
			<div class="filter-drawer filter-drawer-right" id="optionsFilterDrawer">
				<div class="filter-drawer-header">
					<h3>Характеристики</h3>
					<button class="filter-drawer-close" id="closeOptionsFilter">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none">
							<path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
						</svg>
					</button>
				</div>
				<div class="filter-drawer-content">
					<!-- Единственный инстанс фильтра. JS будет переносить его сюда/в десктоп-колонку -->
					<div id="smartFilterInstance">
						<?php
						$APPLICATION->IncludeComponent(
							"bitrix:catalog.smart.filter",
							"FilterDesktop",
							array(
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
								"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
								"FILTER_NAME" => "arrFilter",
								"PRICE_CODE" => $arParams["PRICE_CODE"],
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => 36000000,
								"CACHE_GROUPS" => "Y",
								"SAVE_IN_SESSION" => "N",
								"FILTER_VIEW_MODE" => "VERTICAL",
								"XML_EXPORT" => "N",
								"SECTION_TITLE" => "NAME",
								"SECTION_DESCRIPTION" => "DESCRIPTION",
								"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
								"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
								"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
								"CURRENCY_ID" => $arParams["CURRENCY_ID"],
								"SEF_MODE" => "Y",
								"SEF_RULE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["smart_filter"],
								"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
								"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
								"INSTANT_RELOAD" => "Y",
								"AJAX_MODE" => "Y",
								"DISABLE_INIT_JS_IN_COMPONENT" => "N",
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
				</div>
			</div>

			<div class="cart-products-content<?= !$sectionHasProducts ? ' cart-products-content--empty' : '' ?>">
				<!-- Левая колонка - десктопный фильтр -->
				<?php if ($sectionHasProducts): ?>
					<div class="cart-products-left desktop-only" id="smartFilterDesktopTarget">
<?php
						$APPLICATION->IncludeComponent(
							"bitrix:catalog.smart.filter",
							"FilterDesktop",
							array(
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
								"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
								"FILTER_NAME" => "arrFilter",
								"PRICE_CODE" => $arParams["PRICE_CODE"],
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => 36000000,
								"CACHE_GROUPS" => "Y",
								"SAVE_IN_SESSION" => "N",
								"FILTER_VIEW_MODE" => "VERTICAL",
								"XML_EXPORT" => "N",
								"SECTION_TITLE" => "NAME",
								"SECTION_DESCRIPTION" => "DESCRIPTION",
								"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
								"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
								"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
								"CURRENCY_ID" => $arParams["CURRENCY_ID"],
								"SEF_MODE" => "Y",
								"SEF_RULE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["smart_filter"],
								"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
								"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
								"INSTANT_RELOAD" => "Y",
								"AJAX_MODE" => "Y",
								"DISABLE_INIT_JS_IN_COMPONENT" => "N",
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
				<?php endif; ?>
				<?php
				// Вывод товаров через компонент catalog.section
				$APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					"CatalogProducts",
					array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
						"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
						"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
						"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
						"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
						"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
						"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
						"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
						"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
						"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						"FILTER_NAME" => $arParams["FILTER_NAME"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_FILTER" => $arParams["CACHE_FILTER"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"SET_TITLE" => "N",
						"MESSAGE_404" => $arParams["MESSAGE_404"],
						"SET_STATUS_404" => $arParams["SET_STATUS_404"],
						"SHOW_404" => $arParams["SHOW_404"],
						"FILE_404" => $arParams["FILE_404"],
						"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
						"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
						"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
						"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
						"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
						"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
						"PAGER_TITLE" => $arParams["PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
						"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
						"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
						"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
						"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
						"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
						"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
						"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
						"LAZY_LOAD" => $arParams["LAZY_LOAD"],
						"MESS_BTN_LAZY_LOAD" => $arParams["MESS_BTN_LAZY_LOAD"],
						"LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],
						"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
						"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
						"USE_ENHANCED_ECOMMERCE" => $arParams["USE_ENHANCED_ECOMMERCE"],
						"DATA_LAYER_NAME" => $arParams["DATA_LAYER_NAME"],
						"BRAND_PROPERTY" => $arParams["BRAND_PROPERTY"],
						"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
						"ADD_SECTIONS_CHAIN" => "N",
						"ADD_ELEMENT_CHAIN" => "N",
						"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
						"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
						"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
						"SECTION_ID" => $sectionId,
						"SECTION_CODE" => $sectionCode,
						"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
						"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
						"HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
						"PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
						"USE_PRODUCT_QUANTITY" => "N",
						"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
						"SEF_RULE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["smart_filter"],

					),
					$component
				);
				?>

			</div>
	
		</div>
	</div>
</div>

<script>
	//каталог продуктов

	// ==== Открытие/закрытие мобильных створок фильтра ====
	// Делегирование на document — переживает AJAX-подмену разметки каталога
	(function() {
		function getEls() {
			return {
				overlay: document.getElementById('filterOverlay'),
				catDrawer: document.getElementById('catFilterDrawer'),
				optionsDrawer: document.getElementById('optionsFilterDrawer'),
			};
		}

		function openDrawer(drawer) {
			const {
				overlay,
				catDrawer,
				optionsDrawer
			} = getEls();
			if (!drawer || !overlay) return;
			[catDrawer, optionsDrawer].forEach(function(d) {
				if (d && d !== drawer) d.classList.remove('active');
			});
			drawer.classList.add('active');
			overlay.classList.add('active');
			document.body.style.overflow = 'hidden';
		}

		function closeAllDrawers() {
			const {
				overlay,
				catDrawer,
				optionsDrawer
			} = getEls();
			catDrawer && catDrawer.classList.remove('active');
			optionsDrawer && optionsDrawer.classList.remove('active');
			overlay && overlay.classList.remove('active');
			document.body.style.overflow = '';
		}

		document.addEventListener('click', function(e) {
			const {
				overlay,
				catDrawer,
				optionsDrawer
			} = getEls();

			if (e.target.closest('#openCatFilter')) return openDrawer(catDrawer);
			if (e.target.closest('#openOptionsFilter')) return openDrawer(optionsDrawer);
			if (e.target.closest('#closeCatFilter') || e.target.closest('#closeOptionsFilter')) return closeAllDrawers();
			if (overlay && e.target === overlay) return closeAllDrawers();
		});

		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape') closeAllDrawers();
		});

		window.addEventListener('resize', function() {
			if (window.innerWidth > 1034) closeAllDrawers();
		});
	})();


	// ==== Коллапс "показать все / скрыть" в характеристиках фильтра ====
	function initCollapseToggles() {
		const collapseContainers = document.querySelectorAll('.collapse-container');

		collapseContainers.forEach(container => {
			if (container.dataset.collapseInitialized === 'Y') return;

			const content = container.querySelector('.collapse-content');
			const toggleBtn = container.querySelector('.input-radio-a');

			if (!content || !toggleBtn) return;

			container.dataset.collapseInitialized = 'Y';

			const allOptions = content.querySelectorAll('.input-radio-box');

			if (allOptions.length <= 5) {
				toggleBtn.classList.add('hidden');
				return;
			}

			allOptions.forEach((option, index) => {
				if (index >= 5) {
					option.classList.add('hidden-option');
				}
			});

			toggleBtn.addEventListener('click', function(e) {
				e.preventDefault();

				const isExpanded = container.classList.contains('expanded');
				const hiddenOptions = content.querySelectorAll('.hidden-option');

				if (isExpanded) {
					container.classList.remove('expanded');
					toggleBtn.textContent = 'показать все';
					toggleBtn.setAttribute('data-expanded', 'false');
					hiddenOptions.forEach(opt => {
						opt.style.display = 'none';
					});
				} else {
					container.classList.add('expanded');
					toggleBtn.textContent = 'скрыть';
					toggleBtn.setAttribute('data-expanded', 'true');
					hiddenOptions.forEach(opt => {
						opt.style.display = 'block';
					});
				}
			});
		});
	}
</script>