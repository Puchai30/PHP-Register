<?php

include("vendor/autoload.php");

use Helpers\Auth;

$auth = Auth::check();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-5">
            <?= $auth->name ?>
            <span class="fw-normal text-muted">
                (<?= $auth->role ?>)
            </span>
        </h1>

        <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-warning">
            Cannot upload file
        </div>
        <?php endif ?>

        <?php if($auth->photo): ?>
        <img class="img-thumbnail mb-3" src="actions/photos/<?= $auth->photo ?>" alt="Profile Photo" width="200">
        <?php endif ?>

        <form action="actions/upload.php" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <input type="file" name="photo" class="form-control">
                <button class="btn btn-secondary">Upload</button>
            </div>
        </form>

        <ul class="list-group">
            <li class="list-group-item">
                <b>Email:</b> <?= $auth->email ?>
            </li>
            <li class="list-group-item">
                <b>Phone:</b> <?= $auth->phone ?>
            </li>
            <li class="list-group-item">
                <b>Address:</b> <?= $auth->address ?>
            </li>
        </ul>
        <br>

        <a href="admin.php" class="btn btn-primary">
            <i class="fas fa-users"></i> Manage Users
        </a> |
        <a href="actions/logout.php" class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

    </div>
</body>

</html>