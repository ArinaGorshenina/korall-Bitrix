<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>


<div class="account">
    <div class="container">
        <?php if ($arResult['AUTHORIZED']): 
            ?>
           <p>Вы авторизованы</p>
        <?php else: ?>
            <div class="account-tabs">
                <h1 class="Unbounded">Восстановление пароля</h1>
            </div>

            <div class="account-content-form">

                <? if (!empty($arParams["~AUTH_RESULT"])): ?>
                    <?php $authResultClass = (isset($arParams["~AUTH_RESULT"]["TYPE"]) && $arParams["~AUTH_RESULT"]["TYPE"] === "OK") ? "auth-success-message" : ""; ?> 
                    <div class="auth-error-message <?= $authResultClass ?>">
                        <p><? ShowMessage($arParams["~AUTH_RESULT"]); ?></p>
                    </div> 
                    <? endif; ?>
                <form name="bform"
                    method="post"
                    action="<?= $arResult["AUTH_URL"] ?>">

                    <? if ($arResult["BACKURL"] <> ''): ?>
                        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
                    <? endif ?>

                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="SEND_PWD">

                    <div class="form-gap">

                        <label>электронная почта</label>

                        <input
                            type="email"
                            name="USER_LOGIN"
                            value="<?= htmlspecialcharsbx($arResult["USER_LOGIN"]) ?>"
                            placeholder="Ваша эл. почта"
                            maxlength="40"
                            required>

                        <div class="error-text"></div>

                        <input type="hidden" name="USER_EMAIL">

                    </div>
                    <div class="form-gap">

                        <?php if ($arResult['CAPTCHA_CODE']): ?>
                            <input type="hidden" name="captcha_sid" value="<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']); ?>" />
                            <div class="bx-authform-formgroup-container dbg_captha">
                                <div class="bx-authform-label-container">
                                    <?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_CAPTCHA'); ?>
                                </div>
                                <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']); ?>" width="180" height="40" alt="CAPTCHA" /></div>
                                <div class="bx-authform-input-container">
                                    <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Введите капчу" />
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>


                    <button
                        type="submit"
                        class="header-btn btn-user-drawer Manrope"
                        name="<?= $arResult["AUTH_URL"] ?>">

                        Отправить

                    </button>

                </form>

            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener(" DOMContentLoaded", function() {

        const form = document.forms["bform"];

        if (!form) return;

        form.addEventListener("submit", function() {

            form.USER_EMAIL.value = form.USER_LOGIN.value;

        });

    });
</script>