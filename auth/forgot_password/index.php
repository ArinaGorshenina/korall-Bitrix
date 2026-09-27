<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


$APPLICATION->SetTitle("Восстановление пароля");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.auth.forgotpasswd",
	"ForgotPassword",
	Array(
		 "SHOW_ERRORS" => "Y" ,
		"AUTH_AUTH_URL" => "",
		"AUTH_REGISTER_URL" => "",
		  "AUTH_RESULT" => $APPLICATION->arAuthResult,
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>