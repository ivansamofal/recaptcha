<script src='https://www.google.com/recaptcha/api.js'></script>
<?
$login = md5('admin'); // в рабочем случае получаем логин и пароль из БД
$password = md5('111111');

$url = 'https://www.google.com/recaptcha/api/siteverify';
$secret = '6LeAlSgUAAAAAMDmccjbqPdcUcw7iJYPvO-iStdf';
$response = $_POST["g-recaptcha-response"];
$remoteip = $_SERVER['REMOTE_ADDR'];
$url = $url . '?secret=' . $secret . '&response=' . $response . '&remoteip=' . $remoteip;

$data = file_get_contents($url);

function isAuthorized($login, $password, $loginEnter, $passwordEnter){
	return $login === $loginEnter && $password === $passwordEnter;
}
if( $_POST['login'] ){
	$loginEnter = md5(htmlspecialchars(trim($_POST['login'])));
	$passwordEnter = md5(htmlspecialchars(trim($_POST['password'])));
}





	if ( json_decode($data)->success && isAuthorized($login, $password, $loginEnter, $passwordEnter) ):?>
		<h2>Вы авторизованы:)<h2>
	<?else:?>
		<form method="post">
			<input type="text" name="login"/>
			<input type="password" name="password"/>
			<div class="g-recaptcha" data-sitekey="6LeAlSgUAAAAAFfFnPesqTdZSLu747ibGOGQ84Dm"></div>
			<input type="submit" />
		</form>
	<?endif;?>
