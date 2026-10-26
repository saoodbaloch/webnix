<section class="journey" id="top">
  <div class="stage">
    <canvas class="stars" id="stars" aria-hidden="true"></canvas>
    <div class="layer earth" style="background-image:url('<?= asset('img/earth.webp') ?>')"></div>
    <div class="ship"><img src="<?= asset('img/spaceship.webp') ?>" alt=""></div>
    <div class="hero-copy">
      <h1><?php foreach (cfg('tagline') as $l) echo e($l).'<br>'; ?></h1>
      <hr><p><?= e(cfg('sub')) ?></p>
    </div>
    <div class="scroll-hint">SCROLL DOWN</div>
    <p class="about"><?php foreach (explode(' ', cfg('about')) as $w) echo '<span class="w">'.e($w).'</span> '; ?></p>
  </div>
</section>
