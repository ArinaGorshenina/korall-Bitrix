<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>

   <div class="cart">
        <div class="container">
            <h2 class="Unbounded">Корзина</h2>
            <div class="container-cart container-cart-empty">
                    <p class="cart-empty    Unbounded">
                     <?=Loc::getMessage("SBB_EMPTY_BASKET_TITLE")?>
                    </p>
                    <p class="cart-empty-desc">добавьте что-нибудь из каталога</p>
                    <a href="/catalog/" class="header-btn btn-empty-cart">Перейти в каталог <img
                            src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cart/arrow-right.svg" alt="arrow-right"></a>
            </div>
        </div>
    </div>