<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
?>

<!-- banner -->
<? $APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "mainpage_top_slider",
    [
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "N",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => [
            0 => "NAME",
            1 => "PREVIEW_TEXT",
            2 => "PREVIEW_PICTURE",
            3 => "DETAIL_PICTURE",
            4 => "",
        ],
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "2",
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "5",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => [
            0 => "link",
            1 => "",
        ],
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "SORT",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N"
    ],
    false
); ?>

<div class="minicatalog mt100">
    <div class="container">
        <h2 class="Unbounded">Основные категории </h2><?
                                                        $APPLICATION->IncludeComponent(
                                                            "bitrix:catalog.section.list",
                                                            "CatalogRazdeli",
                                                            [
                                                                "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
                                                                "ADD_SECTIONS_CHAIN" => "Y",
                                                                "CACHE_FILTER" => "N",
                                                                "CACHE_GROUPS" => "Y",
                                                                "CACHE_TIME" => "36000000",
                                                                "CACHE_TYPE" => "A",
                                                                "COUNT_ELEMENTS" => "Y",
                                                                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                                                                "FILTER_NAME" => "sectionsFilter",
                                                                "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
                                                                "IBLOCK_ID" => "3",
                                                                "IBLOCK_TYPE" => "korall_shop",
                                                                "SECTION_CODE" => "",
                                                                "SECTION_FIELDS" => [
                                                                    0 => "NAME",
                                                                    1 => "PICTURE",
                                                                    2 => "",
                                                                ],
                                                                "SECTION_ID" => $_REQUEST["SECTION_ID"],
                                                                "SECTION_URL" => "/catalog/#SECTION_CODE#/",
                                                                "SECTION_USER_FIELDS" => [
                                                                    0 => "",
                                                                    1 => "",
                                                                ],
                                                                "SHOW_PARENT_NAME" => "Y",
                                                                "TOP_DEPTH" => "2",
                                                                "VIEW_MODE" => "LINE"
                                                            ],
                                                            false
                                                        ); ?>
        <div class="minicatalog-box-btn">
            <a href="/catalog/index.php" class="header-btn minicatalog-btn">Посмотреть весь каталог</a>
        </div>
    </div>
</div>

<div class="about mt100">
    <div class="container">
        <div class="about-box">
            <h2 class="Unbounded">Компания </h2>
            <div class="about-content">
                <div class="about-txt-box">
                    <p class="about-txt">
                        Компания «Коралл» – это команда специалистов, предлагающая только лучшие товары. У нас вы
                        найдете широкий ассортимент карнизов, систем солнцезащиты, аксессуаров и освещения. Вся
                        продукция отличается безупречным качеством, в котором уже смогли убедиться наши покупатели.
                    </p>
                    <p class="about-txt">
                        Мы предлагаем широкий выбор товаров для оформления окон как собственного производства, так и
                        других ведущих производителей. Представляем качественную продукцию из России, Китая,
                        Германии,
                        Австрии, Турции по доступным ценам.
                    </p>
                    <p class="about-txt">
                        Отправляем товары по всей России, всегда готовы помочь. Для оптовых покупателей действует
                        гибкая
                        система скидок.
                    </p>
                </div>
                <div class="about-links">
                    <div class="about-links-up">
                        <p class="Unbounded">Наши товары
                            на маркетплейсах</p>
                        <div class="about-links-images">
                            <a href="#"> <img src="assets/images/about/1.svg" alt="brand"></a>
                            <a href="#"> <img src="assets/images/about/2.svg" alt="brand"></a>
                            <a href="#"> <img src="assets/images/about/3.svg" alt="brand"></a>
                        </div>
                    </div>
                    <div class="about-links-down">
                        <a href="#" class="about-link">
                            <p class="Unbounded">Наши магазины</p>
                            <img src="assets/images/about/arrow-right.svg" alt="arrow-right">
                        </a>
                        <a href="#" class="about-link">
                            <p class="Unbounded">Сотрудничество</p>
                            <img src="assets/images/about/arrow-right.svg" alt="arrow-right">
                        </a>
                        <a href="news.html" class="about-link">
                            <p class="Unbounded">Новости и статьи</p>
                            <img src="assets/images/about/arrow-right.svg" alt="arrow-right">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-img-box"> <img src="assets/images/about/about.png" alt="about" class="about-img"></div>
    </div>
