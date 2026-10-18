<?php defined('AFAQ') || exit; ?>
<section class="hero"><?php if ($S['hero_image']): ?><div class="hero-bg" aria-hidden="true"><img src="<?= h(img($S['hero_image'])) ?>" alt=""></div><?php endif; ?><div class="hero-lines" aria-hidden="true"></div>
<div class="container hero-grid"><div class="hero-copy"><span class="eyebrow"><?= h($S['company']) ?></span><h1 class="display"><?= h($S['hero_headline']) ?></h1><p class="lead"><?= h($S['description'] ?: $S['hero_sub']) ?></p>
<div class="hero-actions"><a href="/contact" class="btn btn-primary"><?= h($S['cta_text']) ?></a><a href="/projects" class="btn btn-outline">Explore Projects</a></div></div>
<div class="hero-art"><?php include ROOT . '/app/art.php'; ?></div></div>
<div class="container"><ul class="hero-meta"><?php if ($S['address']): ?><li><span class="caption">Based in</span><?= h($S['address']) ?></li><?php endif; ?><li><span class="caption">Services</span>Residential · Commercial · Renovation</li><li><span class="caption">Tools</span>Brick &amp; block calculator</li></ul></div></section>

<section class="section"><div class="container intro-grid"><div class="stack"><span class="eyebrow">About <?= h($S['brand']) ?></span><p class="statement"><?= h($S['statement']) ?></p></div>
<div class="stack"><p class="intro-text"><?= h($S['intro']) ?></p><div><a href="/contact" class="btn btn-outline">Get in touch</a></div>
<div class="logo-plate media r-1-1"><img src="<?= h($S['logo'] ? img($S['logo']) : '/assets/img/logo.jpg') ?>" alt="<?= h($S['brand']) ?> logo" loading="lazy"></div></div></div></section>

<section class="section services-sec" aria-labelledby="svc-h"><div class="container stack gap8"><div class="sec-head"><div class="stack gap2"><span class="eyebrow">What we do</span><h2 id="svc-h" class="h2">Services</h2></div><?php if ($svc): ?><a href="/services" class="btn btn-ghost">All services →</a><?php endif; ?></div>
<ol class="svc-list"><?php if ($svc): foreach ($svc as $i => $s): ?><li class="svc-row"><span class="svc-num"><?= sprintf('%02d', $i + 1) ?></span><a class="svc-name" href="/services/<?= h($s['slug']) ?>"><?= h($s['name']) ?></a><span class="svc-text"><?= h($s['summary']) ?></span></li>
<?php endforeach; else: foreach ($defaultSvc as $i => $n): ?><li class="svc-row"><span class="svc-num"><?= sprintf('%02d', $i + 1) ?></span><span class="svc-name"><?= h($n) ?></span></li><?php endforeach; endif; ?></ol></div></section>

<section class="section" aria-labelledby="proj-h"><div class="container stack gap8"><div class="sec-head"><div class="stack gap2"><span class="eyebrow">Portfolio</span><h2 id="proj-h" class="h2">Projects</h2></div><a href="/projects" class="btn btn-ghost">View projects →</a></div>
<?php if ($proj): ?><div class="grid grid-3"><?php foreach ($proj as $i => $p) { $large = $i === 0 && $p['featured'] && count($proj) === 3; include ROOT . '/app/views/card.php'; } ?></div><?php else: include ROOT . '/app/views/empty.php'; endif; ?></div></section>

<section class="section calc-feature" aria-labelledby="calc-h"><div class="container calc-feature-row"><div class="stack gap3"><span class="eyebrow">Construction tools</span><h2 id="calc-h" class="h2">Know your quantities before you build</h2><p class="lead">Estimate bricks, blocks and mortar for any wall. Add doors and windows, set wastage, and see exactly how the result was worked out.</p></div>
<div class="calc-feature-actions"><a href="/calculators" class="btn btn-primary">Brick calculator</a><a href="/calculators?type=block" class="btn btn-outline">Block calculator</a></div></div></section>

<?php if ($facts): ?><section class="section" aria-labelledby="find-us"><div class="container stack gap8"><div class="sec-head"><div class="stack gap2"><span class="eyebrow">Contact</span><h2 id="find-us" class="h2">Find us</h2></div></div>
<dl class="facts"><?php foreach ($facts as $f): ?><div><dt class="caption"><?= h($f[0]) ?></dt><dd><?= $f[2] ? '<a href="' . h($f[2]) . '">' . h($f[1]) . '</a>' : h($f[1]) ?></dd></div><?php endforeach; ?></dl></div></section><?php endif; ?>
