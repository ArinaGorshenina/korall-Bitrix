<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParams
 */
?>



<?php if (!empty($arResult)): ?>
	<nav class="header-nav-down" id="header-nav-menu">
		<?php foreach ($arResult as $arItem): ?>
			<a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
		<?php endforeach ?>
	</nav>
	
	<script>
	(function() {
		var nav = document.getElementById('header-nav-menu');
		if (!nav) return;
		
		// Проверяем, находится ли внутри .header-down-left
		var parent = nav.closest('.header-down-left');
		if (parent) {
			nav.classList.add('header-nav-down-desktop');
		}
	})();
	</script>
<?php endif ?>