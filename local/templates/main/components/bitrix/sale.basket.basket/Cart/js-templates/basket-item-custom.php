<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<script id="basket-item-template" type="text/html">
	<tr class="cart-item-row" id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
		{{#SHOW_RESTORE}}
			<td colspan="1">
				<div class="cart-item cart-item-removed" id="basket-item-height-aligner-{{ID}}">
					<div>
						Товар <strong>{{NAME}}</strong> удалён.
						<a href="javascript:void(0)" data-entity="basket-item-restore-button" style="color: #04A9A5;">Восстановить</a>
					</div>

					<button type="button" class="cart-item-delete" data-entity="basket-item-close-restore-button" aria-label="Удалить товар">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cart/del.svg" alt="">
					</button>
				</div>
			</td>
		{{/SHOW_RESTORE}}
		{{^SHOW_RESTORE}}
			<td colspan="1">
				<div class="cart-item" id="basket-item-height-aligner-{{ID}}">
					<div class="cart-item-img-box">
						{{#SHOW_DISCOUNT_PRICE}}
							<span class="discount-badge">{{{DISCOUNT_PRICE_PERCENT_FORMATED}}}</span>
						{{/SHOW_DISCOUNT_PRICE}}
						{{#DETAIL_PAGE_URL}}<a href="{{DETAIL_PAGE_URL}}">{{/DETAIL_PAGE_URL}}
						<img alt="{{NAME}}" src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?= $templateFolder ?>/images/no_photo.png{{/IMAGE_URL}}">
						{{#DETAIL_PAGE_URL}}</a>{{/DETAIL_PAGE_URL}}
					</div>
					<div class="cart-item-content">
						<div class="cart-item-up">
							<div class="cart-item-up-up">
								<p class="cart-item-title">
									{{#DETAIL_PAGE_URL}}<a href="{{DETAIL_PAGE_URL}}">{{/DETAIL_PAGE_URL}}
									<span data-entity="basket-item-name">{{NAME}}</span>
									{{#DETAIL_PAGE_URL}}</a>{{/DETAIL_PAGE_URL}}
								</p>
								<button type="button" class="cart-item-delete" data-entity="basket-item-delete" aria-label="Удалить товар">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cart/del.svg" alt="">
								</button>
							</div>
							{{#SHOW_DISCOUNT_PRICE}}
								<p class="cart-item-up-down-info">Скидка: {{{DISCOUNT_PRICE_PERCENT_FORMATED}}}</p>
							{{/SHOW_DISCOUNT_PRICE}}
							{{#NOTES}}
								<p class="cart-item-up-down-info">Тип цены: {{NOTES}}</p>
							{{/NOTES}}
							{{#NOT_AVAILABLE}}
								<p class="cart-item-up-down-info">Товар недоступен</p>
							{{/NOT_AVAILABLE}}
						</div>
						<div class="cart-item-down">
							<div class="price-box">
								<p class="cart-item-price{{#SHOW_DISCOUNT_PRICE}} price-red{{/SHOW_DISCOUNT_PRICE}}" id="basket-item-sum-price-{{ID}}">{{{SUM_PRICE_FORMATED}}}</p>
								{{#SHOW_DISCOUNT_PRICE}}
									<span class="price-old" id="basket-item-sum-price-old-{{ID}}">{{{SUM_FULL_PRICE_FORMATED}}}</span>
								{{/SHOW_DISCOUNT_PRICE}}
							</div>
							<div class="cart-item-btns{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}" data-entity="basket-item-quantity-block">
								<button type="button" data-entity="basket-item-quantity-minus" aria-label="Уменьшить количество">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cart/minus.svg" alt="">
								</button>
								<input type="text" class="cart-item-kol" value="{{QUANTITY}}" data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field" id="basket-item-quantity-{{ID}}" {{#NOT_AVAILABLE}}disabled="disabled" {{/NOT_AVAILABLE}}>
								<button type="button" data-entity="basket-item-quantity-plus" aria-label="Увеличить количество">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cart/add.svg" alt="">
								</button>
							</div>
						</div>
						{{#SHOW_LOADING}}
							<div class="basket-items-list-item-overlay"></div>
						{{/SHOW_LOADING}}
					</div>
				</div>
			</td>
		{{/SHOW_RESTORE}}
	</tr>
</script>