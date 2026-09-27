<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


$APPLICATION->SetTitle("Восстановление пароля");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.auth.changepasswd",
	"ChangePass",
	Array(
	 "SHOW_ERRORS" => "Y" ,
		"AUTH_AUTH_URL" => "",
		"AUTH_REGISTER_URL" => "",
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>