<?php
namespace Local;
AddEventHandler("main", "OnAfterUserRegister", function(&$arFields){

    if (!empty($arFields["USER_ID"]) && !empty($arFields["EMAIL"])) {

        // сохраняем email текущей регистрации
        $_SESSION["REG_EMAIL"] = $arFields["EMAIL"];
        $_SESSION["REG_USER_ID"] = $arFields["USER_ID"];
    }

});

AddEventHandler("main", "OnBeforeUserRegister", function(&$arFields){
    // Генерируем пароль с соблюдением всех требований
    $password = generateStrongPassword();
    $arFields['PASSWORD'] = $password;
    $arFields['CONFIRM_PASSWORD'] = $password;

    // Сохраняем пароль для письма
    $_SESSION['REG_PASSWORD'] = $password;
});

function generateStrongPassword($length = 10) {
    // Определяем отдельные наборы символов
    $sets = [
        'lower' => 'abcdefghijklmnopqrstuvwxyz',
        'upper' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 
        'digit' => '0123456789',
        'special' => '!@#$%^&*()_+-='
    ];
    
    // Все символы для заполнения
    $allChars = $sets['lower'] . $sets['upper'] . $sets['digit'] . $sets['special'];
    
    // Гарантируем наличие каждого типа
    $password = '';
    $password .= $sets['lower'][random_int(0, strlen($sets['lower']) - 1)];
    $password .= $sets['upper'][random_int(0, strlen($sets['upper']) - 1)];
    $password .= $sets['digit'][random_int(0, strlen($sets['digit']) - 1)];
    $password .= $sets['special'][random_int(0, strlen($sets['special']) - 1)];
    
    // Добавляем остальные символы
    for ($i = 4; $i < $length; $i++) {
        $password .= $allChars[random_int(0, strlen($allChars) - 1)];
    }
    
    // Перемешиваем для случайного порядка
    $chars = str_split($password);
    shuffle($chars);
    
    return implode('', $chars);
}

AddEventHandler("main", "OnBeforeEventAdd", function($event, $lid, &$arFields) {
    if (in_array($event, ["NEW_USER_CONFIRM", "NEW_USER"])) {
        if (!empty($_SESSION['REG_PASSWORD'])) {
            $arFields['REG_PASSWORD'] = $_SESSION['REG_PASSWORD'];
        }
    }
});


//Регистрируем обработчик
AddEventHandler("iblock", "OnBeforeIBlockPropertyUpdate", "addXmlIdToPropertyEnum");

/**
 * Генерируем XML_ID из значения свойства, для корректного ЧПУ
 * @param $arFields
 */
function addXmlIdToPropertyEnum(&$arFields)
{
    //Параметры трнаслитерации
    $arTranslitParams = array("replace_space" => "-", "replace_other" => "-");

    //Проверяем тип свойства (L - список, list)
    if ($arFields['PROPERTY_TYPE'] == 'L') {
        //Перебираем значения свойства
        foreach ($arFields['VALUES'] as $valueIndex => $arValue) {
            if (empty($arValue['XML_ID'])) {
                //Если XML_ID значения свойства пуст, формируем его и записываем в массив $arFields
                $xmlId = Cutil::translit($arValue['VALUE'],'ru', $arTranslitParams);
                $arFields['VALUES'][$valueIndex]['XML_ID'] = $xmlId;
            }
        }
    }
}

use Bitrix\Main\EventManager;
//добавляем пароль в почтовой шаблон
EventManager::getInstance()->addEventHandlerCompatible(
	'main',
	'OnBeforeUserChangePassword',
	['\Local\SendPassword', 'onBeforeUserChangePassword']
);

EventManager::getInstance()->addEventHandlerCompatible(
	'main',
	'OnBeforeEventAdd',
	['\Local\SendPassword', 'onBeforeEventAdd']
);



class SendPassword
{
	private static $password;

	public static function onBeforeUserChangePassword($arParams)
	{
		self::$password = $arParams['PASSWORD'];
	}

	public static function onBeforeEventAdd(&$event, &$lid, &$arFields, &$message_id, &$files)
	{
		if ($event === 'USER_PASS_CHANGED') {
			$arFields['PASSWORD'] = self::$password;
		}
	}
}

