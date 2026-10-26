<section class="contact" id="contact">
  <div class="wrap">
    <div class="info">
      <h2>Let’s make your brand unforgettable.</h2>
      <p>If you’re ready to lead your market, let’s talk. Fill in the form or reach out directly — we respond within 24 hours.</p>
      <div class="card-i"><small>Email</small><?= e(cfg('email')) ?></div>
      <?php foreach (cfg('offices') as [$t,$a]): ?>
        <div class="card-i"><small><?= e($t) ?></small><?= e($a) ?><br><?= e(cfg('phone')) ?></div>
      <?php endforeach; ?>
    </div>

    <form class="panel" id="lead" novalidate>
      <h3>From Brand to Icon.</h3>
      <p class="muted">Tell us about your project and we’ll get back within 24 hours.</p>
      <a class="wa" id="wa" href="#" target="_blank" rel="noopener">Start a WhatsApp Conversation<small>Get a faster response — we’re usually online</small></a>
      <div class="or"><span>or send us the details</span></div>

      <input type="hidden" name="csrf" value="<?= csrf() ?>">
      <input class="hp" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">

      <div class="row">
        <label>Full name <b>*</b><input name="name" placeholder="Your name" autocomplete="name" required></label>
        <label>Email <b>*</b><input name="email" type="email" placeholder="you@company.com" autocomplete="email" required></label>
      </div>
      <div class="row">
        <label>Phone / WhatsApp <b>*</b><input name="phone" type="tel" placeholder="+1 3456789" autocomplete="tel" required></label>
        <label>Country <b>*</b><select name="country" autocomplete="country-name" required><option value="">Select country</option><?php foreach (cfg('countries') as $c) echo '<option>'.e($c).'</option>'; ?></select></label>
      </div>
      <label class="row1">Company / brand name<input name="company" placeholder="Optional" autocomplete="organization"></label>

      <div class="svc" id="svc">
        <div class="svc-head"><span>What do you need help with? <b>*</b></span><em id="svc-count">Pick one or more</em></div>
        <?php foreach (cfg('service_groups') as $g => $items): ?>
          <fieldset>
            <legend><?= e($g) ?></legend>
            <div class="chips"><?php foreach ($items as $s) echo '<label class="chip"><input type="checkbox" name="services[]" value="'.e($s).'"><span>'.e($s).'</span></label>'; ?></div>
          </fieldset>
        <?php endforeach; ?>
      </div>

      <fieldset class="bud">
        <legend>Estimated budget</legend>
        <div class="chips"><?php foreach (cfg('budgets') as $b) echo '<label class="chip"><input type="radio" name="budget" value="'.e($b).'"><span>'.e($b).'</span></label>'; ?></div>
      </fieldset>

      <label class="row1">Project details<textarea name="message" rows="3" maxlength="1500" placeholder="Tell us what you want to build, any deadline, links, references…"></textarea></label>

      <button type="submit" class="btn">Send request</button>
      <p class="msg" id="msg" role="status" aria-live="polite"></p>
    </form>
  </div>
</section>
