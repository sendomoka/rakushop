<?php
session_start();
include '../config/connect.php';

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM games WHERE id = $id");
    if ($result) {
        $game = mysqli_fetch_assoc($result);
        $oldCoverPath = '../assets/images/games/' . $game['cover'];
        if (file_exists($oldCoverPath)) {
            unlink($oldCoverPath);
        }
        $deleteQuery = "DELETE FROM games WHERE id = $id";
        $deleteResult = mysqli_query($conn, $deleteQuery);
        if ($deleteResult) {
            header("Location: games.php");
            exit();
        } else {
            echo "Gagal menghapus data game.";
        }
    } else {
        echo "Data game tidak ditemukan.";
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
    <title><?= $title ?> | Rakushop Indonesia</title>
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
                </a>';
            }
            ?>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
        <div class="right">
            <h2>Games</h2>
            <div class="menu">
                <a class="plus" href="games_i.php">
                    <i class="fas fa-plus"></i>
                    Add New Game
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
                            <th>Cover</th>
                            <th>Name</th>
                            <th>Credit Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $games = mysqli_query($conn, "SELECT * FROM games");
                        while ($game = mysqli_fetch_assoc($games)) {
                            echo "
                            <tr>
                                <td>$no</td>
                                <td><img src='../assets/images/games/{$game['cover']}' alt='cover'></td>
                                <td>{$game['name']}</td>
                                <td>{$game['credit_name']}</td>
                                <td>
                                    <a href='games_u.php?id={$game['id']}'><i class='fas fa-edit'></i></a>
                                    <a href='?id={$game['id']}'><i class='fas fa-trash'></i></a>
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
                url: "game_s.php",
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