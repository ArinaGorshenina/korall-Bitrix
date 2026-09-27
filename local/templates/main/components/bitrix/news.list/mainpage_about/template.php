<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<?  /*   echo '<pre>';
print_r($arResult);
echo '</pre>';  */  ?>

<?php if (!empty($arResult["ITEMS"])): ?>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <div class="about mt100">
            <div class="container">
                <div class="about-box">
                    <h2 class="Unbounded"><?= isset($arItem['NAME']) ? $arItem['NAME'] : ''; ?></h2>

                    <div class="about-content">
                        <!-- Текстовый блок -->
                        <div class="about-txt-box">
                            <?php
                            if (!empty($arItem['PROPERTIES']['about_text']['VALUE'])):
                                foreach ($arItem['PROPERTIES']['about_text']['VALUE'] as $textItem):
                                    if (!empty($textItem['TEXT'])): ?>
                                        <p class="about-txt">
                                            <?= $textItem['TEXT'] ?>
                                        </p>
                            <?php endif;
                                endforeach;
                            endif;
                            ?>
                        </div>

                        <!-- Блок с маркетплейсами и ссылками -->
                        <div class="about-links">
                            <!-- Маркетплейсы (изображения с ссылками из DESCRIPTION) -->
                            <div class="about-links-up">
                                <p class="Unbounded">Наши товары на маркетплейсах</p>
                                <div class="about-links-images">
                                    <?php
                                    if (!empty($arItem['DISPLAY_PROPERTIES']['about_marketplays']['FILE_VALUE'])):
                                        foreach ($arItem['DISPLAY_PROPERTIES']['about_marketplays']['FILE_VALUE'] as $file):
                                            // Ссылка берется из DESCRIPTION файла
                                            $link = !empty($file['DESCRIPTION']) ? $file['DESCRIPTION'] : '#';
                                    ?>
                                            <a href="<?= $link ?>" target="_blank" rel="noopener noreferrer">
                                                <img src="<?= $file['SRC'] ?>" alt="Маркетплейс">
                                            </a>
                                    <?php endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>

                            <!-- Ссылки (about_links) с URL из DESCRIPTION -->
                            <div class="about-links-down">
                                <?php
                                if (!empty($arItem['PROPERTIES']['about_links']['VALUE'])):
                                    $linkValues = $arItem['PROPERTIES']['about_links']['VALUE'];
                                    $linkDescs = $arItem['PROPERTIES']['about_links']['DESCRIPTION'];

                                    foreach ($linkValues as $index => $linkText):
                                        // Ссылка берется из DESCRIPTION по тому же индексу
                                        $linkUrl = !empty($linkDescs[$index]) ? $linkDescs[$index] : '#';
                                ?>
                                        <a href="<?= $linkUrl ?>" class="about-link">
                                            <p class="Unbounded"><?= htmlspecialchars($linkText) ?></p>
                                            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/about/arrow-right.svg" alt="arrow-right">
                                        </a>
                                <?php endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Картинка элемента (превью) -->
                <?php if (!empty($arItem['PREVIEW_PICTURE']['SRC'])): ?>
                    <div class="about-img-box">
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                            alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?: $arItem['NAME'] ?>"
                            class="about-img">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <? endforeach; ?>
<? endif; ?>