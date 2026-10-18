<?php defined('AFAQ') || exit;
$nav = [['/', 'Home'], ['/services', 'Services'], ['/projects', 'Projects'], ['/calculators', 'Calculators'], ['/contact', 'Contact']];
$cur = '/' . trim((string)parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$on = function ($p) use ($cur) { return $p === '/' ? $cur === '/' : ($cur === $p || strpos($cur, $p . '/') === 0); };
$mark = $S['logo'] ? img($S['logo']) : '/assets/img/mark.png';
$ttl = isset($title) && $title ? $title . ' | ' . $S['brand'] : $S['brand'] . ' | ' . $S['tagline'];
$d = $desc ?? ($S['description'] ?: $S['hero_sub']);
$base = site_url(); $canon = $base . ($cur === '/' ? '' : $cur);
$ld = ['@context' => 'https://schema.org', '@type' => 'GeneralContractor', 'name' => $S['company'], 'url' => $base];
if ($S['phone']) $ld['telephone'] = $S['phone']; if ($S['email']) $ld['email'] = $S['email'];
if ($S['address']) $ld['address'] = ['@type' => 'PostalAddress', 'streetAddress' => $S['address'], 'addressCountry' => 'PK'];
$same = array_values(array_filter([$S['facebook'], $S['instagram'], $S['tiktok'], $S['youtube'], $S['linkedin']])); if ($same) $ld['sameAs'] = $same; ?>
<!doctype html><html lang="en" style="--color-primary:<?= h($S['color_primary']) ?>;--color-bg:<?= h($S['color_bg']) ?>;--color-secondary:<?= h($S['color_secondary']) ?>">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= h($ttl) ?></title><meta name="description" content="<?= h(mb_substr($d, 0, 160)) ?>">
<link rel="canonical" href="<?= h($canon) ?>"><link rel="icon" href="<?= h($mark) ?>"><meta property="og:type" content="website"><meta property="og:site_name" content="<?= h($S['brand']) ?>"><meta property="og:title" content="<?= h($ttl) ?>"><meta property="og:description" content="<?= h(mb_substr($d, 0, 160)) ?>">
<?php if (!empty($ogimage)): ?><meta property="og:image" content="<?= h($base . $ogimage) ?>"><?php endif; ?>
<meta name="theme-color" content="<?= h($S['color_bg']) ?>"><link rel="stylesheet" href="/assets/site.css?v=<?= @filemtime(ROOT . '/assets/site.css') ?>">
<script type="application/ld+json"><?= str_replace('<', '\u003c', json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?></script></head>
<body><a href="#main" class="skip">Skip to content</a>
<header class="site-header"><div class="container header-row">
<a href="/" class="brand" aria-label="<?= h($S['brand']) ?> home"><img src="<?= h($mark) ?>" alt="" width="44" height="44"><span class="brand-text"><b><?= h($S['brand']) ?></b><small><?= h($S['tagline']) ?></small></span></a>
<nav class="nav-desktop" aria-label="Primary"><?php foreach ($nav as $n): ?><a href="<?= $n[0] ?>"<?= $on($n[0]) ? ' aria-current="page"' : '' ?>><?= $n[1] ?></a><?php endforeach; ?></nav>
<a href="/contact" class="btn btn-primary header-cta"><?= h($S['cta_text']) ?></a>
<button type="button" class="btn btn-ghost menu-btn" id="menu-btn" aria-expanded="false" aria-controls="mobile-nav" aria-label="Open menu">☰</button></div>
<nav id="mobile-nav" class="container nav-mobile" aria-label="Mobile" hidden><?php foreach ($nav as $n): ?><a href="<?= $n[0] ?>"<?= $on($n[0]) ? ' aria-current="page"' : '' ?>><?= $n[1] ?></a><?php endforeach; ?><a href="/contact" class="btn btn-primary"><?= h($S['cta_text']) ?></a></nav></header>
<main id="main"><?= $content ?></main>
<footer class="site-footer"><div class="container"><div class="footer-grid">
<div class="stack"><strong class="footer-brand"><?= h($S['brand']) ?></strong><?php if ($S['address']): ?><p class="small"><?= h($S['address']) ?></p><?php endif; ?></div>
<nav aria-label="Footer"><ul><?php foreach ($nav as $n): ?><li><a href="<?= $n[0] ?>"><?= $n[1] ?></a></li><?php endforeach; ?></ul></nav>
<ul><?php if ($S['phone']): ?><li><a href="tel:<?= h(preg_replace('/[^\d+]/', '', $S['phone'])) ?>"><?= h($S['phone']) ?></a></li><?php endif; ?><?php if ($S['email']): ?><li><a href="mailto:<?= h($S['email']) ?>"><?= h($S['email']) ?></a></li><?php endif; ?><?php if ($S['hours']): ?><li class="small"><?= h($S['hours']) ?></li><?php endif; ?>
<?php foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn'] as $k => $l) if ($S[$k]): ?><li><a href="<?= h($S[$k]) ?>" target="_blank" rel="noopener noreferrer"><?= $l ?></a></li><?php endif; ?></ul></div>
<div class="footer-bottom small">© <?= date('Y') ?> <?= h($S['company']) ?>. All rights reserved.</div></div></footer>
<script src="/assets/site.js" defer></script><?php if (!empty($scripts)) foreach ($scripts as $s): ?><script src="<?= h($s) ?>" defer></script><?php endforeach; ?></body></html>
