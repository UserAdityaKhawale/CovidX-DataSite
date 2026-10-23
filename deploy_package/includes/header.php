<?php
$activePage = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$user = current_user();
$flashMessage = take_flash();
$pageTitle = $pageTitle ?? 'COVID-19 Information';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#081525"><meta name="description" content="COVID-19 information, transparent demonstration data, and community tools.">
  <title><?= h($pageTitle) ?> · Co-Shield</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="assets/css/style.css">
  <script defer src="assets/js/validation.js"></script>
</head>
<body>
<div class="topline"><div class="container top-inner"><span>Ministry of Health &amp; Family Welfare · India</span><span>National helpline <a href="tel:1075">1075 (toll-free)</a> · For current advice, contact your local health authority</span></div></div>
<header class="site-header"><div class="container nav-wrap"><a class="brand" href="index.php" aria-label="Co-Shield home"><span class="brand-mark">✚</span><span><strong>Co-Shield</strong><small>COVID-19 information portal</small></span></a><button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-nav">Menu <span>☰</span></button><nav class="main-nav" id="main-nav" aria-label="Main navigation">
<?php $links = ['index.php'=>'Home', 'data.php'=>'COVID-19 Data', 'about.php'=>'About COVID-19', 'vaccination.php'=>'Vaccination', 'comments.php'=>'Comments']; foreach ($links as $href=>$label): ?><a class="nav-link <?= $activePage === $href ? 'active' : '' ?>" href="<?= h($href) ?>"><?= h($label) ?></a><?php endforeach; ?>
<?php if ($user): ?><span class="nav-user" title="Signed in as <?= h($user['username']) ?>"><span class="avatar"><?= h(strtoupper(substr($user['username'], 0, 1))) ?></span><span><?= h($user['username']) ?></span></span><form method="post" action="logout.php" class="inline-form"><?= csrf_field() ?><button class="nav-logout" type="submit">Log out</button></form><?php else: ?><a class="nav-login <?= in_array($activePage, ['login.php','register.php'], true) ? 'active' : '' ?>" href="login.php">Log in</a><a class="nav-register" href="register.php">Create account <span aria-hidden="true">→</span></a><?php endif; ?>
  </nav></div></header>
<?php if ($flashMessage): ?><div class="container"><div class="alert <?= h($flashMessage['type']) ?>" role="status"><?= h($flashMessage['message']) ?></div></div><?php endif; ?>
