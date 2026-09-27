<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Генерируем уникальный ID для каждого экземпляра
$uniqId = $this->randString(8);
$inputId = 'header-search-input-' . $uniqId;
$dropdownId = 'header-search-dropdown-' . $uniqId;
$wrapId = 'header-search-' . $uniqId;
$btnId = 'header-search-btn-' . $uniqId;
?>
<div class="h-btn-search" id="<?= $wrapId ?>" data-search>
	<input
		type="text"
		id="<?= $inputId ?>"
		placeholder="Поиск товара"
		maxlength="100"
		autocomplete="off">
	<button type="button" class="header-search-btn" id="<?= $btnId ?>">Найти</button>

	<div class="search-dropdown" id="<?= $dropdownId ?>"></div>
</div>

<script>
	(function() {
		var wrap = document.getElementById('<?= $wrapId ?>');
		var input = document.getElementById('<?= $inputId ?>');
		var dropdown = document.getElementById('<?= $dropdownId ?>');
		var btn = document.getElementById('<?= $btnId ?>');
		var timer = null;
		var lastQuery = '';

		// Добавляем класс если внутри header
		if (wrap.closest('header')) {
			wrap.classList.add('h-btn-search-desktop');
		}

		function closeDropdown() {
			dropdown.classList.remove('active');
			dropdown.innerHTML = '';
			lastQuery = '';
		}

		function runSearch(query) {
			fetch('/ajax/search.php?q=' + encodeURIComponent(query))
				.then(function(r) { return r.text(); })
				.then(function(html) {
					if (input.value.trim() !== query) return;
					dropdown.innerHTML = html;
					dropdown.classList.add('active');
				});
		}

		input.addEventListener('input', function() {
			clearTimeout(timer);
			var query = input.value.trim();

			if (query.length < 2) {
				closeDropdown();
				return;
			}

			timer = setTimeout(function() {
				lastQuery = query;
				runSearch(query);
			}, 350);
		});

		input.addEventListener('focus', function() {
			if (dropdown.innerHTML.trim() !== '' && input.value.trim().length >= 2) {
				dropdown.classList.add('active');
			}
		});

		btn.addEventListener('click', function() {
			var query = input.value.trim();
			if (query.length >= 2) {
				runSearch(query);
			}
		});

		document.addEventListener('click', function(e) {
			if (!wrap.contains(e.target)) {
				closeDropdown();
			}
		});

		dropdown.addEventListener('click', function(e) {
			var btn = e.target.closest('.search-item-basket-btn');
			if (!btn) return;
			e.preventDefault();
			var id = btn.dataset.id;
			if (typeof add2basket === 'function') {
				add2basket(id);
			} else {
				console.warn('Функция add2basket не найдена');
			}
		});
	})();
</script>