<?php defined('AFAQ') || exit; $f = array_filter(array_map('trim', explode("\n", (string)$s['features']))); ?>
<section class="section"><div class="container stack gap6 narrow"><a href="/services" class="small">← All services</a><h1 class="h1"><?= h($s['name']) ?></h1><p class="lead"><?= h($s['summary']) ?></p>
<?php if ($s['image']): ?><div class="media ph r-16-9"><img src="<?= h(img($s['image'])) ?>" alt="<?= h($s['name']) ?>"></div><?php endif; ?><div class="prose"><?= paras($s['content']) ?></div>
<?php if ($f): ?><ul class="checks"><?php foreach ($f as $x): ?><li><?= h($x) ?></li><?php endforeach; ?></ul><?php endif; ?><div><a href="/contact" class="btn btn-primary">Ask about this service</a></div></div></section>
