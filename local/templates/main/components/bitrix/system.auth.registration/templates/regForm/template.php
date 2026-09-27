<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2024 Bitrix
 */

use Bitrix\Main\Web\Json;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Очищаем старые данные сессии при начале регистрации
if (!empty($_POST["USER_LOGIN"])) {
	unset($_SESSION['CONFIRM_DATA']);
	unset($_SESSION['REG_EMAIL']);
	unset($_SESSION['REG_USER_ID']);
	$_SESSION["REG_EMAIL"] = $_POST["USER_LOGIN"];
}

if (!empty($arParams["~AUTH_RESULT"])) {
	ShowMessage($arParams["~AUTH_RESULT"]);
}

if ($arResult["SHOW_SMS_FIELD"] == true) {
	CJSCore::Init('phone_auth');
}



?>

<? if ($arResult["SHOW_SMS_FIELD"] == true): ?>

	<form method="post" action="<?= $arResult["AUTH_URL"] ?>" name="regform">
		<input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>" />
		<table class="data-table bx-registration-table">
			<tbody>
				<tr>
					<td><span class="starrequired">*</span><? echo GetMessage("main_register_sms_code") ?></td>
					<td><input size="30" type="text" name="SMS_CODE" value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" autocomplete="off" /></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td><input type="submit" name="code_submit_button" value="<? echo GetMessage("main_register_sms_send") ?>" /></td>
				</tr>
			</tfoot>
		</table>
	</form>

	<script>
		new BX.PhoneAuth({
			containerId: 'bx_register_resend',
			errorContainerId: 'bx_register_error',
			interval: <?= $arResult["PHONE_CODE_RESEND_INTERVAL"] ?>,
			data: <?= Json::encode([
						'signedData' => $arResult["SIGNED_DATA"],
					]) ?>,
			onError: function(response) {
				var errorDiv = BX('bx_register_error');
				var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
				errorNode.innerHTML = '';
				for (var i = 0; i < response.errors.length; i++) {
					errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
				}
				errorDiv.style.display = '';
			}
		});
	</script>

	<div id="bx_register_error" style="display:none"><? ShowError("error") ?></div>
	<div id="bx_register_resend"></div>

<? elseif (!$arResult["SHOW_EMAIL_SENT_CONFIRMATION"]): ?>

	<form class="user-drawer-form active" method="post" action="<?= $arResult["AUTH_URL"] ?>" name="bform" enctype="multipart/form-data">
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="REGISTRATION" />
		<input type="hidden" name="USER_PASSWORD" id="USER_PASSWORD" value="" />
		<input type="hidden" name="USER_CONFIRM_PASSWORD" id="USER_CONFIRM_PASSWORD" value="" />
		<input type="hidden" name="USER_EMAIL" id="USER_EMAIL" value="" />

		<div class="form-gap">
			<label>электронная почта</label>
			<input type="email" name="USER_LOGIN" id="USER_LOGIN" placeholder="Ваша эл. почта" maxlength="40" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" class="validate-name" value="<?= $arResult["USER_LOGIN"] ?>">
			<div class="error-text"></div>
		</div>

		<div class="form-gap">
			<label class="form-gap-checkbox">
				<input type="checkbox" name="USER_PARTNER" class="user-drawer-checkbox">
				<span class="custom-checkbox"></span>
				<span class="checkbox-text">Я партнёр</span>
			</label>
			<div class="error-text"></div>
		</div>

		<button type="submit" name="Register" class="header-btn btn-user-drawer btn-user-CODE Manrope">Завершить регистрацию</button>
		<p class="user-drawer-desc user-drawer-desc-reg">Нажимая кнопку «Зарегистрироваться», я подтверждаю, что ознакомился с Политикой конфиденциальности.</p>
	</form>

	<script>
		//емейл становится логином
		function updateEmailFromLogin() {
			var loginField = document.getElementById('USER_LOGIN');
			var emailField = document.getElementById('USER_EMAIL');
			if (loginField && emailField) emailField.value = loginField.value;
		}

		document.addEventListener('DOMContentLoaded', function() {
			updateEmailFromLogin();

			var loginField = document.getElementById('USER_LOGIN');
			if (loginField) {
				loginField.addEventListener('input', updateEmailFromLogin);
				loginField.addEventListener('blur', updateEmailFromLogin);
			}
		});
	</script>

<? endif ?>