<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult["ORDERS"])): ?>

    <div class="orders-list">
        <?php foreach ($arResult["ORDERS"] as $arOrder): ?>
            <?php
            $order = $arOrder["ORDER"];
            ?>
            <div class="order-item">
                <div class="order-info">
                    <div class="order-number">
                        <span class="order-label">Заказ</span>
                        <span class="order-value">№<?= htmlspecialcharsbx($order["ACCOUNT_NUMBER"] ?: $order["ID"]) ?></span>
                    </div>
                    <div class="order-date">
                        <span class="order-label">Дата</span>
                        <span class="order-value"><?= htmlspecialcharsbx($order["DATE_INSERT"]) ?></span>
                    </div>
                    <div class="order-status">
                        <span class="order-label">Статус</span>
                        <span class="order-value status-<?= htmlspecialcharsbx(strtolower($order["STATUS_ID"])) ?>">
                            <?= htmlspecialcharsbx($order["STATUS_ID"]) ?>
                        </span>
                    </div>
                    <div class="order-total">
                        <span class="order-label">Сумма</span>
                        <span class="order-value"><?= number_format($order["PRICE"], 0, '.', ' ') ?> ₽</span>
                    </div>
                </div>
                <div class="order-actions">
                    <a href="<?= htmlspecialcharsbx($order["URL_TO_DETAIL"]) ?>" class="order-detail-link">
                        Подробнее
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($arResult["NAV_STRING"])): ?>
        <div class="orders-pagination">
            <?= $arResult["NAV_STRING"] ?>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="orders-empty">
        <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
            <circle cx="32" cy="32" r="30" stroke="#E0E0E0" stroke-width="2"/>
            <path d="M20 24H44M20 32H44M20 40H32" stroke="#B4B4B4" stroke-width="2" stroke-linecap="round"/>
            <path d="M44 44L48 48M44 48L48 44" stroke="#B4B4B4" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <p class="orders-empty-title">У вас пока нет заказов</p>
        <p class="orders-empty-desc">Перейдите в каталог, чтобы выбрать товары</p>
        <a href="/catalog/" class="header-btn orders-empty-btn">Перейти в каталог</a>
    </div>
<?php endif; ?>