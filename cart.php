<?php
session_start();

// ===========================
// PRODUK LIST (HARUS PALING ATAS)
// ===========================
$products = [
    'oil-soap' => ['name' => 'Oil Soap', 'price' => 5.00, 'image' => 'imgcart/promosi1.png'],
    'organic-soap' => ['name' => 'Organic Soap', 'price' => 5.00, 'image' => 'imgcart/promosi2.png'],
    'glycerin-soap' => ['name' => 'Glycerin Soap', 'price' => 5.00, 'image' => 'imgshop/facialwash3.png'],
    'olive-oil-soap' => ['name' => 'Olive Oil Soap', 'price' => 5.00, 'image' => 'imgshop/facialwash4.png'],
    'oil-serum' => ['name' => 'Oil Serum', 'price' => 5.00, 'image' => 'imgserum/serum1.png'],
    'organic-serum' => ['name' => 'Organic Serum', 'price' => 5.00, 'image' => 'imgserum/serum2.png'],
    'glycerin-serum' => ['name' => 'Glycerin Serum', 'price' => 5.00, 'image' => 'imgserum/serum3.png'],
    'oliveoil-serum' => ['name' => 'Olive Oil Serum', 'price' => 5.00, 'image' => 'imgserum/serum4.png'],
    'oil-moisturizer' => ['name' => 'Oil Moisturizer', 'price' => 5.00, 'image' => 'imgmoisturizer/moisturizer1.png'],
    'organic-moisturizer' => ['name' => 'Organic Moisturizer', 'price' => 5.00, 'image' => 'imgmoisturizer/moisturizer2.png'],
    'glycerin-moisturizer' => ['name' => 'Glycerin Moisturizer', 'price' => 5.00, 'image' => 'imgmoisturizer/moisturizer3.png'],
    'oliveoil-moisturizer' => ['name' => 'Olive Oil Moisturizer', 'price' => 5.00, 'image' => 'imgmoisturizer/moisturizer4.png'],
];

// ===========================
// Inisialisasi Cart
// ===========================
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ===========================
// Pembersihan Cart dari Produk Tidak Valid (Fix Error Undefined array key)
// ===========================
$_SESSION['cart'] = array_filter($_SESSION['cart'], function($qty, $id) use ($products) {
    return isset($products[$id]);
}, ARRAY_FILTER_USE_BOTH);

// ===========================
// Tambah Produk ke Cart via GET
// ===========================
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    if (isset($products[$id])) {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    }
    header("Location: cart.php");
    exit();
}

// ===========================
// Proses Tombol + - Hapus
// ===========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        if (!isset($products[$id])) {
            unset($_SESSION['cart'][$id]);
        } elseif (isset($_POST['increment'])) {
            $_SESSION['cart'][$id]++;
        } elseif (isset($_POST['decrement'])) {
            $_SESSION['cart'][$id]--;
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        } elseif (isset($_POST['remove'])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    // Hindari resubmission saat refresh
    if (!isset($_POST['checkout'])) {
        header("Location: cart.php");
        exit();
    }
}

// ===========================
// Proses Checkout
// ===========================
if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    $conn = new mysqli("localhost", "root", "", "db_glamore");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $payment_method = $_POST['payment_method'];
    $card_name = $_POST['card_name'];
    $card_info = $_POST['card_info'];
    $contact = $_POST['contact'];

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $conn->prepare("INSERT INTO orders (email, payment_method, card_name, card_info, contact, product_id, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $email, $payment_method, $card_name, $card_info, $contact, $product_id, $quantity);
        $stmt->execute();
    }

    $conn->close();
    $_SESSION['cart'] = [];
    echo "<script>alert('Pesanan berhasil, Akan kami Proses ya!'); window.location.href='cart.php';</script>";
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
            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
            <div class="cart-details">
              <h4><?= $product['name'] ?></h4>
              <p>Harga Satuan: $<?= number_format($product['price'], 2) ?></p>
              <p>Total: $<?= number_format($product['price'] * $qty, 2) ?></p>
              <form method="post" class="quantity-form">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" name="decrement">−</button>
                <span class="qty"><?= $qty ?></span>
                <button type="submit" name="increment">+</button>
                <button type="submit" name="remove" class="remove-btn">🗑</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Keranjang kosong.</p>
      <?php endif; ?>

      <!-- Saran Produk -->
      <div class="product-suggestions">
        <?php $saranProduk = array_slice($products, 0, 3); ?>
        <?php foreach ($saranProduk as $id => $product): ?>
          <div class="product-card">
            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" />
            <p><?= $product['name'] ?></p>
            <p>$<?= number_format($product['price'], 2) ?></p>
            <a href="cart.php?add=<?= $id ?>"><button>ADD TO CART</button></a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Form Checkout -->
    <div class="cart-right">
      <div class="total-box">
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $qty) {
          $total += $products[$id]['price'] * $qty;
        }
        ?>
        <h3>Total Belanja</h3>
        <p>$ <?= number_format($total, 2, ',', '.') ?></p>
      </div>

      <form method="POST" action="cart.php">
        <label>Email address</label>
        <input type="email" name="email" placeholder="EMAIL" required />

        <label>Pay with</label>
        <div class="pay-method">
          <input type="radio" name="payment_method" value="Card" required> 💳 Card
          <input type="radio" name="payment_method" value="PayPal"> 🅿️ PayPal
        </div>

        <label>Your Full Name</label>
        <input type="text" name="card_name" placeholder="NAME" required />

        <label>Card Information</label>
        <input type="text" name="card_info" placeholder="CARD INFO" required />

        <label>Contact Information</label>
        <input type="text" name="contact" placeholder="CONTACT" required />

        <button type="submit" name="checkout" class="submit-btn">PAY</button>
      </form>
    </div>
  </div>
</main>
<?php include_once 'template/footer.php'; ?>
</body>
</html>
