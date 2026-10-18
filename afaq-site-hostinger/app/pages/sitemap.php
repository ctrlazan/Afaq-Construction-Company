<?php defined('AFAQ') || exit; header('Content-Type: application/xml; charset=utf-8'); $b = site_url(); echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
foreach (['', '/services', '/projects', '/calculators', '/contact'] as $p) echo '<url><loc>' . h($b . $p) . '</loc></url>';
foreach (services_pub() as $s) echo '<url><loc>' . h($b . '/services/' . $s['slug']) . '</loc></url>';
foreach (projects_pub() as $s) echo '<url><loc>' . h($b . '/projects/' . $s['slug']) . '</loc></url>'; echo '</urlset>';
