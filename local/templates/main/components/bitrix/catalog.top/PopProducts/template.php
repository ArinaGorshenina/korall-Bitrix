<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogTopComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

// Получаем общее количество товаров для пагинации
$totalItems = $arResult['NAV_RESULT'] ? $arResult['NAV_RESULT']->NavRecordCount : count($arResult['ITEMS']);
$itemsPerPage = intval($arParams['ELEMENT_COUNT']) ?: 8;
$totalPages = ceil($totalItems / $itemsPerPage);

// Текущая страница
$currentPage = 1;
if (isset($_REQUEST['PAGEN_1']) && intval($_REQUEST['PAGEN_1']) > 0) {
    $currentPage = intval($_REQUEST['PAGEN_1']);
}
?>


        <div class="minicatalog-popul-items" data-current-page="<?=$currentPage?>" data-total-pages="<?=$totalPages?>">
            
            <?php if (empty($arResult['ITEMS'])): ?>
                <p style="text-align:center;padding:40px 0;color:#999;width:100%;">Популярные товары временно отсутствуют</p>
            <?php else: ?>
                
                <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                    <?php
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));
                    
                    // Получаем цену
                    $priceValue = 0;
                    if (!empty($arItem["MIN_PRICE"]) && is_array($arItem["MIN_PRICE"])) {
                        $priceValue = $arItem["MIN_PRICE"]["VALUE"] ?? $arItem["MIN_PRICE"]["PRICE"] ?? 0;
                    } elseif (!empty($arItem["PRICES"]) && is_array($arItem["PRICES"])) {
                        $price = reset($arItem["PRICES"]);
                        $priceValue = is_array($price) ? ($price["VALUE"] ?? $price["PRICE"] ?? 0) : ($price ?? 0);
                    } elseif (!empty($arItem["ITEM_PRICES"]) && is_array($arItem["ITEM_PRICES"])) {
                        $price = reset($arItem["ITEM_PRICES"]);
                        $priceValue = is_array($price) ? ($price["VALUE"] ?? $price["PRICE"] ?? 0) : ($price ?? 0);
                    } elseif (!empty($arItem["PRICE"])) {
                        $priceValue = $arItem["PRICE"];
                    }
                    
                    $priceFormatted = number_format($priceValue, 2, '.', ' ');
                    
                    // Формируем URL
                    $detailUrl = $arItem["DETAIL_PAGE_URL"] ?? "";
                    if (empty($detailUrl)) {
                        $sectionCode = $arItem["SECTION"]["CODE"] ?? "";
                        $elementCode = $arItem["CODE"] ?? "";
                        if (!empty($sectionCode) && !empty($elementCode)) {
                            $detailUrl = "/catalog/" . $sectionCode . "/" . $elementCode . "/";
                        } else {
                            $detailUrl = "#";
                        }
                    }
                    
                    // Получаем картинку
                    $imgSrc = SITE_TEMPLATE_PATH . "/assets/images/no-image.png";
                    if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
                        $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
                    } elseif (!empty($arItem["DETAIL_PICTURE"]["SRC"])) {
                        $imgSrc = $arItem["DETAIL_PICTURE"]["SRC"];
                    } elseif (!empty($arItem["PREVIEW_PICTURE"])) {
                        $imgSrc = CFile::GetPath($arItem["PREVIEW_PICTURE"]);
                    } elseif (!empty($arItem["DETAIL_PICTURE"])) {
                        $imgSrc = CFile::GetPath($arItem["DETAIL_PICTURE"]);
                    }
                    
                    $name = $arItem["NAME"];
                    ?>
                    
                    <div class="minicatalog-popul-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-id="<?=$arItem['ID']?>">
                        <a href="<?=$detailUrl?>" class="popul-item-img-box">
                            <img src="<?=$imgSrc?>" alt="<?=$name?>">
                        </a>
                        <div class="popul-desc-box">
                            <p class="popul-price"><?=$priceFormatted?> ₽</p>
                            <p class="popul-desc"><?=$name?></p>
                        </div>
                    </div>
                    
                <?php endforeach; ?>
                
            <?php endif; ?>
            
        </div>
        
        <!-- Пагинация (точки) -->
   
            <div class="popul-pages" data-total-pages="<?=$totalPages?>" data-current-page="<?=$currentPage?>">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <div class="popul-pag <?=($i == $currentPage ? 'active' : '')?>" data-page="<?=$i?>"></div>
                <?php endfor; ?>
            </div>

        
    </div>
</div>

<script>
// Инициализация слайдера популярных товаров
document.addEventListener('DOMContentLoaded', function () {
    initPopularSlider();
});

