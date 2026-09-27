<?

use Bitrix\Main\Page\Asset;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
// Добавляем подключение пролога
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
?>


<footer class="mt100">
    <div class="container">
        <div class="footer-up">
            <div class="footer-up-left">
                <div class="footer-contacts">
                    <div class="footer-contacts-box">
                        <a href="tel:+88432041970" class="footer-contacts-title">8 843 204-19-70</a>
                        <p class="footer-box-desc">телефон для розницы</p>
                    </div>
                    <div class="footer-contacts-box">
                        <a href="tel:+88432742368" class="footer-contacts-title">8 843 274-23-68</a>
                        <p class="footer-box-desc">телефон для опта</p>
                    </div>
                    <div class="footer-contacts-box">
                        <a href="mailto:sales@korall-ltd.ru" class="footer-contacts-title">sales@korall-ltd.ru</a>
                        <p class="footer-box-desc">электронная почта</p>
                    </div>
                </div>
                <div class="footer-navs">
                    <div class="footer-nav-item">
                        <p class="footer-nav-title">Компания</p>

                        <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "bottom_menu",
                            array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "company_bottom",
                                "USE_EXT" => "N"
                            )
                        ); ?>
                    </div>
                    <div class="footer-nav-item">
                        <p class="footer-nav-title">Каталог</p>

                        <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "bottom_menu",
                            array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "catalog_bottom",
                                "USE_EXT" => "N"
                            )
                        ); ?>
                    </div>
                    <div class="footer-nav-item">
                        <p class="footer-nav-title">Помощь</p>

                        <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "bottom_menu",
                            array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "help_bottom",
                                "USE_EXT" => "N"
                            )
                        ); ?>
                    </div>
                </div>
            </div>

            <div class="footer-links-box">
                <div class="contacts-images footer-images">
                    <a href="#" class="contacts-img-box footer-img-box-w">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/footer/Vector.svg" alt="contact">
                    </a>
                    <a href="#" class="contacts-img-box footer-img-box-w">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/footer/Vector-1.svg" alt="contact">
                    </a>
                    <a href="#" class="contacts-img-box footer-img-box-w">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/footer/Vector-2.svg" alt="contact">
                    </a>
                    <a href="#" class="contacts-img-box footer-img-box-w">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/footer/Vector-3.svg" alt="contact">
                    </a>
                    <a href="#" class="contacts-img-box footer-link">
                        Задать вопрос
                    </a>
                </div>
                <p>Наши товары
                    на маркетплейсах</p>
                <div class="about-links-images footer-links-images">
                    <a href="#"> <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/about/1.svg" alt="brand"></a>
                    <a href="#"> <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/about/2.svg" alt="brand"></a>
                    <a href="#"> <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/about/3.svg" alt="brand"></a>
                </div>
            </div>
        </div>

        <div class="f-politic-box">
            <p>© 2024 Официальный сайт StroySnab. Все права защищены</p>
            <a href="#" download>Политика конфиденциальности</a>
            <a href="#">Карта сайта</a>
            <div class="f-politic-everytech">
                <p>Разработка и продвижение</p>
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/footer/Frame.svg" alt="Frame">
            </div>
        </div>
    </div>
</footer>


<!-- //всегда в конце стр -->
<div class="user-overlay"></div>

<div class="user-drawer">
    <div class="user-drawer-content">
        <?php
        // Для отладки покажем, авторизован ли пользователь
        echo '<!-- USER авторизован? ' . ($USER->IsAuthorized() ? 'ДА' : 'НЕТ') . ' -->';
        ?>

        <?php if (!$USER->IsAuthorized()): ?>
            <!-- Этот блок виден только НЕавторизованным -->
            <p class="Unbounded user-drawer-title">Создайте аккаунт</p>
            <p class="user-drawer-desc">Для этого укажите только
                электронную почту, мы отправим
                на нее данные для входа</p>
            <div class="user-drawer-tabs">
                <p class="user-drawer-tab active Manrope">регистрация</p>
                <p class="user-drawer-tab Manrope">авторизация</p>
            </div>



            <!-- Форма регистрации -->
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:system.auth.registration",
                "templates/regForm",
                array(
                    "USER_PROPERTY" => array(), // Если нужны доп. поля
                    "SHOW_FIELDS" => array("EMAIL"), // Какие поля показывать (только email)
                    "REQUIRED_FIELDS" => array("EMAIL"),
                    "AUTH_URL" => "", // Ссылка на страницу авторизации (можно оставить пустой)
                    "USE_CAPTCHA" => "N", // CAPTCHA часто отключают при подтверждении по email
                    "AUTH" => "Y",
                    "SHOW_ERRORS" => "Y",

                )
            );
            ?>


            <!-- Форма авторизации -->
            <? $APPLICATION->IncludeComponent(
                "bitrix:system.auth.form",
                "authForm",
                array(
                    "REGISTER_URL" => "",
                    "FORGOT_PASSWORD_URL" => "",
                    "PROFILE_URL" => "",
                    "SHOW_ERRORS" => "Y"
                ),
                false
            ); ?>

            <!-- Скрытый блок с компонентом подтверждения -->
            <div id="confirmation-block" style="display: none;">
                <p class="Unbounded user-drawer-title">Последний шаг!</p>
                <p class="user-drawer-desc">Теперь проверьте почту - отправили туда код для входа в личный кабинет, введите его, чтобы подтвердить свой аккаунт</p>

                <? $APPLICATION->IncludeComponent(
                    "bitrix:system.auth.confirmation",
                    "Confirm",
                    array(
                        "CONFIRM_CODE" => "confirm_code",
                        "LOGIN" => "login",
                        "USER_ID" => "confirm_user_id",
                        "CACHE_TYPE" => "N",
                    )
                ); ?>
            </div>

        <?php else: ?>
            <!-- Этот блок виден авторизованным пользователям -->
            <p class="Unbounded user-drawer-title">Личный кабинет</p>
            <p class="user-drawer-desc">Добро пожаловать, <?= htmlspecialchars($USER->GetFullName() ?: $USER->GetLogin()) ?>!</p>
            <div class="user-drawer-links">
                <a href="/personal/index.php" class="user-drawer-link">Мой профиль</a>
            </div>

            <!-- Форма выхода -->
         <form action="/" method="post">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="logout" value="yes" />
    <input type="hidden" name="backurl" value="/" />
    <button type="submit" class="header-btn btn-user-drawer Manrope">Выйти</button>
</form>

        <?php endif; ?>
    </div>

</div>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/main.js"></script>
</body>

</html>