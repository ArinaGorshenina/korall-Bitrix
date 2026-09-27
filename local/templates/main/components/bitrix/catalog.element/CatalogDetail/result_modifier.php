<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();


// Добавляем параметры для корзины
$arResult['ADD_URL'] = $arResult['~ADD_URL_TEMPLATE'];
$arResult['BUY_URL'] = $arResult['~BUY_URL_TEMPLATE'];

// Заменяем #ID# на ID товара
$arResult['ADD_URL'] = str_replace('#ID#', $arResult['ID'], $arResult['ADD_URL']);
$arResult['BUY_URL'] = str_replace('#ID#', $arResult['ID'], $arResult['BUY_URL']);
?>