</div>

<div class="minicatalog-popul">
    <div class="container">
        <h2 class="Unbounded">Популярные товары </h2>
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.top",
            "PopProducts",
            array(
                "ACTION_VARIABLE" => "action",
                "ADD_PICT_PROP" => "-",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "BASKET_URL" => "/personal/basket.php",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                "COMPATIBLE_MODE" => "N",
                "CONVERT_CURRENCY" => "Y",
                "CURRENCY_ID" => "RUB",
                "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                "DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
                "DISPLAY_COMPARE" => "N",
                "ELEMENT_COUNT" => "8",
                "ELEMENT_SORT_FIELD" => "shows",
                "ELEMENT_SORT_FIELD2" => "id",
                "ELEMENT_SORT_ORDER" => "desc",
                "ELEMENT_SORT_ORDER2" => "desc",
                "ENLARGE_PRODUCT" => "STRICT",
                "FILTER_NAME" => "",
                "HIDE_NOT_AVAILABLE" => "N",
                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                "IBLOCK_ID" => "3",
                "IBLOCK_TYPE" => "korall_shop",
                "LABEL_PROP" => array(),
                "LINE_ELEMENT_COUNT" => "4",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_COMPARE" => "Сравнить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array("ROZN"),
                "PRICE_VAT_INCLUDE" => "N",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                "PRODUCT_SUBSCRIPTION" => "Y",
                "PROPERTY_CODE_MOBILE" => array(),
                "ROTATE_TIMER" => "30",
                "SECTION_URL" => "/catalog/#SECTION_CODE#/",
                "SEF_MODE" => "N",
                "SEF_RULE" => "",
                "SHOW_CLOSE_POPUP" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "N",
                "SHOW_PAGINATION" => "Y",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_SLIDER" => "N",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "N",
                "VIEW_MODE" => "SECTION"
            )
        ); ?>


        <?
        require($_SERVER['DOCUMENT_ROOT'] . '/local/templates/main/includes/shops.php'); ?>

        <div class="cooperation mt100">
            <div class="container">
                <h2 class="Unbounded">Сотрудничество </h2>
                <div class="cooperation-content">
                    <div class="cooperation-txt-box">
                        <p class="cooperation-desc">Мы всегда рады видеть в качестве партнеров:
                            портьерные салоны, дизайнеров интерьеров и дизайнеров по текстилю. Мы предоставляем гибкую
                            систему скидок, а также подбираем оптимальный вариант работы для каждого клиента.</p>
                        <div class="cooperation-txt-box-down">
                            <p class="cooperation-desc2"><span class="b">Для уточнения деталей и регистрации в качестве
                                    «партнера»</span> необходимо обратиться в оптовый
                                отдел продаж или оставить заявку на электронную почту.</p>
                        </div>
                        <div class="cooperation-contacts">
                            <p>телефон:</p>
                            <a href="tel:+88432742368">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => SITE_TEMPLATE_PATH . "/includes/cooperation_phone.php"
                                    )
                                ); ?></a>
                        </div>
                        <div class="cooperation-contacts">
                            <p>почта:</p>
                            <a href="mailto:partn@korall-ltd.ru"> <? $APPLICATION->IncludeComponent(
                                                                        "bitrix:main.include",
                                                                        "",
                                                                        array(
                                                                            "AREA_FILE_SHOW" => "file",
                                                                            "PATH" => SITE_TEMPLATE_PATH . "/includes/cooperation_email.php"
                                                                        )
                                                                    ); ?></a>
                        </div>
                    </div>
                    <div class="coo-images"><? $APPLICATION->IncludeComponent(
                                                "bitrix:main.include",
                                                "",
                                                array(
                                                    "AREA_FILE_SHOW" => "file",
                                                    "PATH" => SITE_TEMPLATE_PATH . "/includes/cooperation_img.php"
                                                )
                                            ); ?>
                        <div class="coo-overlay"></div>
                    </div>
                </div>
            </div>
        </div>

        <?
        require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
        ?>