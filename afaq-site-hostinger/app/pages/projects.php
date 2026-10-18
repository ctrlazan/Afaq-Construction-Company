<?php defined('AFAQ') || exit;
$cat = (string)($_GET['category'] ?? ''); $st = (string)($_GET['status'] ?? '');
render('projects', ['title' => 'Projects', 'desc' => 'Completed, ongoing and upcoming construction projects.', 'cat' => $cat, 'st' => $st, 'list' => projects_pub($cat, $st), 'cats' => project_categories(), 'any' => (bool)row('SELECT id FROM projects WHERE published=1 LIMIT 1')]);
