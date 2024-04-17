<?php

session_start();
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$email = $_POST['email'];
$password = md5( $_POST['password'] );
    
$table = new UsersTable(new MySQL());

$user = $table->findByEmailAndPasword($email, $password);
if ($user) {
if($_SESSION['user'] = $user) {
    HTTP::redirect("/profile.php");
}{
    if($table->suspended($user->id)) {
        HTTP::redirect("/index.php", "suspended=1");
        }
}

} else {
HTTP::redirect("/index.php", "incorrect=1");
}