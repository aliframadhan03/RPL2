<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="<?= ASSETSURL . 'img/logo/icon.png' ?>">

  <meta name="description" content="Frequently Asked Questions">
  <meta name="keywords" content="FAQ, Kitty Dance, Equipment Store">

  <!-- Bootstrap CSS -->
  <link href="<?= ASSETSURL; ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="<?= ASSETSURL; ?>css/tiny-slider.css" rel="stylesheet">
  <link href="<?= ASSETSURL; ?>css/style.css" rel="stylesheet">
  <title>Kitty Dance Equipment Store - FAQ</title>
</head>

<body>

<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
  <div class="container">
    <a class="navbar-brand" href="<?= BASEURL . 'home.php'; ?>"><?= WEBTITLE; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsFurni">
      <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
        <?php if (!isset($_SESSION['id'])) : ?>
          <li class="nav-item <?= ($_GET['page'] == 'home.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= BASEURL . 'home.php'; ?>">Beranda</a>
          </li>
          <li class="nav-item <?= ($_GET['page'] == 'produk.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= BASEURL . 'produk.php'; ?>">Produk</a>
          </li>
          <li class="nav-item <?= ($_GET['page'] == 'FAQ.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= BASEURL . 'FAQ.php'; ?>">FAQ</a>
          </li>
          <li class="nav-item <?= ($_GET['page'] == 'login.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= BASEURL . 'login.php'; ?>">Login</a>
          </li>
        <?php else : ?>
          <?php if ($_SESSION['role'] == 2) : ?>
            <li class="nav-item <?= ($_GET['page'] == 'keranjang.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= BASEURL . 'keranjang.php'; ?>">Keranjang</a>
            </li>
            <li class="nav-item <?= ($_GET['page'] == 'transaksi-user.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= BASEURL . 'transaksi-user.php'; ?>">Transaksi</a>
            </li>
          <?php else : ?>
            <li class="nav-item <?= ($_GET['page'] == 'dashboard.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= BASEURL . 'dashboard.php'; ?>">Dashboard</a>
            </li>
          <?php endif; ?>
          <li class="nav-item <?= ($_GET['page'] == 'profil.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= BASEURL . 'profil.php'; ?>">Settings</a>
          </li>
          <li class="nav-item <?= ($_GET['page'] == 'keluar.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= BASEURL . 'keluar.php' ?>">Keluar</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<!-- End Header/Navigation -->

<!-- FAQ Content -->
<div class="container" style="max-width: 800px; margin: 30px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
  <div class="faq-header" style="text-align: center; margin-bottom: 20px;">
    <h1 style="font-size: 24px; margin: 0;">Frequently Asked Questions</h1>
  </div>

  <?php
  $faqs = [
    "Apa Itu Kitty Dance Equipment Store?" => "Kitty Dance Equipment Store adalah toko online yang menyediakan alat-alat tari berkualitas.",
    "Bagaimana cara melakukan pemesanan di website ini?" => "Anda dapat melakukan pemesanan dengan memilih produk, menambahkannya ke keranjang, dan menyelesaikan proses pembayaran di halaman checkout.",
    "Apa saja alat-alat tari yang tersedia di Kitty Dance Equipment Store?" => "Kitty Dance Equipment Store menyediakan berbagai alat tari seperti sepatu tari, kostum, aksesori, dan perlengkapan lainnya.",
    "Metode pembayaran apa saja yang diterima?" => "Kami menerima pembayaran melalui transfer bank, kartu kredit, dan e-wallet seperti OVO dan GoPay.",
    "Berapa lama waktu pengiriman barang?" => "Waktu pengiriman tergantung lokasi Anda. Biasanya membutuhkan waktu 3-7 hari kerja.",
    "Apakah saya bisa mengembalikan atau menukar barang?" => "Ya, Anda dapat mengembalikan atau menukar barang sesuai dengan kebijakan pengembalian kami yang tercantum di website.",
    "Bagaimana cara menghubungi layanan pelanggan?" => "Anda dapat menghubungi layanan pelanggan melalui email, nomor telepon, atau fitur live chat yang tersedia di website kami."
  ];

  foreach ($faqs as $question => $answer) { ?>
    <div class="faq-item" style="margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; overflow: hidden;">
      <div class="faq-question" style="background-color: #FFCC33; padding: 15px; cursor: pointer; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
        <?= $question ?> <span>+</span>
      </div>
      <div class="faq-answer" style="display: none; padding: 15px; background-color: #fff;">
        <p style="margin: 0;"><?= $answer ?></p>
      </div>
    </div>
  <?php } ?>
</div>

<script>
  const faqQuestions = document.querySelectorAll('.faq-question');

  faqQuestions.forEach(question => {
    question.addEventListener('click', () => {
      const answer = question.nextElementSibling;
      const isVisible = answer.style.display === 'block';

      document.querySelectorAll('.faq-answer').forEach(ans => ans.style.display = 'none');

      answer.style.display = isVisible ? 'none' : 'block';
      question.querySelector('span').textContent = isVisible ? '+' : '-';
    });
  });
</script>

</body>
</html>
