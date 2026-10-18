<?php defined('AFAQ') || exit; $s = row('SELECT * FROM services WHERE slug=? AND published=1', [$slug]); if (!$s) return not_found();
render('service', ['title' => $s['name'], 'desc' => $s['summary'], 's' => $s, 'ogimage' => $s['image'] ? img($s['image']) : '']);
