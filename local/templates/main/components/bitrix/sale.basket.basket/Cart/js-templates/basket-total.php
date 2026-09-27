<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="product-right-cart-box basket-checkout-container" data-entity="basket-checkout-aligner">
		<div class="product-right-cart-up">
			<p class="basket-total"><?= Loc::getMessage('SBB_TOTAL_MSGVER_1') ?></p>
			<p class="product-right-basket-price" data-entity="basket-total-price">{{{PRICE_FORMATED}}}</p>
			{{#SHOW_VAT}}<p class="product-right-basket-nds"><?= Loc::getMessage('SBB_VAT_MSGVER_1', ['#VAT_SUM_FORMATED#' => '{{{VAT_SUM_FORMATED}}}']) ?></p>{{/SHOW_VAT}}
		</div>
		<?
		if ($arParams['HIDE_COUPON'] !== 'Y')
		{
			?>
			<div class="product-right-basket-cart-input">
				<input type="text" placeholder="<?= Loc::getMessage('SBB_COUPON_ENTER_MSGVER_1') ?>" data-entity="basket-coupon-input">
				<button type="button" class="product-right-basket-cart-button" data-entity="basket-coupon-apply">Применить</button>
			</div>
			<?
		}
		?>
		<button class="product-right-basket-btn header-btn{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}" data-entity="basket-checkout-button">
			<?=Loc::getMessage('SBB_ORDER')?>
		</button>

		<?
		if ($arParams['HIDE_COUPON'] !== 'Y')
		{
		?>
			<div class="basket-coupon-alert-section">
				<div class="basket-coupon-alert-inner">
					{{#COUPON_LIST}}
					<div class="basket-coupon-alert text-{{CLASS}}">
						<span class="basket-coupon-text">
							<strong>{{COUPON}}</strong> - <?=Loc::getMessage('SBB_COUPON')?> {{JS_CHECK_CODE}}
							{{#DISCOUNT_NAME}}({{DISCOUNT_NAME}}){{/DISCOUNT_NAME}}
						</span>
						<span class="close-link" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}">
							<?=Loc::getMessage('SBB_DELETE')?>
						</span>
					</div>
					{{/COUPON_LIST}}
				</div>
			</div>
			<?
		}
		?>
	</div>
</script>
