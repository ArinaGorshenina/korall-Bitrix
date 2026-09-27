<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");
?>
 <div class="cart error-str">
        <div class="container">
            <div class="container-cart container-cart-empty">
                    <p class="cart-empty    Unbounded">
                    Ошибка
                    </p>
                    <p class="cart-empty-desc">кажется страница не найдена</p>
                    <a href="/" class="header-btn btn-empty-cart">Главная <img
                            src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cart/arrow-right.svg" alt="arrow-right"></a>
            </div>
        </div>
    </div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>