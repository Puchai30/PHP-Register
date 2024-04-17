<?php
include("vendor/autoload.php");
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;

$table = new UsersTable(new MySQL());
$all = $table->getAll();
$auth = Auth::check();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>Manage Users</title>
</head>

<body>
    <div class="container">
        <div style="float: right">
            <a href="profile.php" class="btn btn-sm btn-outline-success"><i class="bi bi-people-fill"></i></a>
            <a href="actions/logout.php" class="btn btn-sm btn-outline-danger"> <i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <h1 class="mt-5 mb-5">
            Manage Users
            <span class="badge bg-danger text-white"><?= count($all) ?></span>
        </h1>

        <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">
            Account updated. Please login.
        </div>
        <?php endif ?>

        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($all as $user): ?>

            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->name ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->phone ?></td>

                <td>
                    <?php if($user->value === 1): ?>
                    <span class="badge bg-secondary"><?= $user->role ?></span>
                    <?php elseif($user->value === 2): ?>
                    <span class="badge bg-primary"><?= $user->role ?></span>
                    <?php elseif($user->value === 3): ?>
                    <span class="badge bg-success"><?= $user->role ?></span>
                    <?php endif ?>
                </td>

                <td>
                    <div class="btn-group dropdown">
                        <a href="#" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                            Change Role
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark">
                            <a href="actions/role.php?id=<?= $user->id ?>&role=1" class="dropdown-item">User</a>
                            <a href="actions/role.php?id=<?= $user->id ?>&role=2" class="dropdown-item">Admin</a>
                            <a href="actions/role.php?id=<?= $user->id ?>&role=3" class="dropdown-item">Manager</a>
                        </div>
                    </div>

                    <?php if($user->suspended): ?>
                    <a href="actions/unsuspend.php?id=<?= $user->id ?>" class="btn btn-sm btn-danger"><i
                            class="bi bi-person-dash"></i>Suspended</a>
                    <?php else: ?>
                    <a href="actions/suspend.php?id=<?= $user->id ?>" class="btn btn-sm btn-outline-success "><i
                            class="bi bi-person-check"></i>Active</a>
                    <?php endif ?>

                    <!-- Edit Button -->
                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                        data-bs-target="#exampleModal<?= $user->id ?>" data-bs-whatever="@mdo">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <!-- Delete Button -->
                    <a href="actions/delete.php?id=<?= $user->id ?>" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Are you sure?')"><i class="bi bi-trash2-fill"></i></a>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="exampleModal<?= $user->id ?>"
                aria-labelledby="exampleModalLabel<?= $user->id ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="actions/update.php" method="post">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($user->id) ?>">
                                <div class="col-12">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
                                                <path
                                                    d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
                                                <path
                                                    d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96c.026-.163.04-.33.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1.006 1.006 0 0 1 1 12z" />
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" name="name"
                                            value="<?= htmlspecialchars($user->name) ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                            </svg>
                                        </span>
                                        <input type="email" class="form-control" name="email"
                                            value="<?= htmlspecialchars($user->email) ?>" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="phone" class="form-label">Phone <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg aria-hidden="true" focusable="false" class="icon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1em"
                                                height="1em">
                                                <!-- Font Awesome Free 5.15.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                                                <path
                                                    d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z" />
                                            </svg>
                                            </svg>
                                        </span>
                                        <input type="tel" class="form-control" name="phone"
                                            value="<?= htmlspecialchars($user->phone) ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </table>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>