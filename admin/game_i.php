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
    $credit_name = $_POST['credit_name'];
    $cover = $_FILES['cover']['name'];
    $cover_tmp = $_FILES['cover']['tmp_name'];
    $cover_size = $_FILES['cover']['size'];
    $cover_error = $_FILES['cover']['error'];
    $cover_type = $_FILES['cover']['type'];
    $cover_ext = strtolower(end(explode('.', $cover)));
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_error = $_FILES['image']['error'];
    $image_type = $_FILES['image']['type'];
    $image_ext = strtolower(end(explode('.', $image)));
    $credit_icon = $_FILES['credit_icon']['name'];
    $credit_icon_tmp = $_FILES['credit_icon']['tmp_name'];
    $credit_icon_size = $_FILES['credit_icon']['size'];
    $credit_icon_error = $_FILES['credit_icon']['error'];
    $credit_icon_type = $_FILES['credit_icon']['type'];
    $credit_icon_ext = strtolower(end(explode('.', $credit_icon)));
    $extensions = ['jpg', 'jpeg', 'png'];

    if(in_array($cover_ext, $extensions) && in_array($image_ext, $extensions) && in_array($credit_icon_ext, $extensions)){
        if($cover_error === 0 && $image_error === 0 && $credit_icon_error === 0){
            $cover_name = uniqid('cover_', true) . '.' . $cover_ext;
            $image_name = uniqid('image_', true) . '.' . $image_ext;
            $credit_icon_name = uniqid('credit_', true) . '.' . $credit_icon_ext;
            move_uploaded_file($cover_tmp, '../assets/images/games/' . $cover_name);
            move_uploaded_file($image_tmp, '../assets/images/games/' . $image_name);
            move_uploaded_file($credit_icon_tmp, '../assets/icons/credit/' . $credit_icon_name);
            $sql = "INSERT INTO games (name, mitra_id, credit_name, cover, image, credit_icon) VALUES ('$name', '$mitra', '$credit_name', '$cover_name', '$image_name', '$credit_icon_name')";
            $query = mysqli_query($conn, $sql);
            if($query){
                header("Location: games.php");
                exit();
            }else{
                echo "<script>alert('Insert failed!')</script>";
            }
        }else{
            echo "<script>alert('Image error!')</script>";
        }
    }else{
        echo "<script>alert('Image type not allowed!')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games Insert | Rakushop Indonesia</title>
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
            <a href="games.php" class="active">
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
            <h2>Game Insert</h2>
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
                        <td>Credit Name</td>
                        <td>:</td>
                        <td><input type="text" name="credit_name" required></td>
                    </tr>
                    <tr>
                        <td>Cover Game (1:1)</td>
                        <td>:</td>
                        <td><input type="file" name="cover" id="cover" accept="image/*" required></td>
                    </tr>
                    <tr>
                        <td>Image Game (21:9)</td>
                        <td>:</td>
                        <td><input type="file" name="image" id="image" accept="image/*" required></td>
                    </tr>
                    <tr>
                        <td>Image Credit Game (1:1)</td>
                        <td>:</td>
                        <td><input type="file" name="credit_icon" id="credit_icon" accept="image/*" required></td>
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