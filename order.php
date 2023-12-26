<?php
session_start();
include 'config/connect.php';

if(isset($_GET['id'])){
    $order_id = $_GET['id'];
    $sqlo = "SELECT orders.*, games.name AS game_name, games.credit_name, ewallets.name AS ewallet_name, ewallets.image AS ewallet_image, game_credits.amount, game_credits.price 
            FROM orders 
            INNER JOIN games ON orders.game_id = games.id 
            INNER JOIN ewallets ON orders.ewallet_id = ewallets.id 
            INNER JOIN game_credits ON orders.game_credits_id = game_credits.id
            WHERE orders.id = $order_id";
    $result = mysqli_query($conn, $sqlo);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    } else {
        header("Location: game.php?id=$row[game_id]");
        exit();
    }
} else {
    header("Location: game.php?id=$row[game_id]");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order of <?= $row['userid'] ?> | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/order.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'components/header_order.php' ?>
    <main>
        <div class="detail">
        <h2>Order Detail</h2>
        <table>
            <tr>
                <td>Order ID:</td>
                <td><?= $row['id'] ?></td>
            </tr>
            <tr>
                <td>Game:</td>
                <td><?= $row['game_name'] ?></td>
            </tr>
            <tr>
                <td>E-Wallet:</td>
                <td><?= $row['ewallet_name'] ?></td>
            </tr>
            <tr>
                <td>UID:</td>
                <td><?= $row['userid'] ?> - <?= $row['server'] ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?= $row['email'] ?></td>
            </tr>
            <tr>
                <td>Amount:</td>
                <td><?= $row['amount'] ?> <?= $row['credit_name'] ?></td>
            </tr>
            <tr>
                <td>Price:</td>
                <td id="price">Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
        </table>
        <a href="payment.php?id=<?= $row['id'] ?>">Selanjutnya</a>
        </div>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="search.js"></script>
</html>