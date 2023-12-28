<?php
session_start();
include '../config/connect.php';

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $userid = $_POST['userid'];
    $email = $_POST['email'];
    $game = $_POST['games'];
    $credit = $_POST['game_credits'];
    $ewallet = $_POST['ewallets'];
    $updated_at = $_POST['updated_at'];
    $sql = "UPDATE orders SET userid='$userid', email='$email', game_id='$game', game_credits_id='$credit', ewallet_id='$ewallet', updated_at='$updated_at' WHERE id=$id";
    $query = mysqli_query($conn, $sql);
    if($query){
        header("Location: orders.php");
        exit();
    } else {
        echo "<script>alert('Update failed!')</script>";
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM orders WHERE id=$id");
    $data = mysqli_fetch_assoc($query);
    if(!$data){
        header("Location: orders.php");
        exit();
    }
} else {
    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="../assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/a_insert.css">
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
            <a href="banners.php">
                <i class="fas fa-image"></i>
                Banners
            </a>
            <a href="orders.php">
                <i class="fas fa-gamepad"></i>
                Games
            </a>
            <a href="orders.php">
                <i class="fas fa-wallet"></i>
                E-Wallets
            </a>
            <a href="orders.php" class="active">
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
            <h2>Order Update</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                <table>
                    <tr>
                        <td>User ID</td>
                        <td>:</td>
                        <td><input type="text" name="userid" value="<?= $data['userid'] ?>" required></td>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><input type="email" name="email" value="<?= $data['email'] ?>" required></td>
                    </tr>
                    <tr>
                        <td>Game</td>
                        <td>:</td>
                        <td>
                            <select name="games" required>
                                <option value="" disabled>Pilih Game</option>
                                <?php
                                $queryg = mysqli_query($conn, "SELECT * FROM games");
                                while ($game_data = mysqli_fetch_array($queryg)) {
                                    $selected = ($data['game_id'] == $game_data['id']) ? 'selected' : '';
                                    echo "<option value='$game_data[id]' $selected>$game_data[name]</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Item</td>
                        <td>:</td>
                        <td>
                            <select name="game_credits" required>
                                <option value="" disabled>Pilih Item</option>
                                <?php
                                $queryc = mysqli_query($conn, "SELECT * FROM game_credits");
                                while ($credit_data = mysqli_fetch_array($queryc)) {
                                    $selected = ($data['game_credits_id'] == $credit_data['id']) ? 'selected' : '';
                                    echo "<option value='$credit_data[id]' $selected>$credit_data[amount] | $credit_data[price]</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>E-Wallet</td>
                        <td>:</td>
                        <td>
                            <select name="ewallets" required>
                                <option value="" disabled>Pilih E-Wallet</option>
                                <?php
                                $querye = mysqli_query($conn, "SELECT * FROM ewallets");
                                while ($ewallet_data = mysqli_fetch_array($querye)) {
                                    $selected = ($data['ewallet_id'] == $ewallet_data['id']) ? 'selected' : '';
                                    echo "<option value='$ewallet_data[id]' $selected>$ewallet_data[name]</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="submit" value="Update"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
    <?php include '../components/admin_footer.php' ?>
</body>
</html>