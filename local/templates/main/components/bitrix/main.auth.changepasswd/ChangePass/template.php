<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$fields = $arResult['FIELDS'];
?>


<div class="account">

    <div class="container">
        <?php if ($arResult['AUTHORIZED']): ?>

            <p>Вы авторизованы</p>

        <?php else: ?>
            <div class="account-tabs">
                <h1 class="Unbounded">Смена пароля</h1>
            </div>

            <div class="account-content-form">



                <?php if (!empty($arResult["ERRORS"]) || !empty($arResult["SUCCESS"])): ?>

                    <?php
                    $authResult = !empty($arResult["ERRORS"])
                        ? ["MESSAGE" => implode("<br>", $arResult["ERRORS"]), "TYPE" => "ERROR"]
                        : ["MESSAGE" => $arResult["SUCCESS"], "TYPE" => "OK"];

                    $authResultClass = $authResult["TYPE"] === "OK" ? "auth-success-message" : "";
                    ?>

                    <div class="auth-error-message <?= $authResultClass ?>">
                        <p><?= $authResult["MESSAGE"] ?></p>
                    </div>

                <?php endif; ?>



                <form
                    name="bform"
                    method="post"
                    action="<?= POST_FORM_ACTION_URI ?>">

                    <input type="hidden" name="AUTH_FORM" value="Y">

                    <div class="form-gap">

                        <label>логин</label>

                        <input
                            type="text"
                            name="<?= $fields['login'] ?>"
                            value="<?= htmlspecialcharsbx($arResult['LAST_LOGIN']) ?>"
                            placeholder="Логин"
                            maxlength="255"
                            required>

                    </div>

                    <div class="form-gap">

                        <label>новый пароль</label>

                        <input
                            type="password"
                            name="<?= $fields['password'] ?>"
                            value=""
                            placeholder="Новый пароль"
                            maxlength="255"
                            autocomplete="new-password"
                            required>

                    </div>

                    <div class="form-gap">

                        <label>подтверждение пароля</label>

                        <input
                            type="password"
                            name="<?= $fields['confirm_password'] ?>"
                            value=""
                            placeholder="Повторите пароль"
                            maxlength="255"
                            autocomplete="new-password"
                            required>

                    </div>

                    <?php if (!empty($arResult['CAPTCHA_CODE'])): ?>

                        <div class="form-gap">

                            <input
                                type="hidden"
                                name="captcha_sid"
                                value="<?= htmlspecialcharsbx($arResult['CAPTCHA_CODE']) ?>">

                            <div class="bx-captcha">
                                <img
                                    src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult['CAPTCHA_CODE']) ?>"
                                    width="180"
                                    height="40"
                                    alt="CAPTCHA">
                            </div>

                            <input
                                type="text"
                                name="captcha_word"
                                maxlength="50"
                                autocomplete="off"
                                placeholder="Введите капчу"
                                required>

                        </div>

                    <?php endif; ?>

                    <input
                        type="hidden"
                        name="<?= $fields['checkword'] ?>"
                        value="<?= htmlspecialcharsbx($arResult[$fields['checkword']]) ?>">

                    <button
                        type="submit"
                        name="<?= $fields['action'] ?>"
                        value="Y"
                        class="header-btn btn-user-drawer Manrope">
                        Сменить пароль
                    </button>

                </form>

            </div>
        <?php endif; ?>
    </div>
</div>