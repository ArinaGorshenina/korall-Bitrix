<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParams
 */
?>
<?php if (!empty($arResult)): ?>
	<nav class="header-nav-up" data-header-nav>
		<?php foreach ($arResult as $arItem): ?>
			<a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
		<?php endforeach ?>
	</nav>

	<script>
	(function() {
		// Ищем все меню с data-атрибутом
		var navs = document.querySelectorAll('[data-header-nav]');
		navs.forEach(function(nav) {
			if (nav.closest('header')) {
				nav.classList.add('header-nav-down-desktop');
			}
			if (nav.closest('.mobile-menu-inner')) {
				nav.classList.add('header-nav-up-mobile');
			}
		});
	})();
	</script>
<?php endif ?>