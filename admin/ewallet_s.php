<?php
include '../config/connect.php';

$searchText = $_POST['search'];
$query = "SELECT ew.*, m.name AS mitra_name FROM ewallets ew JOIN mitras m ON ew.mitra_id = m.id WHERE ew.name LIKE '%$searchText%' OR m.name LIKE '%$searchText%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($ewallet = mysqli_fetch_assoc($result)) {
        echo "
        <tr>
            <td>$no</td>
            <td><img src='../assets/icons/ewallet/{$ewallet['image']}' alt='ewallet'></td>
            <td>{$ewallet['name']}</td>
            <td>{$ewallet['mitra_name']}</td>
            <td>
                <a href='ewallet_u.php?id={$ewallet['id']}'><i class='fas fa-edit'></i></a>
                <a href='?id={$ewallet['id']}'><i class='fas fa-trash'></i></a>
            </td>
        </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
?>
