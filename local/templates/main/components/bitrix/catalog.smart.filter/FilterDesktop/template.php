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

use Bitrix\Iblock\SectionPropertyTable;

$this->setFrameMode(true);
?>

<form class="cart-products-form" name="<?= $arResult["FILTER_NAME"] . "_form" ?>" action="<?= $arResult["FORM_ACTION"] ?>" method="get">

	<? foreach ($arResult["HIDDEN"] as $arItem): ?>
		<input type="hidden" name="<?= $arItem["CONTROL_NAME"] ?>" id="<?= $arItem["CONTROL_ID"] ?>" value="<?= $arItem["HTML_VALUE"] ?>" />
	<? endforeach; ?>

	<?
	// ===== Цена =====
	foreach ($arResult["ITEMS"] as $key => $arItem) {
		$key = $arItem["ENCODED_ID"];

		if (!isset($arItem["PRICE"])) {
			continue;
		}

		if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) {
			continue;
		}
	?>
		<div class="cart-products-left-gap">
			<p class="cart-products-left-title"><?= $arItem["NAME"] ?></p>
			<div class="cart-products-inputs">
				<input
					type="text"
					class="min-price"
					name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
					id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
					value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
					placeholder="от <?= round($arItem["VALUES"]["MIN"]["VALUE"]) ?>"
					maxlength="10"
					onkeyup="smartFilter.keyup(this)" />
				<input
					type="text"
					class="max-price"
					name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
					id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
					value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
					placeholder="до <?= round($arItem["VALUES"]["MAX"]["VALUE"]) ?>"
					maxlength="10"
					onkeyup="smartFilter.keyup(this)" />
			</div>
		</div>
	<?
	}

	// ===== Остальные свойства =====
	foreach ($arResult["ITEMS"] as $key => $arItem) {
		$key = $arItem["ENCODED_ID"];

		if (empty($arItem["VALUES"]) || isset($arItem["PRICE"])) {
			continue;
		}

		if (
			$arItem["DISPLAY_TYPE"] === SectionPropertyTable::NUMBERS_WITH_SLIDER
			&& ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
		) {
			continue;
		}

		$valuesCount = count($arItem["VALUES"]);
		$showToggle = $valuesCount > 5;
	?>
		<div class="cart-products-left-gap collapse-container" data-property="<?= $key ?>">
			<p class="cart-products-left-title"><?= $arItem["NAME"] ?></p>
			<div class="input-radio-gap collapse-content">
				<?
				$i = 0;
				foreach ($arItem["VALUES"] as $val => $ar) {
					$i++;
					// НЕ добавляем класс hidden-option здесь! JS добавит его автоматически
					$disabledClass = $ar["DISABLED"] ? ' disabled' : '';
					
					$controlName = $ar["CONTROL_NAME_ALT"] ?? $ar["CONTROL_NAME"];
					$htmlValue = $ar["HTML_VALUE_ALT"] ?? $ar["HTML_VALUE"];
					
					// Добавляем data-атрибут для JS
					$dataHidden = ($showToggle && $i > 5) ? ' data-hidden="true"' : '';
				?>
					<div class="input-radio-box<?= $disabledClass ?>"<?= $dataHidden ?> data-index="<?= $i ?>">
						<input
							type="radio"
							name="<?= $controlName ?>"
							id="<?= $ar["CONTROL_ID"] ?>"
							value="<?= $htmlValue ?>"
							<?= $ar["CHECKED"] ? 'checked="checked"' : '' ?>
							<?= $ar["DISABLED"] ? 'disabled' : '' ?>
							onclick="smartFilter.click(this)" />
						<label for="<?= $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"] ?><?
							if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
							?> (<span data-role="count_<?= $ar["CONTROL_ID"] ?>"><?= $ar["ELEMENT_COUNT"] ?></span>)<?
							endif;
						?></label>
					</div>
				<?
				}
				?>
			</div>
			<? if ($showToggle): ?>
				<button type="button" class="input-radio-a" data-expanded="false">показать все</button>
			<? endif; ?>
		</div>
	<?
	}
	?>

	<!-- Кнопки управления фильтром -->
	<div class="cart-products-left-gap cart-products-buttons">
		<button
			type="submit"
			id="set_filter"
			name="set_filter"
			class="cart-products-btn cart-products-btn-apply" style="display: none;"><?= GetMessage("CT_BCSF_SET_FILTER") ?></button>
		<button
			type="submit"
			id="del_filter"
			name="del_filter"
			class="cart-products-btn cart-products-btn-reset" style="display: none;"><?= GetMessage("CT_BCSF_DEL_FILTER") ?></button>

		<div
			class="cart-products-modef"
			id="modef"
			<? if (!isset($arResult["ELEMENT_COUNT"])): ?>style="display:none" <? endif; ?>>
			<?= GetMessage("CT_BCSF_FILTER_COUNT", array(
				"#ELEMENT_COUNT#" => '<span id="modef_num" > ' . (int)($arResult["ELEMENT_COUNT"] ?? 0) . '</span>'
			)) ?>
			<br />
			<a href="<?= $arResult["FILTER_URL"] ?>"><?= GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
		</div>
	</div>
</form>

<script>
	BX.ready(function() {
		window.smartFilter = new JCSmartFilter(
			'<?=CUtil::JSEscape($arResult["FORM_ACTION"])?>', 
			'<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"] ?? "VERTICAL")?>', 
			<?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>
		);
		
		// Инициализируем collapse после загрузки фильтра
		if (typeof initCollapseToggles === 'function') {
			setTimeout(function() {
				initCollapseToggles();
			}, 100);
		}
	});
</script>