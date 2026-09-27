<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);

global $USER;
$isAuthorized = $USER->IsAuthorized();
// Получаем данные товара
$arElement = $arResult;

// Получаем название раздела
$sectionName = '';
if (!empty($arElement['SECTION']['NAME'])) {
    $sectionName = $arElement['SECTION']['NAME'];
} elseif (!empty($arElement['IBLOCK_SECTION_ID'])) {
    $dbSection = CIBlockSection::GetList(
        array(),
        array('ID' => $arElement['IBLOCK_SECTION_ID']),
        false,
        array('NAME')
    );
    if ($arSection = $dbSection->Fetch()) {
        $sectionName = $arSection['NAME'];
    }
}

// Получаем картинку товара
$imgSrc = '';
if (!empty($arElement['DETAIL_PICTURE']['SRC'])) {
    $imgSrc = $arElement['DETAIL_PICTURE']['SRC'];
} elseif (!empty($arElement['PREVIEW_PICTURE']['SRC'])) {
    $imgSrc = $arElement['PREVIEW_PICTURE']['SRC'];
}

$price = '';
$oldPrice = '';
$discountPercent = 0;

$priceData = !empty($arElement['ITEM_PRICES']) ? reset($arElement['ITEM_PRICES']) : (!empty($arElement['PRICES']) ? reset($arElement['PRICES']) : null);

if ($priceData) {
    $price = number_format($priceData['PRICE'], 2, '.', ' ') . ' ₽';

    if (!empty($priceData['BASE_PRICE']) && $priceData['BASE_PRICE'] > $priceData['PRICE']) {
        $oldPrice = number_format($priceData['BASE_PRICE'], 2, '.', ' ') . ' ₽';
        $discountPercent = round((1 - $priceData['PRICE'] / $priceData['BASE_PRICE']) * 100);
    } elseif (!empty($priceData['DISCOUNT_PERCENT'])) {
        $discountPercent = (int)$priceData['DISCOUNT_PERCENT'];
    }
}


// ============================================================
// КОЛИЧЕСТВО ТОВАРА И НАЛИЧИЕ
// ============================================================

$quantity = 0;
$quantityReserved = 0;
$availableQuantity = 0;
$quantityTrace = 'N';

// isAvailable оставляем для кнопки покупки
$isAvailable = false;

if (\Bitrix\Main\Loader::includeModule('catalog')) {

    $product = \Bitrix\Catalog\ProductTable::getRow([
        'filter' => [
            '=ID' => (int)$arElement['ID']
        ],
        'select' => [
            'ID',
            'QUANTITY',
            'QUANTITY_RESERVED',
            'QUANTITY_TRACE',
            'CAN_BUY_ZERO'
        ]
    ]);

    if ($product) {
        $quantity = (float)$product['QUANTITY'];
        $quantityReserved = (float)$product['QUANTITY_RESERVED'];
        $quantityTrace = $product['QUANTITY_TRACE'];

        // Если количественный учет включен
        if ($quantityTrace === 'Y') {
            $availableQuantity = max(
                0,
                $quantity - $quantityReserved
            );
        } else {
            // При отключенном количественном учете
            $availableQuantity = 1;
        }
    }
}


// ============================================================
// СКЛАДЫ
// ============================================================

$arStores = [];

if (\Bitrix\Main\Loader::includeModule('catalog')) {

    $storeResult = \Bitrix\Catalog\StoreTable::getList([
        'filter' => [
            '=ACTIVE' => 'Y'
        ],
        'order' => [
            'SORT' => 'ASC',
            'ID' => 'ASC'
        ],
        'select' => [
            'ID',
            'TITLE',
            'ADDRESS',
            'DESCRIPTION'
        ]
    ]);

    while ($store = $storeResult->fetch()) {

        // Получаем остаток конкретного товара
        // на конкретном складе
        $storeProduct = \Bitrix\Catalog\StoreProductTable::getRow([
            'filter' => [
                '=STORE_ID' => (int)$store['ID'],
                '=PRODUCT_ID' => (int)$arElement['ID']
            ],
            'select' => [
                'STORE_ID',
                'PRODUCT_ID',
                'AMOUNT',
                'QUANTITY_RESERVED'
            ]
        ]);

        $store['AMOUNT'] = $storeProduct
            ? (float)$storeProduct['AMOUNT']
            : 0;

        $store['QUANTITY_RESERVED'] = $storeProduct
            ? (float)$storeProduct['QUANTITY_RESERVED']
            : 0;

        // Доступное количество конкретно на этом складе
        $store['AVAILABLE'] = max(
            0,
            $store['AMOUNT'] - $store['QUANTITY_RESERVED']
        );

        $arStores[] = $store;
    }
}


