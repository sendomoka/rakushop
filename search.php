<?php
include 'config/connect.php';
if(isset($_POST['value'])){
    $value = $_POST['value'];
    $sqls = "SELECT * FROM games WHERE name LIKE '%$value%'";
    $querys = mysqli_query($conn, $sqls);
    if(mysqli_num_rows($querys) > 0){
        echo "<div class='search-box'>";
        while($row = mysqli_fetch_array($querys)){
            echo "<div class='search-card'>
                    <a href='game.php?name=$row[name]&id=$row[id]'>
                        <img src='assets/images/games/$row[cover]' alt='search' width='30'>
                        <small>$row[name]</small>
                    </a>
                </div>";
        }
        echo "</div>";
    }else{
        echo "<small>Not Found</small>";
    }
}
?>