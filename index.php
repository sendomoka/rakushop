<?php
session_start();
include 'config/connect.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rakushop Indonesia</title>
    <link rel="shortcut icon" href="assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'components/header.php' ?>
    <main>
        <div class="banner-place">
            <div class="banner-box">
                <?php
                    $sqlb = "SELECT * FROM banners";
                    $query = mysqli_query($conn, $sqlb);
                    $counter = 1;
                    while($row = mysqli_fetch_array($query)){
                        $displayBanner = ($counter == 1) ? "display: block;" : "display: none;";
                        echo "<img src='assets/images/banner/$row[image]' alt='banner' data-banner='$counter' style='$displayBanner'>";
                        $counter++;
                    }
                ?>
            </div>
            <div class="banner-dot">
                <?php
                    mysqli_data_seek($query, 0);
                    $counter = 1;
                    while($row = mysqli_fetch_array($query)){
                        $activeClass = ($counter == 1) ? "active" : "";
                        echo "<div class='dot $activeClass' onclick='changeBanner($counter)'>●</div>";
                        $counter++;
                    }
                ?>
            </div>
        </div>
        <h1>GAMES</h1>
        <div class="games-box">
            <?php
                $sqlg = "SELECT * FROM games";
                $queryg = mysqli_query($conn, $sqlg);
                while($row = mysqli_fetch_array($queryg)){
                    echo "<div class='game-card'>
                            <a href='game.php?name=$row[name]&id=$row[id]'>
                                <img src='assets/images/games/$row[cover]' alt='game'>
                                <p>$row[name]</p>
                            </a>
                        </div>";
                }
            ?>
        </div>
        <div class="about-box">
            <h1>RAKUSHOP INDONESIA</h1>
            <b class="subtitle">Website top-up tercepat dan terpercaya di Indonesia</b>
            <small>Setiap bulannya, jutaan gamers menggunakan Rakushop untuk melakukan pembelian kredit game dengan lancar: tanpa registrasi ataupun log-in, dan kredit permainan akan ditambahkan secara instan. Top-up Valorant, Genshin Impact, dan berbagai game lainnya!</small>
            <div class="about-grid">
                <div class="about-item">
                    <div class="about-img">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="about-text">
                        <b>Bayar dalam hitungan detik</b>
                        <small>Hanya dibutuhkan beberapa detik saja untuk menyelesaikan pembayaran di Rakushop karena situs kami berfungsi dengan baik dan mudah untuk digunakan.</small>
                    </div>
                </div>
                <div class="about-item">
                    <div class="about-img">
                        <i class="fa-solid fa-wand-sparkles"></i>
                    </div>
                    <div class="about-text">
                        <b>Pengiriman instan</b>
                        <small>Ketika kamu melakukan top-up di Rakushop, item atau barang yang kamu beli akan selalu dikirim ke akun kamu secara instan dan cepat, tanpa tertunda.</small>
                    </div>
                </div>
                <div class="about-item">
                    <div class="about-img">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div class="about-text">
                        <b>Metode pembayaran e-wallet</b>
                        <small>Kami menawarkan pilihan pembayaran mulai dari GOPAY, DANA, QRIS, dan lainnya.</small>
                    </div>
                </div>
                <div class="about-item">
                    <div class="about-img">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="about-text">
                        <b>Layanan Pelanggan Cepat & Ramah</b>
                        <small>Tim CS terbaik kami selalu siap membantumu kapanpun, di manapun. Hubungi kami!</small>
                    </div>
                </div>
                <div class="about-item">
                    <div class="about-img">
                        <i class="fa-solid fa-piggy-bank"></i>
                    </div>
                    <div class="about-text">
                        <b>Hemat biaya transaksi</b>
                        <small>Rakushop tidak mengenakan biaya tambahan untuk setiap transaksi top up. Total tagihan yang tertera adalah total yang harus kamu bayarkan.</small>
                    </div>
                </div>
                <div class="about-item">
                    <div class="about-img">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="about-text">
                        <b>Aman dan terjamin</b>
                        <small>Data pribadi dan informasi pembayaran dilindungi dengan keamanan yang baik. Rakushop menjamin kerahasiaan data pengguna.</small>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'components/footer.php' ?>
</body>
<script>
let currentBanner = 1;
const banners = document.querySelectorAll('.banner-box img');
const dots = document.querySelectorAll('.banner-dot .dot');

function changeBanner(index) {
    banners.forEach(banner => banner.style.display = 'none');
    banners[index - 1].style.display = 'block';
    dots.forEach(dot => dot.classList.remove('active'));
    dots[index - 1].classList.add('active');
    currentBanner = index;
}

function autoChangeBanner() {
    if (currentBanner == banners.length) {
        currentBanner = 1;
    } else {
        currentBanner++;
    }
    changeBanner(currentBanner);
}

setInterval(autoChangeBanner, 10000);
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="search.js"></script>
</html>