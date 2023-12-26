<?php
session_start();
include 'config/connect.php';

if(isset($_GET['id'])){
    $game_id = $_GET['id'];
    $sqlg = "SELECT * FROM games WHERE id = $game_id";
    $result = mysqli_query($conn, $sqlg);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $game_name = $row['name'];
        $game_credit_name = $row['credit_name'];
        $game_image = $row['image'];
        $sqlc = "SELECT * FROM game_credits";
        $resultc = mysqli_query($conn, $sqlc);
        $gamec = mysqli_fetch_all($resultc, MYSQLI_ASSOC);
        $sqle = "SELECT * FROM ewallets";
        $resulte = mysqli_query($conn, $sqle);
        $gamee = mysqli_fetch_all($resulte, MYSQLI_ASSOC);
    } else {
        header("Location: index.php");
        exit();
    }
}

if (isset($_POST['order'])) {
    $game_id = $_POST['game_id'];
    $game_credits_id = $_POST['game_credits_id'];
    $ewallet_id = $_POST['ewallet_id'];
    $userid = $_POST['userid'];
    $server = $_POST['server'];
    $email = $_POST['email'];
    $currenttime = date("Y-m-d H:i:s");
    $sqlmax = "SELECT MAX(id) AS max_id FROM orders";
    $resultmax = mysqli_query($conn, $sqlmax);
    $rowmax = mysqli_fetch_assoc($resultmax);
    $next_id = $rowmax['max_id'] + 1;
    $sqlo = "INSERT INTO orders (id, game_id, game_credits_id, ewallet_id, userid, server, email, created_at, updated_at) VALUES ('$next_id', '$game_id', '$game_credits_id', '$ewallet_id', '$userid', '$server', '$email', '$currenttime', '$currenttime')";
    if (mysqli_query($conn, $sqlo)) {
        $sqlt = "INSERT INTO transactions (order_id, status, created_at, updated_at) VALUES ('$next_id', 'pending', '$currenttime', '$currenttime')";
        if (mysqli_query($conn, $sqlt)) {
            echo "<script>
            alert('Pesanan Anda telah diterima. Silakan cek email Anda untuk melanjutkan pembayaran. Jika tidak segera verifikasi, pesanan Anda akan dibatalkan.');
            window.onload = function() {
                window.location.href = 'order.php?id=$next_id';
            };
        </script>";
        } else {
            echo "Error: " . $sqlt . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $sqlo . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $game_name ?> | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/game.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'components/header.php' ?>
    <main>
        <div class="left">
            <h1><?= $game_name ?></h1>
            <img src="assets/images/games/<?= $game_image ?>" alt="game">
            <div class="labels">
                <div class="label">
                    <i class="fa-solid fa-shield-halved"></i>
                    <p><b>Pembayaran yang Aman</b></p>
                </div>
                <div class="label">
                    <i class="fa-solid fa-headset"></i>
                    <p><b>Layanan Pelanggan 24/7</b></p>
                </div>
            </div>
            <div>
                <b>Cara membeli <?= $game_credit_name ?> :</b>
                <ol>
                    <li>Masukkan <?= $game_credit_name ?> yang ingin kamu beli</li>
                    <li>Pilih metode pembayaran</li>
                    <li>Bayar dan selesaikan pembayaran</li>
                    <li><?= $game_credit_name ?> akan dikirim ke akun kamu</li>
                </ol>
                Kamu juga bisa mengirim <?= $game_credit_name ?> ke teman atau keluarga kamu dengan mengisi ID <?= $game_credit_name ?> mereka.
            </div>
        </div>
        <div class="right">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="game_id" value="<?= $game_id ?>">
            <div class="step">
                <div class="number">1.</div>
                <h2>Masukkan User ID dan Server</h2>
                <div class="input">
                    <input name="userid" type="text" placeholder="Masukkan User ID" required>
                    <select name="server" required>
                        <option value="" selected disabled>Pilih Server</option>
                        <option value="Asia">Asia</option>
                        <option value="America">America</option>
                        <option value="Europe">Europe</option>
                        <option value="China">China</option>
                    </select>
                </div>
                <small><em>Untuk menemukan UID Anda, masuk ke menu akun pada <?= $game_name ?>. UID biasanya di pojok kiri bawah layar.</em></small>
            </div>
            <div class="step">
                <div class="number">2.</div>
                <h2>Pilih Nominal Top Up</h2>
                <div class="pilihan">
                    <?php
                    foreach ($gamec as $credit) {
                        $credit_id = $credit['id'];
                        $credit_amount = $credit['amount'];
                        $credit_price = $credit['price'];
                        $credit_icon = $row['credit_icon'];
                        ?>
                        <label for="<?= $credit_id ?>" class="item">
                            <img src="assets/icons/credit/<?= $credit_icon ?>" alt="<?= $game_credit_name ?>">
                            <input type="radio" name="game_credits_id" id="<?= $credit_id ?>" value="<?= $credit_id ?>" required>
                            <b><?= $credit_amount ?></b>
                            <p>IDR <?= number_format($credit_price, 0, ',', '.') ?></p>
                        </label>
                    <?php } ?>
                </div>
            </div>
            <div class="step">
                <div class="number">3.</div>
                <h2>Pilih E-Wallet</h2>
                <div class="ewallet">
                    <?php
                    foreach ($gamee as $ewallet) {
                        ?>
                        <label for="ewallet-<?= $ewallet['id'] ?>" class="item kiri">
                            <img src="assets/icons/ewallet/<?= $ewallet['image'] ?>" alt="<?= $ewallet['name'] ?>">
                            <input type="radio" name="ewallet_id" id="ewallet-<?= $ewallet['id'] ?>" value="<?= $ewallet['id'] ?>" required>
                        </label>
                    <?php } ?>
                </div>
            </div>
            <div class="step">
                <div class="number">4.</div>
                <h2>Masukkan Detail Anda</h2>
                <b>Silakan masukkan email Anda untuk menerima verifikasi pembelian Anda</b>
                <div class="input kanan">
                    <input name="email" type="text" placeholder="Masukkan Email" style="width: 100%;" required>
                    <input name="order" type="submit" value="Beli Sekarang">
                </div>
            </div>
            </form>
        </div>
    </main>
    <?php include 'components/footer.php' ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="search.js"></script>
<script>
$(document).ready(function(){
    $(".pilihan .item input[type='radio']").change(function() {
        $(".pilihan .item").removeClass("selected");
        $(this).closest(".item").addClass("selected");
    });
});
$(document).ready(function(){
    $(".ewallet .item input[type='radio']").change(function() {
        $(".ewallet .item").removeClass("selected");
        $(this).closest(".item").addClass("selected");
    });
});
</script>
</html>