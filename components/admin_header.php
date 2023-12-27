<header>
    <a href="/"><img src="../assets/images/logo.png" alt="logo" height="25"></a>
    <div class="hi-search">
        <div class="hi">
            <?php
                if(isset($_SESSION['email'])){
                    echo "Hi, $_SESSION[name]!";
                }
            ?>
        </div>
    </div>
</header>