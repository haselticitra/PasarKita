<?php $page_title = $page_title ?? 'PasarKita'; ?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=e($page_title)?> - PasarKita</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom">
 <div class="container">
  <a class="navbar-brand fw-bold text-success" href="index.php">🧺 PasarKita</a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="nav">
   <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
    <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang <span class="badge text-bg-success"><?=cart_count()?></span></a></li>
    <?php if(is_logged_in()): ?>
      <li class="nav-item"><a class="nav-link" href="orders.php">Pesanan Saya</a></li>
      <?php if(is_admin()): ?><li class="nav-item"><a class="nav-link" href="admin/index.php">Admin</a></li><?php endif; ?>
      <li class="nav-item"><span class="nav-link text-secondary">Hai, <?=e($_SESSION['user']['name'])?></span></li>
      <li class="nav-item"><a class="btn btn-outline-danger btn-sm" href="logout.php">Keluar</a></li>
    <?php else: ?>
      <li class="nav-item"><a class="nav-link" href="login.php">Masuk</a></li>
      <li class="nav-item"><a class="btn btn-success btn-sm px-3" href="register.php">Daftar</a></li>
    <?php endif; ?>
   </ul>
  </div>
 </div>
</nav>
<main class="container py-4">
<?php flash(); ?>
