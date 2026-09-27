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
<? if ($arResult["NavPageCount"] > 1): ?>

    <div class="news-paginations">

        <? for ($i = 1; $i <= $arResult["NavPageCount"]; $i++): ?>

            <? if ($i == $arResult["NavPageNomer"]): ?>
                <div class="news-pag active">
                    <p><?= $i ?></p>
                </div>
            <? else: ?>
                <a class="news-pag" href="<?= $arResult["sUrlPath"] ?>?PAGEN_<?= $arResult["NavNum"] ?>=<?= $i ?>">
                    <p><?= $i ?></p>
                </a>
            <? endif; ?>

        <? endfor; ?>

    </div>

<? endif; ?>