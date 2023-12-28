<?php
session_start();
include '../config/connect.php';

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $mitra = $_POST['mitras'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $path = "../assets/icons/ewallet/".$image;
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg'){
        if(move_uploaded_file($tmp, $path)){
            $sql = "INSERT INTO ewallets (name, mitra_id, image) VALUES ('$name', '$mitra', '$image')";
            if(mysqli_query($conn, $sql)){
                echo "<script>alert('E-Wallet berhasil ditambahkan!');
                window.onload = function() {
                    window.location.href = 'ewallets.php';
                };
                </script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Gambar gagal diupload!');
            window.onload = function() {
                window.location.href = 'ewallets.php';
            };
            </script>";
        }
    } else {
        echo "<script>alert('Ekstensi gambar yang diperbolehkan hanya jpg, jpeg, dan png!');
        window.onload = function() {
            window.location.href = 'ewallets.php';
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
    <title>E-Wallets Insert | Rakushop Indonesia</title>
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
            <a href="games.php">
                <i class="fas fa-gamepad"></i>
                Games
            </a>
            <a href="ewallets.php" class="active">
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
            <h2>E-Wallet Insert</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td><input type="text" name="name" required></td>
                    </tr>
                    <tr>
                        <td>Mitra</td>
                        <td>:</td>
                        <td>
                            <select name="mitras" required>
                                <option value="" selected disabled>Pilih Mitra</option>
                                <?php
                                $querym = mysqli_query($conn, "SELECT * FROM mitras");
                                while ($data = mysqli_fetch_array($querym)) {
                                    echo "<option value='$data[id]'>$data[name]</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Image E-Wallet</td>
                        <td>:</td>
                        <td><input type="file" name="image" id="image" accept="image/*" required></td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="submit" value="Insert"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
    <?php include '../components/admin_footer.php' ?>
</body>
</html>