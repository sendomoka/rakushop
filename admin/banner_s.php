<?php
include '../config/connect.php';

$searchText = $_POST['search'];
$query = "SELECT * FROM banners WHERE image LIKE '%$searchText%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($banner = mysqli_fetch_assoc($result)) {
        echo "
        <tr>
            <td>$no</td>
            <td><img src='../assets/images/banner/{$banner['image']}' alt='{$banner['image']}'></td>
            <td>
                <a href='banners_u.php?id={$banner['id']}'><i class='fas fa-edit'></i></a>
                <a href='banners_d.php?id={$banner['id']}'><i class='fas fa-trash'></i></a>
            </td>
        </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='3'>No records found</td></tr>";
}
?>
