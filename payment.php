<?php
session_start();
include 'config/connect.php';

if(isset($_GET['id'])){
    $order_id = $_GET['id'];
    $sqlt = "SELECT transactions.*, orders.userid, ewallets.image AS ewallet_image
            FROM transactions
            INNER JOIN orders ON transactions.order_id = orders.id
            INNER JOIN ewallets ON orders.ewallet_id = ewallets.id
            WHERE transactions.order_id = $order_id";
    $result = mysqli_query($conn, $sqlt);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    } else {
        header("Location: order.php?id=$order_id");
        exit();
    }
} else {
    header("Location: order.php?id=$order_id");
    exit();
}

if (isset($_POST['pay'])) {
    $phone_number = $_POST['phone_number'];
    $pin = $_POST['pin'];
    $correctpin = substr($phone_number, -4);
    if ($pin == $correctpin) {
        $sqlt = "UPDATE transactions SET status = 'success', phone_number = '$phone_number' WHERE order_id = $order_id";
        if (mysqli_query($conn, $sqlt)) {
            echo "<script>alert('Pembayaran berhasil! Silakan cek credit game Anda.');
            window.onload = function() {
                window.location.href = 'index.php';
            };
            </script>";
        } else {
            echo "Error: " . $sqlt . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "<script>
            alert('PIN yang Anda masukkan salah. Silakan coba lagi.');
            window.onload = function() {
                window.location.href = 'payment.php?id=$order_id';
            };
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment of <?= $row['userid'] ?> | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/order.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'components/header_order.php' ?>
    <main>
        <div class="detail">
        <h2 id="payment">Payment Detail</h2>
        <form action="" method="post">
            <table>
                <tr>
                    <td>Transaction ID:</td>
                    <td><?= $row['id'] ?></td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td id="status"><?= $row['status'] ?></td>
                </tr>
                <tr>
                    <td>Transaction Time:</td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
                    <tr>
                        <td>Phone Number:</td>
                        <td>
                            <label id="phone_number_box" for="phone_number">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 36 36" aria-hidden="true" role="img" class="iconify iconify--twemoji" preserveAspectRatio="xMidYMid meet"><path fill="#DC1F26" d="M32 5H4a4 4 0 0 0-4 4v9h36V9a4 4 0 0 0-4-4z"/><path fill="#EEE" d="M36 27a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4v-9h36v9z"/></svg>
                            +62
                            <input type="number" name="phone_number" id="phone_number" placeholder="xxx" required>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>PIN:</td>
                        <td>
                            <label id="pin_box" for="pin">
                            <input type="number" name="pin" id="pin" maxlength="4" autocomplete="off" required>
                            </label>
                        </td>
                    </tr>
            </table>
            <input type="submit" name="pay" value="Bayar">
        </form>
        </div>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="search.js"></script>
</html>