<?php
session_start();
include '../config/connect.php';

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
    if ($result) {
        $user = mysqli_fetch_assoc($result);
        $deleteQuery = "DELETE FROM users WHERE id = $id";
        $deleteResult = mysqli_query($conn, $deleteQuery);
        if ($deleteResult) {
            header("Location: users.php");
            exit();
        } else {
            echo "Gagal menghapus data user.";
        }
    } else {
        echo "Data user tidak ditemukan.";
    }
}

$current_page = basename($_SERVER['PHP_SELF']);
$current_page = str_replace('.php', '', $current_page);
$title = ucwords(str_replace('_', ' ', $current_page));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="../assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/a_view.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include '../components/admin_header.php' ?>
    <main>
        <div class="left">
            <a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="banners.php" <?= basename($_SERVER['PHP_SELF']) == 'banners.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-image"></i>
                Banners
            </a>
            <a href="games.php" <?= basename($_SERVER['PHP_SELF']) == 'games.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-gamepad"></i>
                Games
            </a>
            <a href="ewallets.php" <?= basename($_SERVER['PHP_SELF']) == 'ewallets.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-wallet"></i>
                E-Wallets
            </a>
            <a href="orders.php" <?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
            <?php
            if($_SESSION['role'] == 'owner'){
                echo '<a href="users.php" '.(basename($_SERVER['PHP_SELF']) == 'users.php' ? 'class="active"' : '').'>
                    <i class="fas fa-users"></i>
                    Users
                </a>
                <a href="mitras.php" '.(basename($_SERVER['PHP_SELF']) == 'mitras.php' ? 'class="active"' : '').'>
                    <i class="fas fa-handshake"></i>
                    Mitras
                </a>';
            }
            ?>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
        <div class="right">
            <h2>Users</h2>
            <div class="menu">
                <a class="plus" href="users_i.php">
                    <i class="fas fa-plus"></i>
                    Add New User
                </a>
                <div class="search">
                    <input id="search" type="text" autocomplete="off">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Update Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $users = mysqli_query($conn, "SELECT * FROM users");
                        while ($user = mysqli_fetch_assoc($users)) {
                            echo "
                            <tr>
                                <td>$no</td>
                                <td>{$user['name']}</td>
                                <td>{$user['email']}</td>
                                <td>{$user['role']}</td>
                                <td>{$user['updated_at']}</td>
                                <td>
                                    <a href='user_u.php?id={$user['id']}'><i class='fas fa-edit'></i></a>
                                    <a href='?id={$user['id']}'><i class='fas fa-trash'></i></a>
                                </td>
                            </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php include '../components/admin_footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#search").on("input", function() {
            var searchText = $(this).val();
            $.ajax({
                type: "POST",
                url: "user_s.php",
                data: { search: searchText },
                success: function(response) {
                    $(".table-container table tbody").html(response);
                }
            });
        });
    });
    </script>
</body>
</html>