function initPopularSlider() {
    const slider = document.querySelector('.minicatalog-popul-items');
    if (!slider) return;
    
    const items = slider.querySelectorAll('.minicatalog-popul-item');
    const dots = document.querySelectorAll('.popul-pag');
    
    if (!items.length || !dots.length) return;
    
    let currentIndex = 0;
    let startX = 0;
    let endX = 0;
    let isDragging = false;
    let isTransitioning = false;
    
    // Получаем количество видимых элементов
    const visibleItems = parseInt(getComputedStyle(slider).getPropertyValue('grid-template-columns').split(' ').length) || 4;
    const totalPages = Math.ceil(items.length / visibleItems);
    
    // Обновляем точки в соответствии с реальным количеством страниц
    if (dots.length !== totalPages) {
        // Если количество точек не совпадает, обновляем
        const dotsContainer = document.querySelector('.popul-pages');
        if (dotsContainer) {
            dotsContainer.innerHTML = '';
            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement('div');
                dot.className = 'popul-pag' + (i === 0 ? ' active' : '');
                dot.dataset.page = i + 1;
                dotsContainer.appendChild(dot);
            }
        }
    }
    
    // Обновляем ссылки на точки
    const updatedDots = document.querySelectorAll('.popul-pag');
    
    // Функция перехода к слайду
    function goToSlide(index) {
        if (isTransitioning) return;
        
        if (index < 0) index = 0;
        if (index >= totalPages) index = totalPages - 1;
        
        isTransitioning = true;
        currentIndex = index;
        
        const itemWidth = items[0]?.offsetWidth + 20 || 200;
        const scrollPosition = itemWidth * currentIndex * visibleItems;
        
        slider.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
        
        updateDots();
        
        setTimeout(() => {
            isTransitioning = false;
        }, 500);
    }
    
    // Обновление точек
    function updateDots() {
        const currentDots = document.querySelectorAll('.popul-pag');
        currentDots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
        });
    }
    
    // Обработчик клика по точкам
    updatedDots.forEach((dot, index) => {
        dot.addEventListener('click', function(e) {
            e.preventDefault();
            const page = parseInt(this.dataset.page) || index + 1;
            goToSlide(page - 1);
        });
    });
    
    // Touch события для свайпа
    slider.addEventListener('touchstart', function(e) {
        if (e.touches.length === 1) {
            isDragging = true;
            startX = e.touches[0].clientX;
        }
    }, { passive: true });
    
    slider.addEventListener('touchmove', function(e) {
        if (!isDragging) return;
        endX = e.touches[0].clientX;
    }, { passive: true });
    
    slider.addEventListener('touchend', function() {
        if (!isDragging) return;
        
        const diff = startX - endX;
        const threshold = 50;
        
        if (diff > threshold) {
            goToSlide(currentIndex + 1);
        } else if (diff < -threshold) {
            goToSlide(currentIndex - 1);
        }
        
        isDragging = false;
        startX = 0;
        endX = 0;
    }, { passive: true });
    
    // Mouse события для десктопа (drag)
    let mouseDown = false;
    let mouseStartX = 0;
    let mouseEndX = 0;
    
    slider.addEventListener('mousedown', function(e) {
        mouseDown = true;
        mouseStartX = e.clientX;
        slider.style.cursor = 'grabbing';
    });
    
    slider.addEventListener('mousemove', function(e) {
        if (!mouseDown) return;
        mouseEndX = e.clientX;
    });
    
    slider.addEventListener('mouseup', function() {
        if (!mouseDown) return;
        
        const diff = mouseStartX - mouseEndX;
        const threshold = 50;
        
        if (diff > threshold) {
            goToSlide(currentIndex + 1);
        } else if (diff < -threshold) {
            goToSlide(currentIndex - 1);
        }
        
        mouseDown = false;
        mouseStartX = 0;
        mouseEndX = 0;
        slider.style.cursor = 'grab';
    });
    
    slider.addEventListener('mouseleave', function() {
        if (mouseDown) {
            mouseDown = false;
            slider.style.cursor = 'grab';
        }
    });
    
    // Обновление при ресайзе
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            const newVisibleItems = parseInt(getComputedStyle(slider).getPropertyValue('grid-template-columns').split(' ').length) || 4;
            const newTotalPages = Math.ceil(items.length / newVisibleItems);
            
            // Обновляем точки если нужно
            const dotsContainer = document.querySelector('.popul-pages');
            if (dotsContainer && dotsContainer.children.length !== newTotalPages) {
                dotsContainer.innerHTML = '';
                for (let i = 0; i < newTotalPages; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'popul-pag' + (i === 0 ? ' active' : '');
                    dot.dataset.page = i + 1;
                    dotsContainer.appendChild(dot);
                }
                // Переинициализируем точки
                const newDots = document.querySelectorAll('.popul-pag');
                newDots.forEach((dot, index) => {
                    dot.addEventListener('click', function() {
                        goToSlide(index);
                    });
                });
            }
        }, 300);
    });
    
    // Инициализация: устанавливаем первую страницу
    goToSlide(0);
}

// Поддержка AJAX-загрузки
if (window.BX && BX.ready) {
    BX.ready(function() {
        // Если компонент обновился через AJAX, переинициализируем
        setTimeout(initPopularSlider, 100);
    });
}
</script>