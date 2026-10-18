<?php defined('AFAQ') || exit; ?>
<section class="section"><div class="container stack gap8"><div class="stack gap3"><span class="eyebrow">What we do</span><h1 class="h1">Services</h1></div>
<?php if (!$svc): ?><p class="notice">Our services will be listed here soon.</p><?php else: ?><div class="grid grid-3"><?php foreach ($svc as $s): ?><article class="card"><div class="media ph r-4-3"><?php if ($s['image']): ?><img src="<?= h(img($s['image'])) ?>" alt="<?= h($s['name']) ?>" loading="lazy"><?php endif; ?></div>
<div class="card-body"><h2 class="h3"><?= h($s['name']) ?></h2><p class="muted"><?= h($s['summary']) ?></p><a class="btn btn-outline more" href="/services/<?= h($s['slug']) ?>">Learn more</a></div></article><?php endforeach; ?></div><?php endif; ?></div></section>
