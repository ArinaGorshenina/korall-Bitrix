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


<?php if (!empty($arResult["ITEMS"])): ?>

	<div class="news-items">
		<? foreach ($arResult["ITEMS"] as $arItem): ?>
			<div class="news-item">

				<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="news-item-box-img">
					<?php if ($arItem['PREVIEW_PICTURE']['SRC']): ?>
						<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
							alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>" />
					<?php endif; ?>
				</a>
				<p class="news-item-date"> <?php
											if (!empty($arItem['DATE_CREATE'])) {
												echo FormatDate("d.m.Y", MakeTimeStamp($arItem['DATE_CREATE']));
											}
											?>
				</p>

				<p class="news-item-desc"><?= isset($arItem['NAME']) ? $arItem['NAME'] : ''; ?></p>
			</div>

		<? endforeach; ?>
	</div>
<? endif; ?>

<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
	<br /><?= $arResult["NAV_STRING"] ?>
<? endif; ?>