// ============================================================
// ПРОВЕРКА НАЛИЧИЯ
// ============================================================

// Если есть хотя бы один склад,
// где доступен товар — товар можно купить.
if (!empty($arStores)) {

    foreach ($arStores as $arStore) {

        if ((float)$arStore['AVAILABLE'] > 0) {
            $isAvailable = true;
            break;
        }
    }

} else {

    // Если складов нет — используем
    // общее количество товара
    $isAvailable = ($availableQuantity > 0);
}


// Получаем URL для добавления в корзину
$addUrl = !empty($arResult['ADD_URL']) ? $arResult['ADD_URL'] : '#';
$buyUrl = !empty($arResult['BUY_URL']) ? $arResult['BUY_URL'] : '#';
?>

<div class="product-page">
    <div class="container">
        <div class="product-page-content">
            <div class="product-page-img-box">
                <?php if ($discountPercent > 0): ?>
                    <span class="discount-badge">-<?= $discountPercent ?>%</span>
                <?php endif; ?>
                <img src="<?= $imgSrc ?>" alt="<?= $arElement['NAME'] ?>">
            </div>
            <div class="product-page-info-box">
                <div class="product-page-info-box-up">
                    <div class="breadcrumbs breadcrumbs-product-page">
                        <a href="/catalog/" class="breadcrumb">каталог</a>
                        <p>•</p>
                        <a href="/catalog/" class="breadcrumb"><?= $sectionName ?></a>
                    </div>
                    <p class="product-page-title"><?= $arElement['NAME'] ?></p>
                </div>
                <div class="product-page-info-box-down">
                    <div class="price-box">
                      <p class="product-page-price<?= $discountPercent > 0 ? ' price-red' : '' ?>"><?= $price ?></p>
                        <?php if (!empty($oldPrice)): ?>
                            <span class="price-old"><?= $oldPrice ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($isAuthorized): ?>
                        <?php if ($isAvailable): ?>
                            <a href="<?= htmlspecialcharsbx($addUrl) ?>" class="header-btn" rel="nofollow">
                                Добавить в корзину
                            </a>
                        <?php else: ?>
                            <button type="button" class="header-btn disabled" disabled>Нет в наличии</button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button type="button" class="header-btn disabled" disabled>Войдите, чтобы купить</button>
                    <?php endif; ?>
                </div>
             <div class="product-page-info-box-nal">

    <p class="product-page-nal-title">
        Наличие в магазинах
    </p>

    <?php if (!empty($arStores)): ?>

        <!-- Города / склады -->
        <div class="product-page-nal-tabs">

            <?php foreach ($arStores as $key => $arStore): ?>

                <div
                    class="product-page-nal-tab <?= ($key === 0) ? 'active' : '' ?>"
                    data-store="<?= (int)$arStore['ID'] ?>"
                >
                    <p>
                        <?= htmlspecialcharsbx($arStore['TITLE']) ?>
                    </p>
                </div>

            <?php endforeach; ?>

        </div>


        <!-- Остатки -->
        <?php foreach ($arStores as $key => $arStore): ?>

            <div
                class="product-page-nal-content <?= ($key === 0) ? 'active' : '' ?>"
                data-store-content="<?= (int)$arStore['ID'] ?>"
            >

                <?php if ($arStore['AVAILABLE'] > 0): ?>

                    <p class="product-page-nal-ost">
                        Остаток:
                        <?= (float)$arStore['AVAILABLE'] ?>
                        шт.
                    </p>

                    <?php if ($arStore['QUANTITY_RESERVED'] > 0): ?>

                        <p class="product-page-nal-desc">
                            Зарезервировано:
                            <?= (float)$arStore['QUANTITY_RESERVED'] ?>
                            шт.
                        </p>

                    <?php endif; ?>

                <?php else: ?>

                    <p class="product-page-nal-ost">
                        Нет в наличии
                    </p>

                <?php endif; ?>


                <?php if (!empty($arStore['ADDRESS'])): ?>

                    <p class="product-page-nal-desc">
                        <?= htmlspecialcharsbx($arStore['ADDRESS']) ?>
                    </p>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>


    <?php else: ?>

        <!-- Если складов нет -->

        <div class="product-page-nal-tabs">

            <div class="product-page-nal-tab active">
                <p>На складе</p>
            </div>

        </div>

        <div class="product-page-nal-content active">

            <?php if ($availableQuantity > 0): ?>

                <p class="product-page-nal-ost">
                    В наличии:
                    <?= (float)$availableQuantity ?> шт.
                </p>

            <?php else: ?>

                <p class="product-page-nal-ost">
                    Нет в наличии
                </p>

            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>
            </div>
        </div>
    </div>
</div>