<?php

use Bitrix\Main\Web\Json;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();


if (isset($arResult["SHOW_SMS_FIELD"]) && $arResult["SHOW_SMS_FIELD"] == true) {
	CJSCore::Init('phone_auth');
}
?>

<div class="account">
	<div class="container">
	


		<?php if (isset($arResult["SHOW_SMS_FIELD"]) && $arResult["SHOW_SMS_FIELD"] == true): ?>
			<!-- Форма подтверждения SMS -->
			<form method="post" action="<?= $arResult["FORM_TARGET"] ?>">
				<?= $arResult["BX_SESSION_CHECK"] ?>
				<input type="hidden" name="lang" value="<?= LANG ?>" />
				<input type="hidden" name="ID" value=<?= $arResult["ID"] ?> />
				<input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>" />

				<div class="form-gap">
					<label><?= GetMessage("main_profile_code") ?></label>
					<input type="text" name="SMS_CODE" value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" placeholder="Код подтверждения" autocomplete="off" />
				</div>

				<button type="submit" name="code_submit_button" class="btn btn-primary"><?= GetMessage("main_profile_send") ?></button>
			</form>

			<script>
				new BX.PhoneAuth({
					containerId: 'bx_profile_resend',
					errorContainerId: 'bx_profile_error',
					interval: <?= $arResult["PHONE_CODE_RESEND_INTERVAL"] ?>,
					data: <?= Json::encode(['signedData' => $arResult["SIGNED_DATA"]]) ?>,
					onError: function(response) {
						var errorDiv = BX('bx_profile_error');
						var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
						errorNode.innerHTML = '';
						for (var i = 0; i < response.errors.length; i++) {
							errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
						}
						errorDiv.style.display = '';
					}
				});
			</script>
			<div id="bx_profile_error" style="display:none"><?php ShowError("error") ?></div>
			<div id="bx_profile_resend"></div>

		<?php else: ?>
	<!-- Ошибки профиля -->
		<?php ShowError($arResult["strProfileError"]); ?>

			<!-- Вкладки -->
			<div class="account-tabs">
				<h1 class="account-tab active Unbounded">Личные данные</h1>
				<h1 class="account-tab Unbounded">Мои заказы</h1>
			</div>



			<!-- Содержимое профиля -->
			<div class="account-content account-content-form active " id="user_div_reg">
				<form method="post" name="form1" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
					<?= $arResult["BX_SESSION_CHECK"] ?>
					<input type="hidden" name="lang" value="<?= LANG ?>" />
					<input type="hidden" name="ID" value=<?= $arResult["ID"] ?> />

					<!-- Имя -->
					<div class="form-gap">
						<label>Имя</label>
						<input type="text" name="NAME" maxlength="50" value="<?= $arResult["arUser"]["NAME"] ?>" placeholder="Ваше имя" />
						<div class="error-text"></div>
					</div>

					<!-- Фамилия -->
					<div class="form-gap">
						<label>Фамилия</label>
						<input type="text" name="LAST_NAME" maxlength="50" value="<?= $arResult["arUser"]["LAST_NAME"] ?>" placeholder="Ваша фамилия" />
						<div class="error-text"></div>
					</div>

					<!-- Отчество -->
					<div class="form-gap">
						<label>Отчество</label>
						<input type="text" name="SECOND_NAME" maxlength="50" value="<?= $arResult["arUser"]["SECOND_NAME"] ?>" placeholder="Ваше отчество" />
						<div class="error-text"></div>
					</div>

					<!-- Email -->
					<div class="form-gap">
						<label>Электронная почта</label>
						<input type="email" name="EMAIL" maxlength="50" value="<?= $arResult["arUser"]["EMAIL"] ?>" placeholder="Ваша эл. почта" />
						<div class="error-text"></div>
					</div>

					<!-- Логин (скрыт, но нужен для работы) -->
					<input type="hidden" name="LOGIN" value="<?= $arResult["arUser"]["LOGIN"] ?>" />

					<!-- Телефон (если включена регистрация по телефону) -->
					<?php if ($arResult["PHONE_REGISTRATION"]): ?>
						<div class="form-gap">
							<label><?= GetMessage("main_profile_phone_number") ?></label>
							<input type="text" name="PHONE_NUMBER" maxlength="50" value="<?= $arResult["arUser"]["PHONE_NUMBER"] ?>" placeholder="+7 (999) 999-99-99" />
						</div>
					<?php endif ?>

					<!-- Новый пароль -->
					<?php if ($arResult['CAN_EDIT_PASSWORD']): ?>
						<div class="form-gap">
							<label>Новый пароль</label>
							<div class="password-wrapper">
								<input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" class="password-input password-main" placeholder="••••••••" />
								<button type="button" class="toggle-password" aria-label="Показать пароль">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/form/eye.svg" alt="eye" class="eye-icon">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/form/eye2.svg" alt="eye" class="eye-off-icon hidden">
								</button>
							</div>
							<div class="error-text"></div>
							<?php if ($arResult["SECURE_AUTH"]): ?>
								<span class="bx-auth-secure" id="bx_auth_secure" title="<?= GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
									<div class="bx-auth-secure-icon"></div>
								</span>
								<noscript>
									<span class="bx-auth-secure" title="<?= GetMessage("AUTH_NONSECURE_NOTE") ?>">
										<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
									</span>
								</noscript>
								<script>
									document.getElementById('bx_auth_secure').style.display = 'inline-block';
								</script>
							<?php endif ?>
						</div>

						<!-- Подтверждение пароля -->
						<div class="form-gap">
							<label>Подтверждение нового пароля:</label>
							<div class="password-wrapper">
								<input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" class="password-input password-confirm" placeholder="••••••••" />
								<button type="button" class="toggle-password" aria-label="Показать пароль">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/form/eye.svg" alt="eye" class="eye-icon">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/form/eye2.svg" alt="eye" class="eye-off-icon hidden">
								</button>
							</div>
							<div class="error-text"></div>
						</div>
					<?php endif ?>
					<input type="hidden" name="save" value="Сохранить" />
				</form>
				<script>
					(function() {
						var form = document.forms['form1'];
						if (!form) return;

						// Создаём блок уведомления сверху формы (один раз)
						var notice = document.createElement('div');
						notice.className = 'form-save-notice';
						notice.style.cssText = 'display:none; padding:10px 15px; margin-bottom:15px; border-radius:4px; font-size:14px;';
						form.parentNode.insertBefore(notice, form);

						function showNotice(text, isError) {
							notice.textContent = text;
							notice.style.background = isError ? '#f8d7da' : '#d7f8e3';
							notice.style.color = isError ? '#721c24' : 'green';
							notice.style.border = isError ? '1px solid #f5c6cb' : '1px solid #c6f7d8';
							notice.style.display = 'block';

							clearTimeout(notice._hideTimeout);
							notice._hideTimeout = setTimeout(function() {
								notice.style.display = 'none';
							}, 3000);
						}

						function saveForm() {
							var formData = new FormData(form);

							fetch(form.action, {
									method: 'POST',
									body: formData
								})
								.then(function(response) {
									if (!response.ok) throw new Error('Ошибка сохранения');
									return response.text();
								})
								.then(function() {
									showNotice('Данные успешно сохранены');
								})
								.catch(function() {
									showNotice('Ошибка при сохранении данных', true);
								});
						}

						// Перехват Enter на всех текстовых полях формы
						var inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
						inputs.forEach(function(input) {
							input.addEventListener('keydown', function(e) {
								if (e.key === 'Enter') {
									e.preventDefault();
									saveForm();
								}
							});
						});
					})();
				</script>
			</div>

			<!-- Вкладка "Мои заказы" (пустая, вы можете заполнить позже) -->
			<div class="account-content" id="user_div_orders">
			<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list",
	"OrderList",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DEFAULT_SORT" => "STATUS",
		"DISALLOW_CANCEL" => "N",
		"HISTORIC_STATUSES" => array("F"),
		"ID" => $ID,
		"NAV_TEMPLATE" => "",
		"ORDERS_PER_PAGE" => "20",
		"PATH_TO_BASKET" => "/personal/cart/index.php",
		"PATH_TO_CANCEL" => "",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_COPY" => "",
		"PATH_TO_DETAIL" => "",
		"PATH_TO_PAYMENT" => "payment.php",
		"REFRESH_PRICES" => "Y",
		"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
		"SAVE_IN_SESSION" => "Y",
		"SET_TITLE" => "Y",
		"STATUS_COLOR_F" => "green",
		"STATUS_COLOR_N" => "yellow",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red"
	)
);?>
			</div>

		<?php endif; ?>
	</div>
</div>
	