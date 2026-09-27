<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */


if (empty($arResult)) {
    return '';
}

$res = '<div class="breadcrumbs">
      ';

$elCount = count($arResult);
foreach ($arResult as $index => $item) {
    $link = (!empty($item['LINK']) && $index < ($elCount - 1)) ? $item['LINK'] : '#'; // чтобы для последнего элемента не выводилась ссылка
    $title = $item['TITLE'] ?? '';
    
    // Выводим элемент хлебных крошек
    $res .= '<a href="' . $link . '" class="breadcrumb">' . $title . '</a>';
    
    // Добавляем разделитель ТОЛЬКО если это НЕ последний элемент
    if ($index < $elCount - 1) {
        $res .= '<p>•</p>';
    }
}

$res .= '   
    </div>';

return $res;

