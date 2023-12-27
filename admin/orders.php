<?php
session_start();
include '../config/connect.php';

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM orders WHERE id = $id");
    if ($result) {
        
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
            <h2>Orders</h2>
            <div class="menu">
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
                            <th>UID</th>
                            <th>Email</th>
                            <th>Game</th>
                            <th>Item</th>
                            <th>E-Wallet</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $orders = mysqli_query($conn, "SELECT od.*, g.name AS game_name, c.amount AS cred_amount, c.price AS cred_price, e.name AS ewallet FROM orders od JOIN games g ON od.game_id = g.id JOIN game_credits c ON od.game_credits_id = c.id JOIN ewallets e ON od.ewallet_id = e.id");
                        while ($order = mysqli_fetch_assoc($orders)) {
                            echo "
                            <tr>
                                <td>$no</td>
                                <td>{$order['userid']}</td>
                                <td>{$order['email']}</td>
                                <td>{$order['game_name']}</td>
                                <td>{$order['cred_amount']} | {$order['cred_price']}</td>
                                <td>{$order['ewallet']}</td>
                                <td>
                                    <a href='orders_u.php?id={$order['id']}'><i class='fas fa-edit'></i></a>
                                    <a href='?id={$order['id']}'><i class='fas fa-trash'></i></a>
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
                url: "order_s.php",
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