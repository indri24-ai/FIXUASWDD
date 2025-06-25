    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Glamoure Glow</title>
    <link rel="stylesheet" href="style.css" />
    <body>
    <header>
        <div class="logo">GLAMOURE GLOW</div>
        <nav>
            <?php
                $filename = basename($_SERVER['PHP_SELF']);
                $isindex = '';
                $isabout = '';
                $isshop = '';
                $isreview = '';
                $isteam = '';
                if($filename == 'index.php'){
                    $isindex = 'active';
                } elseif($filename == 'about.php'){
                    $isabout = 'active';
                } elseif($filename == 'shop.php'){
                    $isshop = 'active';
                } elseif($filename == 'review.php'){
                    $isreview = 'active';
                } elseif($filename == 'ourteam.php'){
                    $isteam = 'active';
                }
            ?>
                <a href="index.php" class="<?php echo $isindex; ?>">HOME</a>
                <a href="about.php" class="<?php echo $isabout; ?>">ABOUT</a>
            <div class="dropdown">
                <a href="shop.php" class="<?php echo $isshop; ?>">SHOP ▾</a>
            <div class="dropdown-content">
                <a href="shop.php">FACIAL WASH</a>
                <a href="serum.php">SERUM</a>
                <a href="moisturizer.php">MOISTURIZER</a>
            </div>
            </div>

        <a href="review.php" class="<?php echo $isreview; ?>">REVIEW</a>
        <a href="ourteam.php" class="<?php echo $isteam; ?>">OUR TEAM</a>
        </nav>

        <a href="cart.php"><span class="cart-icon">🛒</span></a>
    </header>