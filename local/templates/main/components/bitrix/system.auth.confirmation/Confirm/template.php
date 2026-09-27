<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER, $APPLICATION;

// Получаем email
$userEmail = '';

$userEmail = trim($_POST['login_email']  ??  '');
$userEmailCheck = trim($_SESSION['REG_EMAIL'] ??  '');

$success = false;
$error = '';
$userActive = false;

// Проверяем, нет ли уже активного пользователя с таким email
if (!empty($userEmailCheck) && !$USER->IsAuthorized()) {
    $rsUserCheck = CUser::GetList(
        ($by = "ID"),
        ($order = "ASC"),
        [
            "LOGIC" => "OR",
            "=LOGIN" => $userEmailCheck,
            "=EMAIL" => $userEmailCheck,
            "ACTIVE" => "Y"
        ]
    );

    if ($userCheck = $rsUserCheck->Fetch()) {
        $userActive = true;
        $error = "Пользователь с email " . htmlspecialchars($userEmailCheck) . " уже активирован. Пожалуйста, авторизуйтесь.";
    }
}

// Обработка POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$userActive) {
    $email = trim($_POST['login_email'] ?? '');
    $code  = trim($_POST['confirm_code'] ?? '');

    if (!$email || !$code) {
        $error = "Введите код подтверждения";
    } else {
        // Ищем пользователя по email или логину
        $rsUser = CUser::GetList(
            ($by = "ID"),
            ($order = "ASC"),
            [
                "LOGIC" => "OR",
                "=LOGIN" => $email,
                "=EMAIL" => $email
            ]
        );

        if ($user = $rsUser->Fetch()) {

            if ($user["ACTIVE"] === "Y") {
                $error = "Пользователь с email " . htmlspecialchars($email) . " уже активирован. Пожалуйста, авторизуйтесь.";
                $userActive = true;
            } else {
                // Проверяем стандартный CONFIRM_CODE
                if (!empty($user['CONFIRM_CODE']) && $user['CONFIRM_CODE'] === $code) {
                    // Активируем пользователя
                    $userObj = new CUser;
                    $updateFields = ["ACTIVE" => "Y"];
                    $result = $userObj->Update($user["ID"], $updateFields);

                    if ($result) {
                        unset($_SESSION['REG_EMAIL']);
                        unset($_SESSION['REG_USER_ID']);
                        unset($_SESSION['REG_PASSWORD']);

                        $USER->Authorize($user["ID"]);
                        $success = true;
                    } else {
                        $error = "Ошибка активации: " . $userObj->LAST_ERROR;
                    }
                } else {
                    $error = "Неверный код подтверждения";
                }
            }
        } else {
            $error = "Пользователь с email " . htmlspecialchars($email) . " не найден";
        }
    }
}
?>

<?php if ($success || $USER->IsAuthorized()): ?>
    
    <div class="confirm-success">
        <div class="success-message">✓ Регистрация успешно подтверждена!</div>
        <p>Добро пожаловать на сайт!</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.reload();
        }, 2000);
    </script>
<?php else: ?>
    <form method="post" action="<?= $APPLICATION->GetCurPage() ?>" class="user-drawer-form active" id="confirm-form">
        <?php if ($error): ?>
            <div class="auth-error-message" style="margin-bottom:15px;padding:10px;background:#ffe6e6;border-radius:5px;">
                <?=htmlspecialchars($error)  ?>
            </div>
        <?php endif; ?>

        <?php if (!$userActive): ?>
            <?= bitrix_sessid_post() ?>

            <input type="hidden" name="login_email" value="<?= htmlspecialcharsbx($userEmail) ?>">

            <div class="form-gap">
                <input type="text" name="confirm_code" placeholder="Введите код из письма" pattern="[A-Za-z0-9]+"
                    title="Только английские буквы и цифры" maxlength="8" autocomplete="off" required>
                <p class="error-text"></p>
            </div>

            <button type="submit" class="header-btn btn-user-drawer Manrope btn-user-CODE">
                Завершить регистрацию
            </button>
        <?php endif; ?>
    </form>
<?php endif; ?>