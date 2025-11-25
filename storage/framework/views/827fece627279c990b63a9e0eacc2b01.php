<?php
    $locale = app()->getLocale(); // e.g. 'en', 'kh', 'cn'
    
    // Map language codes to country codes
    $flagMap = [
        'en' => 'us', // English → United States flag
        'kh' => 'kh', // Khmer → Cambodia flag
        'cn' => 'cn', // Chinese → China flag
    ];

    // Pick the matching flag code, fallback to 'us'
    $flagIcon = $flagMap[$locale] ?? 'us';
?>


<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo e(asset('backend/dist/img/AdminLTELogo.png')); ?>" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar --><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/layout/header.blade.php ENDPATH**/ ?>