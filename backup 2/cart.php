<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    if (isset($_POST['increment'])) {
        $_SESSION['cart'][$id]++;
    } elseif (isset($_POST['decrement'])) {
        if ($_SESSION['cart'][$id] > 1) {
            $_SESSION['cart'][$id]--;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    } elseif (isset($_POST['remove'])) {
        unset($_SESSION['cart'][$id]);
    }
}
?>
<?php
// Daftar produk (bisa dari database nantinya)
$products = [
    'oil-soap' => [
        'name' => 'Oil Soap',
        'price' => 5.00,
        'image' => 'imgcart/promosi1.png'
    ],
    'organic-soap' => [
        'name' => 'Organic Soap',
        'price' => 5.00,
        'image' => 'imgcart/promosi2.png'
    ],
    'glycerin-soap' => [
        'name' => 'Glycerin Soap',
        'price' => 5.00,
        'image' => 'imgshop/facialwash3.png'
    ],
    'olive-oil-soap' => [
        'name' => 'Olive Oil Soap',
        'price' => 5.00,
        'image' => 'imgshop/facialwash4.png'
    ],
    'oil-serum' => [
        'name' => 'Oil Serum',
        'price' => 5.00,
        'image' => 'imgserum/serum1.png'
    ],
    'organic-serum' => [
        'name' => 'Organic Serum',
        'price' => 5.00,
        'image' => 'imgserum/serum2.png'
    ],
    'glycerin-serum' => [
        'name' => 'Glycerin Serum',
        'price' => 5.00,
        'image' => 'imgserum/serum3.png'
    ],
    'oliveoil-serum' => [
        'name' => 'Olive Oil Serum',
        'price' => 5.00,
        'image' => 'imgserum/serum4.png'
    ],
    'oil-moisturizer' => [
        'name' => 'Oil Moisturizer',
        'price' => 5.00,
        'image' => 'imgmoisturizer/moisturizer1.png'
    ],
    'organic-moisturizer' => [
        'name' => 'Organic Moisturizer',
        'price' => 5.00,
        'image' => 'imgmoisturizer/moisturizer2.png'
    ],
    'glycerin-moisturizer' => [
        'name' => 'Glycerin Moisturizer',
        'price' => 5.00,
        'image' => 'imgmoisturizer/moisturizer3.png'
    ],
    'oliveoil-moisturizer' => [
        'name' => 'Olive Oil Moisturizer',
        'price' => 5.00,
        'image' => 'imgmoisturizer/moisturizer4.png'
    ]

];

// Tambahkan produk ke cart
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    if (isset($products[$id])) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }
    }
    header("Location: cart.php");
    exit();
}

// Update jumlah
if (isset($_GET['update']) && isset($_GET['act'])) {
    $id = $_GET['update'];
    $action = $_GET['act'];

    if (isset($_SESSION['cart'][$id])) {
        if ($action === 'plus') {
            $_SESSION['cart'][$id]++;
        } elseif ($action === 'minus') {
            $_SESSION['cart'][$id]--;
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }
    header("Location: cart.php");
    exit();
}

// Hapus produk
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'template/header.php'; ?>
<main class="cart-section">
  <div class="cart-container">
    <div class="cart-left">
      <h2>Shopping Cart</h2>

      <?php if (!empty($_SESSION['cart'])): ?>
        <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
          <?php $product = $products[$id]; ?>
          <div class="cart-item">
          <img src="<?php echo $products[$id]['image']; ?>" alt="<?php echo $products[$id]['name']; ?>">
            <div class="cart-details">
            <h4><?php echo $products[$id]['name']; ?></h4>
            <p>Harga Satuan: $<?php echo number_format($products[$id]['price'], 2, '.', ''); ?></p>
            <p>Total: $<?php echo number_format($products[$id]['price'] * $qty, 2, '.', ''); ?></p>
            <form method="post" class="quantity-form">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="decrement">−</button>
            <span class="qty"><?php echo $qty; ?></span>
            <button type="submit" name="increment">+</button>
            <button type="submit" name="remove" class="remove-btn">🗑</button>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Keranjang kosong.</p>
      <?php endif; ?>
        <!-- Saran produk-->
        <div class="product-suggestions">
        <?php
        // Ambil hanya 3 produk untuk saran
        $saranProduk = array_slice($products, 0, 3, true);
        $saranAcak = array_rand($saranProduk, 3);
        foreach ($saranAcak as $key) {
        $product = $products[$key];
        // tampilkan $product seperti biasa
        }

        foreach ($saranProduk as $id => $product): ?>
        <div class="product-card">
        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" />
        <p><?= $product['name'] ?></p>
        <p>$<?= number_format($product['price'], 2) ?></p>
        <a href="cart.php?add=<?= $id ?>"><button>ADD TO CART</button></a>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
    

    <div class="cart-right">
      <div class="total-box">
      <?php
        $total = 0;
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $qty) {
            $total += $products[$id]['price'] * $qty;
        }
        } echo "<h3>Total Belanja</h3>";
        echo "<p>$ " . number_format($total, 2, ',', '.') . "</p>";
      ?>
      </div>
      <form>
        <label>Email address</label>
        <input type="email" placeholder="EMAIL" required />

        <label>Pay with</label>
        <div class="pay-method">
          <button type="button" class="pay-card">💳 Card</button>
          <button type="button" class="pay-paypal">🅿️ PayPal</button>
        </div>

        <label>Name On Card</label>
        <input type="text" placeholder="NAME" required />

        <label>Card Information</label>
        <input type="text" placeholder="CARD INFO" required />

        <label>Contact Information</label>
        <input type="text" placeholder="CONTACT" required />

        <button type="submit" class="submit-btn">PAY</button>
      </form>
    </div>
  </div>
</main>
<?php include_once 'template/footer.php'; ?>
</body>
</html>
