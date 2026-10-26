<?php require_once __DIR__.'/functions.php'; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e(cfg('name')) ?> — Premium Websites &amp; Brands</title>
<meta name="description" content="<?= e(cfg('about')) ?>">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/theme.css') ?>">
<link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>
<body>
<a class="logo" id="logo" href="#top"><?= e(cfg('wordmark')) ?><i>.</i></a>
<header class="top">
  <nav><span><?= e(cfg('phone')) ?></span><a href="mailto:<?= e(cfg('email')) ?>"><?= e(cfg('email')) ?></a></nav>
</header>
<a class="cta" href="#contact">Get Started <b>↗</b></a>
