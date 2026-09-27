<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParams
 */
?>

<?php if (!empty($arResult)): ?>
	<nav class="footer-nav">
		<?php foreach ($arResult as $arItem): ?>
			<a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
		<?php endforeach ?>
	</nav>
<?php endif ?>
