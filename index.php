<?php 
require  "vendor/autoload.php";
// composer download

$client_id = "554534633479-ig44q092oa2epbijidj45n97igjcj0h4.apps.googleusercontent.com"; 
$client_secret = 'Fr6kE10yifg7xzLVDkJGKJKC';
$redirect_uri = 'http://thanhtai.com:88/gg/index.php'; // url redirect (config console.gooogle)
$db_username = "root"; //Database Username
$db_password = ""; //Database Password
$host_name = "localhost"; //Mysql Hostname
$db_name = 'gg'; //database name
$client = new Google_Client(); 
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
$service = new Google_Service_Oauth2($client);
if (isset($_GET['code'])){
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	$user = $service->userinfo->get();
	$mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
	if($mysqli->connect_error){
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
	$result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id=$user->id");
	$user_count = $result->fetch_object()->usercount;
	echo '<img src="'.$user->picture.'" style="float: right;margin-top: 33px;width:100px;" />';

	if($user_count) // Nếu usered show info
	{
		echo 'Welcome back '.$user->name.'! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
	}
	else //else create one user in database
	{ 
		echo 'Hi '.$user->name.', Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
		$statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link,google_picture_link) VALUES (?,?,?,?,?)");
		$statement->bind_param('issss',$user->id,$user->name, $user->email, $user->link, $user->picture);
		$statement->execute();
		echo $mysqli->error;
	}
	exit;
}
// create session login
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
	} 
	else { // eles create link login
		$authUrl = $client->createAuthUrl();
	}
	echo '<div style="margin:20px">';
	if (isset($authUrl)){ 
		echo '<div align="center">';
		echo '<h3>Login with Google -- Demo</h3>';
		echo '<div>Please click login button to connect to Google.</div>';
		echo '<a class="login" href="' . $authUrl . '">LOGIN</a>';
		echo '</div>';
	} 
	echo '</div>';
	?>