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
<?   /*  echo '<pre>';
print_r($arResult);
echo '</pre>';   */   ?>


<div class="shops">
    <div class="container">
        <h2 class="Unbounded">Магазины </h2>


        <div class="shops-tab-box">
            <?php if (!empty($arResult["ITEMS"])): ?>
                <? foreach ($arResult["ITEMS"] as $arItem): ?>
                    <? $activeClass = ($slideIndex == 0) ? 'active' : '';
                    ?>
                    <div class="shops-tab <?= $activeClass ?>"> <?= isset($arItem['NAME']) ? $arItem['NAME'] : ''; ?> </div>
                <?
                    $slideIndex++;
                endforeach; ?>
            <? endif; ?>
        </div>

        <?php if (!empty($arResult["ITEMS"])): ?>
            <?php $contentIndex = 0; ?>
            <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                <?php $activeClass1 = ($contentIndex == 0) ? 'active' : ''; ?>

                <div class="shops-content <?= $activeClass1 ?>" data-city-content="<?= $contentIndex ?>">
                    <div class="shops-box">
                        <!-- Адрес -->
                        <div class="shops-box-box">
                            <p class="shops-box-title Unbounded title-blue">
                                <?= htmlspecialchars($arItem['PROPERTIES']['adres_magazines']['VALUE']) ?>
                            </p>
                            <p class="shop-box-desc">
                                <?= htmlspecialchars($arItem['PROPERTIES']['chasi_raboti']['VALUE']) ?>
                            </p>
                        </div>

                        <!-- Телефон розница -->
                        <div class="shops-box-box">
                            <?php
                            $roznitsaPhone = $arItem['PROPERTIES']['phone_roznitsa']['VALUE'];
                            $roznitsaLink = $arItem['PROPERTIES']['phone_roznitsa']['DESCRIPTION'];
                            ?>
                            <a href="tel:<?= htmlspecialchars($roznitsaLink) ?>"
                                class="shops-box-title Unbounded title-blue title-blue-hover">
                                <?= htmlspecialchars($roznitsaPhone) ?>
                            </a>
                            <p class="shop-box-desc">розница</p>
                        </div>

                        <!-- Email -->
                        <div class="shops-box-box">
                            <?php $email = $arItem['PROPERTIES']['email_magazines']['VALUE']; ?>
                            <a href="mailto:<?= htmlspecialchars($email) ?>"
                                class="shops-box-title Unbounded shops-box-title-hover">
                                <?= htmlspecialchars($email) ?>
                            </a>
                            <p class="shop-box-desc">электронная почта</p>
                        </div>

                        <!-- Оптовые телефоны -->
                        <div class="shops-box-box">
                            <?php
                            $optPhones = $arItem['PROPERTIES']['phone_opt']['VALUE'];
                            $optLinks = $arItem['PROPERTIES']['phone_opt']['DESCRIPTION'];

                            if (!empty($optPhones) && is_array($optPhones)):
                                foreach ($optPhones as $index => $phone):
                                    $link = !empty($optLinks[$index]) ? $optLinks[$index] : '';
                            ?>
                                    <div class="shops-box-phons">
                                        <a href="tel:<?= htmlspecialchars($link) ?>"
                                            class="shops-box-title Unbounded shops-box-title-hover">
                                            <?= htmlspecialchars($phone) ?>
                                        </a>
                                        <p class="shop-box-desc">опт</p>
                                    </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>

                        <!-- Социальные сети / Контакты -->
                        <div class="contacts-images">
                            <?php
                            $socialFiles = $arItem['PROPERTIES']['links_contacts']['VALUE'];
                            $socialLinks = $arItem['PROPERTIES']['links_contacts']['DESCRIPTION'];

                            if (!empty($socialFiles) && is_array($socialFiles)):
                                foreach ($socialFiles as $index => $fileId):
                                    $fileArray = CFile::GetFileArray($fileId);
                                    $link = !empty($socialLinks[$index]) ? $socialLinks[$index] : '#';
                                    if ($fileArray):
                            ?>
                                        <a href="<?= htmlspecialchars($link) ?>" class="contacts-img-box" target="_blank">
                                            <img src="<?= $fileArray['SRC'] ?>" alt="social">
                                        </a>
                            <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Карта -->

                    <?php
                    // Прямой доступ к VALUE (там полный HTML с iframe)
                    if (!empty($arItem['PROPERTIES']['karta']['VALUE']['TEXT'])):
                        echo htmlspecialchars_decode($arItem['PROPERTIES']['karta']['VALUE']['TEXT']);
                    endif;
                    ?>

                </div>

                <?php $contentIndex++; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>