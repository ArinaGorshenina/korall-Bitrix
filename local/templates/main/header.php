<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Page\Asset;
global $USER;
$isAuthorized = $USER->IsAuthorized();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? $APPLICATION->ShowTitle(); ?></title>


    <!--  <meta name="description"
        content="Коралл | Широкий выбор товаров для освещения и оформления окон. Представляем качественную продукцию из России, Китая, Германии, Австрии, Турции.">
    <meta name="keywords"
        content="Коралл | Широкий выбор товаров для освещения и оформления окон. Представляем качественную продукцию из России, Китая, Германии, Австрии, Турции."> -->
    <link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/logo.svg" type="image/x-icon">

    <?php
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/style.css');
    /* 	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/main.js'); */

    Asset::getInstance()->addString('<link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">');
    Asset::getInstance()->addString('<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@200..900&display=swap" rel="stylesheet">');
    Asset::getInstance()->addString('<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">');
    ?>


    <? $APPLICATION->ShowHead(); ?>

</head>

<body>
    <div id="panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>
   

    <!-- header -->
    <header>
        <div class="header-up">
            <div class="header-up-left">
                <div class="header-locations">
                    <div class="header-locations-btn">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/direct-right.svg" alt="arrow">
                        <a href="#">Казань</a>
                    </div>
                    <div class="header-locations-content">
                        <a href="#">Казань</a>
                        <a href="#">Казань</a>
                        <a href="#">Казань</a>
                        <a href="#">Казань</a>
                    </div>
                </div>

                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "top_menu",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(""),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "top",
                        "USE_EXT" => "N"
                    )
                ); ?>
            </div>
            <div class="header-up-right">
                <div class="header-link">
                    <a href="tel:+" class="header-link-title">8 843 204-19-70</a>
                    <p class="header-link-desc">розница</p>
                </div>
                <div class="header-link">
                    <a href="tel:+" class="header-link-title">8 843 274-23-68</a>
                    <p class="header-link-desc">опт</p>
                </div>
            </div>
        </div>
        <div class="header-down">

            <div class="header-down-left">
                <a href="/index.php"> <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/logo.svg" alt="logo" class="logo"></a>
                <a href="/catalog/index.php" class="header-btn">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/menu.svg" alt="menu">
                    <p>Каталог</p>
                </a>
             <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.search", 
	"Search", 
	[
		"ACTION_VARIABLE" => "action",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "korall_shop",
		"LINE_ELEMENT_COUNT" => "3",
		"NO_WORD_LOGIC" => "N",
		"OFFERS_LIMIT" => "10",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "30",
		"PRICE_CODE" => [
			0 => "ROZN",
		],
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => "",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"RESTART" => "Y",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "#SECTION_CODE#/",
		"SHOW_PRICE_COUNT" => "1",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"USE_SEARCH_RESULT_ORDER" => "N",
		"USE_TITLE_RANK" => "N"
	],
	false
);?>
              <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "subtop_menu",
                            array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "subtop",
                                "USE_EXT" => "N"
                            )
                        ); ?>
            </div>
            <div class="header-down-right header-down-right-desktop">
                <?php if ($isAuthorized): ?>
                <a href="/personal/cart/index.php"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/bag-happy.svg" alt="cart"></a>
                <?php endif; ?>
                <a href="#"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/Heart.svg" alt="heart"></a>
                <a href="/personal/index.php" class="user_icon"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/User.svg" alt="user"></a>
            </div>

        </div>

    </header>

    <button class="burger">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="mobile-menu">
        <div class="mobile-menu-inner">

            <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "top_menu",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(""),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "top",
                        "USE_EXT" => "N"
                    )
                ); ?>
         
              <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "subtop_menu",
                            array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "subtop",
                                "USE_EXT" => "N"
                            )
                        ); ?>

                            <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.search", 
	"Search", 
	[
		"ACTION_VARIABLE" => "action",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "korall_shop",
		"LINE_ELEMENT_COUNT" => "3",
		"NO_WORD_LOGIC" => "N",
		"OFFERS_LIMIT" => "10",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "30",
		"PRICE_CODE" => [
			0 => "ROZN",
		],
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => "",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"RESTART" => "Y",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "#SECTION_CODE#/",
		"SHOW_PRICE_COUNT" => "1",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"USE_SEARCH_RESULT_ORDER" => "N",
		"USE_TITLE_RANK" => "N"
	],
	false
);?>
            <div class="header-down-right">
                <?php if ($isAuthorized): ?>
                <a href="/personal/cart/index.php"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/bag-happy.svg" alt="cart"></a>
               <?php endif; ?>
                <a href="#"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/Heart.svg" alt="heart"></a>
                <a href="/personal/index.php" class="user_icon"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/header/User.svg" alt="user"></a>
            </div>

        </div>
    </div>