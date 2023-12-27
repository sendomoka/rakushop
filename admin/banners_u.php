<?php
session_start();
include '../config/connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);
$current_page = str_replace('.php', '', $current_page);
$title = ucwords(str_replace('_', ' ', $current_page));

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM banners WHERE id = $id");
    if ($result) {
        $banner = mysqli_fetch_assoc($result);
        if (isset($_POST['update'])) {
            $newImage = $_FILES['image']['name'];
            $newImage_tmp = $_FILES['image']['tmp_name'];
            $newImage_size = $_FILES['image']['size'];
            $newImage_error = $_FILES['image']['error'];
            $newImage_type = $_FILES['image']['type'];
            $newImage_ext = strtolower(end(explode('.', $newImage)));
            $extensions = ['jpg', 'jpeg', 'png'];
            if (in_array($newImage_ext, $extensions)) {
                if ($newImage_error === 0) {
                    $newImageName = uniqid('banner_', true) . '.' . $newImage_ext;
                    move_uploaded_file($newImage_tmp, '../assets/images/banner/' . $newImageName);
                    $oldImagePath = '../assets/images/banner/' . $banner['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $updateQuery = "UPDATE banners SET image = '$newImageName' WHERE id = $id";
                    $updateResult = mysqli_query($conn, $updateQuery);
                    if ($updateResult) {
                        header("Location: banners.php");
                        exit();
                    } else {
                        echo "Gagal mengupdate data banner.";
                    }
                } else {
                    echo "Error pada file gambar baru.";
                }
            } else {
                echo "Tipe gambar baru tidak diizinkan.";
            }
        }
    } else {
        echo "Data banner tidak ditemukan.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> Update | Rakushop Indonesia</title>
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
            <a href="banners.php" class="active">
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
            <h2>Banners Update</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Current Image</td>
                        <td>:</td>
                        <td><img src="../assets/images/banner/<?= $banner['image'] ?>" alt="<?= $banner['image'] ?>" height="100"></td>
                    </tr>
                    <tr>
                        <td>New Image</td>
                        <td>:</td>
                        <td><input type="file" name="image" id="image" accept="image/*"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="update" value="Update"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
    <?php include '../components/admin_footer.php' ?>
</body>
</html>
