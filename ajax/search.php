<?
define("STOP_STATISTICS", true);
define("NO_KEEP_STATISTIC", true);
define("PUBLIC_AJAX_MODE", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

header('Content-Type: text/html; charset=UTF-8');
global $USER;
$isAuthorized = $USER->IsAuthorized();

$searchQuery = trim((string)($_REQUEST['q'] ?? ''));

$iblockType = 'korall_shop';
$iblockId   = 3;

if (mb_strlen($searchQuery) < 2)
{
    die();
}

$arElements = [];

if (Loader::includeModule('search'))
{
    ob_start();
    $arElements = $APPLICATION->IncludeComponent(
        "bitrix:search.page",
        ".default",
        [
            "RESTART" => "Y",
            "NO_WORD_LOGIC" => "N",
            "USE_LANGUAGE_GUESS" => "Y",
            "CHECK_DATES" => "N",
            "arrFILTER" => ["iblock_" . $iblockType],
            "arrFILTER_iblock_" . $iblockType => [$iblockId],
            "USE_TITLE_RANK" => "Y",
            "DEFAULT_SORT" => "rank",
            "FILTER_NAME" => "",
            "SHOW_WHERE" => "N",
            "arrWHERE" => [],
            "SHOW_WHEN" => "N",
            "PAGE_RESULT_COUNT" => 8,
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "N",
        ],
        false,
        ['HIDE_ICONS' => 'Y']
    );
    ob_end_clean();
}

if (empty($arElements) || !is_array($arElements))
{
    echo '<div class="search-dropdown-empty">Ничего не найдено</div>';
    die();
}

if (!Loader::includeModule('catalog') || !Loader::includeModule('iblock'))
{
    die();
}

global $USER;

$res = \CIBlockElement::GetList(
    ["SORT" => "ASC"],
    ["IBLOCK_ID" => $iblockId, "ID" => $arElements, "ACTIVE" => "Y"],
    false,
    ["nTopCount" => 8],
    ["ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE"]
);

$rows = '';

while ($el = $res->GetNext())
{
    $picId  = $el['PREVIEW_PICTURE'] ?: $el['DETAIL_PICTURE'];
    $picSrc = $picId ? \CFile::GetPath($picId) : SITE_TEMPLATE_PATH . '/assets/images/no-photo.png';

    $priceHtml = '';

    $arPrice = \CCatalogProduct::GetOptimalPrice(
        $el['ID'],
        1,
        ($USER ? $USER->GetUserGroupArray() : [2]),
        'N',
        [],
        SITE_ID,
        ['ROZN']
    );

    if ($arPrice && isset($arPrice['RESULT_PRICE']))
    {
        $currency = $arPrice['PRICE']['CURRENCY'] ?? 'RUB';
        $base     = (float)$arPrice['RESULT_PRICE']['BASE_PRICE'];
        $discount = (float)$arPrice['RESULT_PRICE']['DISCOUNT_PRICE'];

        $finalPriceFmt = \CCurrencyLang::CurrencyFormat($discount, $currency, true);

        if ($discount < $base)
        {
            $oldPriceFmt = \CCurrencyLang::CurrencyFormat($base, $currency, true);
            $priceHtml = '
                <span class="search-item-price">' . $finalPriceFmt . '</span>
                <span class="search-item-price-old">' . $oldPriceFmt . '</span>
            ';
        }
        else
        {
            $priceHtml = '<span class="search-item-price">' . $finalPriceFmt . '</span>';
        }
    }

    $rows .= '
        <div class="search-dropdown-item">
            <a href="' . \htmlspecialcharsbx($el['DETAIL_PAGE_URL']) . '" class="search-item-link">
                <img src="' . \htmlspecialcharsbx($picSrc) . '" alt="' . \htmlspecialcharsbx($el['NAME']) . '" class="search-item-img">
                <span class="search-item-name">' . \htmlspecialcharsbx($el['NAME']) . '</span>
            </a>
            <div class="search-item-price-wrap">' . $priceHtml . '</div>
      
            <button type="button" class="search-item-basket-btn" data-id="' . (int)$el['ID'] . '" title="В корзину">
                <img src="' . SITE_TEMPLATE_PATH . '/assets/images/header/bag-happy.svg" alt="basket">
            </button>
        </div>
    ';
}

echo $rows !== '' ? $rows : '<div class="search-dropdown-empty">Ничего не найдено</div>';
die();