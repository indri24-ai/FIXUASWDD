<?php
session_start();

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
            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" />
            <div class="cart-details">
              <p><strong><?= $product['name'] ?></strong></p>
              <p>$<?= number_format($product['price'], 2) ?></p>
              <a href="cart.php?remove=<?= $id ?>">Remove</a>
              <div class="quantity">
                <a href="cart.php?update=<?= $id ?>&act=minus"><button>-</button></a>
                <span><?= $qty ?></span>
                <a href="cart.php?update=<?= $id ?>&act=plus"><button>+</button></a>
              </div>
              <p><strong>TOTAL</strong> $<?= number_format($qty * $product['price'], 2) ?></p>
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
    <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $qty) {
        $total += $products[$id]['price'] * $qty;
        }
        echo "<h3>Total Belanja: $" . number_format($total, 2) . "</h3>";
        ?>
    <div class="cart-right">
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
