<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "db_glamore");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO reviews (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    $stmt->execute();

    $conn->close();
    echo "Review berhasil dikirim!";
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php include_once 'template/header.php'; ?>
    
  <main class="review-section">
    <div class="review-container">
      <div class="review-left">
        <h2>Leave a Review!</h2>
        <p><em>Please fill out the form below to send us an email.</em></p>
        <p>
          Kami ingin mendengar pendapatmu tentang produk Glamour Glow! Silakan tinggalkan reviewmu di bawah ini, dan kami akan menerimanya melalui email. Reviewmu akan membantu kami meningkatkan kualitas produk dan layanan kami. Terima kasih atas partisipasimu!
        </p>
        <p><strong>E-mail:</strong><br> holace874@gmail.com</p>
      </div>

      <div class="review-right">
        <form action="review.php" method="POST">
          <input type="text" name="name" placeholder="NAME" required />
          <input type="email" name="email" placeholder="E-MAIL" required />
          <input type="text" name="subject" placeholder="SUBJECT" required />
          <textarea name="message" rows="6" placeholder="MESSAGE" required></textarea>
          <button type="submit" class="submit-btn">SUBMIT</button>
</form>
      </div>
    </div>
  </main>
  <?php include_once 'template/footer.php'; ?>
</body>


