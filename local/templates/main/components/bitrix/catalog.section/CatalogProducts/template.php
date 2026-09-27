<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);

if (!empty($arResult['NAV_RESULT'])) {
	$navParams =  array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
} else {
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1) {
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'USE_PAGINATION_CONTAINER' => $showTopPager || $showBottomPager,
);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$arParams['~MESS_BTN_BUY'] = ($arParams['~MESS_BTN_BUY'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['~MESS_BTN_DETAIL'] = ($arParams['~MESS_BTN_DETAIL'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = ($arParams['~MESS_BTN_ADD_TO_BASKET'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['~MESS_NOT_AVAILABLE'] = ($arParams['~MESS_NOT_AVAILABLE'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');

$obName = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-' . $navParams['NavNum'];

if ($showTopPager) {
?>
	<div data-pagination-num="<?= $navParams['NavNum'] ?>">
		<?= $arResult['NAV_STRING'] ?>
	</div>
<?
}
?>
<script>
	// Принудительная загрузка скрипта catalog.section
	(function() {
		if (typeof window.JCCatalogSectionComponent === 'undefined') {
			var script = document.createElement('script');
			script.src = '/bitrix/components/bitrix/catalog.section/templates/.default/script.js';
			script.async = false;
			document.head.appendChild(script);
			console.log('Загружаем JCCatalogSectionComponent');
		}
	})();
</script>
<div class="cart-products-right" data-entity="<?= $containerName ?>">
	<?
	if (!empty($arResult['ITEMS'])) {
		foreach ($arResult['ITEMS'] as $item) {
			$uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
			$areaId = $this->GetEditAreaId($uniqueId);
			$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
			$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);

			// Получаем картинку
			$imgSrc = '';
			if (!empty($item['PREVIEW_PICTURE']['SRC'])) {
				$imgSrc = $item['PREVIEW_PICTURE']['SRC'];
			} elseif (!empty($item['DETAIL_PICTURE']['SRC'])) {
				$imgSrc = $item['DETAIL_PICTURE']['SRC'];
			} else {
				$imgSrc = SITE_TEMPLATE_PATH . '/assets/images/minicatalogPopul/default.png';
			}

			// Получаем цену и скидку
			$price = '';
			$oldPrice = '';
			$discountPercent = 0;

			$priceData = !empty($item['ITEM_PRICES']) ? reset($item['ITEM_PRICES']) : (!empty($item['PRICES']) ? reset($item['PRICES']) : null);

			if ($priceData) {
				$price = number_format($priceData['PRICE'], 2, '.', ' ') . ' ₽';

				if (!empty($priceData['BASE_PRICE']) && $priceData['BASE_PRICE'] > $priceData['PRICE']) {
					$oldPrice = number_format($priceData['BASE_PRICE'], 2, '.', ' ') . ' ₽';
					$discountPercent = round((1 - $priceData['PRICE'] / $priceData['BASE_PRICE']) * 100);
				} elseif (!empty($priceData['DISCOUNT_PERCENT'])) {
					$discountPercent = (int)$priceData['DISCOUNT_PERCENT'];
				}
			}

			// Получаем название
			$name = $item['NAME'];

			// Ссылка на детальную страницу
			$detailUrl = $item['DETAIL_PAGE_URL'] ?? '#';
	?>
			<div class="minicatalog-popul-item" id="<?= $areaId ?>">
				<a href="<?= $detailUrl ?>" class="popul-item-img-box">
					<?php if ($discountPercent > 0): ?>
						<span class="discount-badge">-<?= $discountPercent ?>%</span>
					<?php endif; ?>
					<img src="<?= $imgSrc ?>" alt="<?= $name ?>">
				</a>
				<div class="popul-desc-box">
					<div class="price-box">
					<p class="popul-price<?= $discountPercent > 0 ? ' price-red' : '' ?>"><?= $price ?></p>
						<?php if (!empty($oldPrice)): ?>
							<span class="price-old"><?= $oldPrice ?></span>
						<?php endif; ?>
					</div>
					<p class="popul-desc"><?= $name ?></p>
				</div>
			</div>
		<?
		}
	} else {
		?>
		<div class="empty-catalog">
			<p>В этом разделе пока нет товаров</p>
		</div>
	<?
	}
	?>

</div>

<? if ($showBottomPager) {
?>
	<div data-pagination-num="<?= $navParams['NavNum'] ?>" class="pag-catalog full-width">
		<?= $arResult['NAV_STRING'] ?>
	</div>
<?
} ?>
<?
$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
?>
<script>
	BX.message({
		BTN_MESSAGE_BASKET_REDIRECT: '<?= GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
		BASKET_URL: '<?= $arParams['BASKET_URL'] ?>',
		ADD_TO_BASKET_OK: '<?= GetMessageJS('ADD_TO_BASKET_OK') ?>',
		TITLE_ERROR: '<?= GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
		TITLE_BASKET_PROPS: '<?= GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
		TITLE_SUCCESSFUL: '<?= GetMessageJS('ADD_TO_BASKET_OK') ?>',
		BASKET_UNKNOWN_ERROR: '<?= GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		BTN_MESSAGE_SEND_PROPS: '<?= GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS') ?>',
		BTN_MESSAGE_CLOSE: '<?= GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?= GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP') ?>',
		COMPARE_MESSAGE_OK: '<?= GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK') ?>',
		COMPARE_UNKNOWN_ERROR: '<?= GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
		COMPARE_TITLE: '<?= GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE') ?>',
		PRICE_TOTAL_PREFIX: '<?= GetMessageJS('CT_BCS_CATALOG_PRICE_TOTAL_PREFIX') ?>',
		SITE_ID: '<?= CUtil::JSEscape($component->getSiteId()) ?>'
	});
	var <?= $obName ?> = new JCCatalogSectionComponent({
		siteId: '<?= CUtil::JSEscape($component->getSiteId()) ?>',
		componentPath: '<?= CUtil::JSEscape($componentPath) ?>',
		navParams: <?= CUtil::PhpToJSObject($navParams) ?>,
		deferredLoad: false,
		initiallyShowHeader: '<?= !empty($arResult['ITEMS']) ?>',
		bigData: <?= CUtil::PhpToJSObject($arResult['BIG_DATA'] ?? []) ?>,
		lazyLoad: !!'<?= $showLazyLoad ?>',
		loadOnScroll: !!'<?= ($arParams['LOAD_ON_SCROLL'] === 'Y') ?>',
		template: '<?= CUtil::JSEscape($signedTemplate) ?>',
		ajaxId: '<?= CUtil::JSEscape($arParams['AJAX_ID'] ?? '') ?>',
		parameters: '<?= CUtil::JSEscape($signedParams) ?>',
		container: '<?= $containerName ?>'
	});
</script>