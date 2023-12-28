<?php
include '../config/connect.php';

$searchText = $_POST['search'];
$query = "SELECT * FROM mitras WHERE name LIKE '%$searchText%' OR country LIKE '%$searchText%' OR updated_at LIKE '%$searchText%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($mitra = mysqli_fetch_assoc($result)) {
        echo "
        <tr>
            <td>$no</td>
            <td>{$mitra['name']}</td>
            <td>{$mitra['country']}</td>
            <td><img src='../assets/images/mitras/{$mitra['image']}' alt='{$mitra['name']}'></td>
            <td>{$mitra['updated_at']}</td>
            <td>
                <a href='mitra_u.php?id={$mitra['id']}'><i class='fas fa-edit'></i></a>
                <a href='?id={$mitra['id']}'><i class='fas fa-trash'></i></a>
            </td>
        </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='6'>No records found</td></tr>";
}
?>
