 <?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init();


?>

<?if ($arResult['FORM_TYPE'] == 'login'): ?>
    <form name="system_auth_form<?=$arResult['RND']?>" method="post" target="_top" action="<?=$arResult['AUTH_URL']?>" class="user-drawer-form">
   <?   if ($arResult['SHOW_ERRORS'] === 'Y' && !empty($arResult['ERROR_MESSAGE'])) {
        
        // Функция для получения понятного сообщения об ошибке
        function getUserFriendlyErrorMessage($message) {
            // Если это массив
            if (is_array($message)) {
                $message = implode(' ', $message);
            }
            
            // Получаем чистый текст без HTML
            $cleanMessage = strip_tags($message);
            
            // Проверяем различные варианты ошибок
            $errorMessages = [
                // Русские сообщения
                'Неверный логин или пароль' => 'Неверный email или пароль',
                'Неверный логин' => 'Неверный email или пароль',
                'Invalid login or password' => 'Неверный email или пароль',
                'User not found' => 'Пользователь с таким email не найден',
                'Пользователь не найден' => 'Пользователь с таким email не найден',
            ];
            
            // Ищем соответствие в сообщении
            foreach ($errorMessages as $search => $replace) {
                if (stripos($cleanMessage, $search) !== false) {
                    return $replace;
                }
            }
            
            // Если содержит LOGIN или PASSWORD, заменяем на email
            if (stripos($cleanMessage, 'LOGIN') !== false || stripos($cleanMessage, 'PASSWORD') !== false) {
                return 'Неверный email или пароль';
            }
            
            // Если после всех проверок сообщение не пустое, возвращаем его
            if (!empty($cleanMessage)) {
                return $cleanMessage;
            }
            
            // По умолчанию
            return 'Неверный email или пароль';
        }
        
        $errorMessage = getUserFriendlyErrorMessage($arResult['ERROR_MESSAGE']);
        ?>
        <div class="auth-error-message" >
            <?=htmlspecialcharsbx($errorMessage)?>
        </div>
        <?php
    }?>
    <?if($arResult['BACKURL'] <> ''):?>
            <input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>" />
        <?endif?>
        <?foreach ($arResult['POST'] as $key => $value):?>
            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>
        <input type="hidden" name="AUTH_FORM" value="Y" />
        <input type="hidden" name="TYPE" value="AUTH" />
        
        <div class="form-gap">
            <label>электронная почта</label>
            <input type="email" 
                   name="USER_LOGIN" 
                   maxlength="40"
                   placeholder="Ваша эл. почта" 
                   value="<?=htmlspecialcharsbx($_REQUEST['USER_LOGIN'] ?? '')?>"
                   class="validate-name <?=(!empty($arResult['ERROR_MESSAGE']) ? 'error-input' : '')?>" />
      <p class="error-text"></p>
                </div>
        
        <div class="form-gap">
            <label>пароль</label>
            <div class="password-wrapper">
                <input type="password" 
                       name="USER_PASSWORD" 
                       maxlength="40"
                       placeholder="••••••••" 
                       class="password-input password-main <?=(!empty($arResult['ERROR_MESSAGE']) ? 'error-input' : '')?>" />
                <button type="button" class="toggle-password" aria-label="Показать пароль">
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/form/eye.svg" alt="eye" class="eye-icon">
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/form/eye2.svg" alt="eye" class="eye-off-icon hidden">
                </button>
            </div>
            <p class="error-text"></p>
        </div>
        
        <button type="submit" name="Login" class="header-btn btn-user-drawer Manrope">Войти</button>
        
        <a href="/auth/forgot_password/" class="forget-btn">Забыли пароль?</a>
    </form>
<?else: ?>
    <form action="<?=$arResult['AUTH_URL']?>" method="post" target="_top">
        <?=bitrix_sessid_post()?>
        <input type="hidden" name="logout" value="yes" />
        <div class="form-gap">
            <p>Вы авторизованы как <strong><?=$arResult['USER_NAME']?></strong></p>
        </div>
        <button type="submit" name="logout_butt" class="header-btn btn-user-drawer Manrope">Выйти</button>
    </form>
<?endif?>