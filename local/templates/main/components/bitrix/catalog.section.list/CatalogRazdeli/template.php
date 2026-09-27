<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>
<?php
// Функция для склонения слова "товар"
function getCountWord($count) {
    $count = intval($count);
    $lastDigit = $count % 10;
    $lastTwoDigits = $count % 100;
    
    if ($lastTwoDigits >= 11 && $lastTwoDigits <= 19) {
        return 'товаров';
    }
    
    if ($lastDigit == 1) {
        return 'товар';
    }
    
    if ($lastDigit >= 2 && $lastDigit <= 4) {
        return 'товара';
    }
    
    return 'товаров';
}
?>
	



<?if (0 < $arResult["SECTIONS_COUNT"]):?>
        <div class="minicatalog-items" id="scroll-catalog">
            <?php
            $i = 0;
            $gridClasses = ['grid1', 'grid2', 'grid3'];
            foreach ($arResult['SECTIONS'] as &$arSection):
                $i++;
                // Если разделов больше 3, цикл начнется заново
                $gridClass = $gridClasses[($i - 1) % 3];
                
                // Получаем картинку раздела
                $sectionPicture = $arSection['PICTURE']['SRC'] ?? '';
                if (empty($sectionPicture)) {
                    // Если картинки нет, используем заглушку
                    $sectionPicture = SITE_TEMPLATE_PATH . '/assets/images/minicatalog/default.png';
                }
                
                // Количество товаров
                $elementCount = $arSection['ELEMENT_CNT'] ?? 0;
                $countText = $elementCount . ' ' . getCountWord($elementCount);
            ?>
            <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="minicatalog-item <?=$gridClass?>">
                <div class="minicatalog-content-txt">
                    <h3 class="Unbounded">
                        <?=$arSection['NAME']?>
                    </h3>
                    <div class="minicatalog-desc Manrope"><?=$countText?></div>
                </div>

                <div class="banner-img-wrapper minicatalog-img-wrapper">
                    <img src="<?=$sectionPicture?>" alt="<?=$arSection['NAME']?>" class="banner-img minicatalog-img">
                    <div class="minicatalog-overlay"></div>
                </div>
            </a>
            <?php endforeach;?>
        </div>
<?endif;?>
  
