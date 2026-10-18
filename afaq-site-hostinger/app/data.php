<?php defined('AFAQ') || exit;
const STATUSES = ['COMPLETED' => 'Completed', 'ONGOING' => 'Ongoing', 'UPCOMING' => 'Upcoming'];
function services_pub($limit = 100) { return rows('SELECT * FROM services WHERE published=1 ORDER BY sort ASC, name ASC LIMIT ' . (int)$limit); }
function projects_pub($cat = '', $status = '', $limit = 200) {
  $w = 'published=1'; $a = [];
  if ($cat !== '') { $w .= ' AND category=?'; $a[] = $cat; }
  if (isset(STATUSES[$status])) { $w .= ' AND status=?'; $a[] = $status; }
  return rows("SELECT * FROM projects WHERE $w ORDER BY featured DESC, sort ASC, name ASC LIMIT " . (int)$limit, $a);
}
function project_categories() { return array_column(rows("SELECT DISTINCT category FROM projects WHERE published=1 AND category<>'' ORDER BY category"), 'category'); }
function month_label($d) { $t = strtotime((string)$d); return $t ? date('M Y', $t) : ''; }
