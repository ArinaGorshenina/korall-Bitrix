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

<div class="banner mt160">
    <div class="container">
        <div class="banner-contents">
            <?php $slideIndex = 0; // Счетчик слайдов 
            ?>
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?

                $activeClass = ($slideIndex == 0) ? 'active' : '';
                ?>
                <div class="banner-slide <?= $activeClass ?>">
                    <div class="banner-content">
                        <div class="banner-content-txt">
                            <h1 class="Unbounded">
                                <?= isset($arItem['NAME']) ? $arItem['NAME'] : ''; ?>
                            </h1>
                            <div class="banner-desc"><?= isset($arItem['PREVIEW_TEXT']) ? $arItem['PREVIEW_TEXT'] : ''; ?></div>
                            <a href="<?= $arItem['PROPERTIES']['link']['VALUE']; ?>" class="header-btn banner-btn"><?= $arItem['PROPERTIES']['link']['DESCRIPTION']; ?></a>
                        </div>

                        <div class="banner-img-wrapper">
                            <? if (!empty($arItem['PREVIEW_PICTURE']['SRC'])) { ?>
                                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT']; ?>" class="banner-img">
                            <? } ?>

                            <? if (!empty($arItem['DETAIL_PICTURE']['SRC'])) { ?>
                                <img src="<?= $arItem['DETAIL_PICTURE']['SRC']; ?>" alt="<?= $arItem['DETAIL_PICTURE']['ALT']; ?>" class="brandsimage">
                            <? } ?>
                            <div class="banner-overlay"></div>
                        </div>
                    </div>
                </div>
                <?php $slideIndex++; // Увеличиваем счетчик 
                ?>
            <? endforeach; ?>
        </div>
        <div class="banner-pagns">
            <div class="banner-pag active"></div>
            <div class="banner-pag"></div>
        </div>
    </div>
</div>

