PHP
<?php
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP; // Assuming HTTP helper for redirection

$data = [
    "id" => $_POST['id'],
    "name" => $_POST['name'] ?? 'Unknown',
    "email" => $_POST['email'] ?? 'Unknown',
    "phone" => $_POST['phone'] ?? 'Unknown',
    "address" => $_POST['address'] ?? 'Unknown',
    "password" => md5($_POST['password']), // Ensure no extra space
    "role_id" => 1,
];

// Database connection and update
$table = new UsersTable(new MySQL());

if( $table ) {
    $success = $table->update($data);
    HTTP::redirect("/admin.php", "updated=true");
} else {

}

// 