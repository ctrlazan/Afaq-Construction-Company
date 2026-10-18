<?php
define('AFAQ', 1); define('ROOT', dirname(__DIR__));
require __DIR__ . '/config.php';
error_reporting(E_ALL); ini_set('display_errors', '0'); ini_set('log_errors', '1');
if (!is_dir(ROOT . '/data')) @mkdir(ROOT . '/data', 0755, true);
ini_set('error_log', ROOT . '/data/error.log');
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
session_name('afaq'); session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'secure' => $https, 'httponly' => true, 'samesite' => 'Lax']); session_start();
header('X-Content-Type-Options: nosniff'); header('X-Frame-Options: SAMEORIGIN'); header('Referrer-Policy: strict-origin-when-cross-origin');

function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function db() {
  static $d; if ($d) return $d;
  $d = new PDO('sqlite:' . ROOT . '/data/afaq.sqlite');
  $d->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $d->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $d->exec('PRAGMA busy_timeout=5000; PRAGMA foreign_keys=ON');
  $d->exec("CREATE TABLE IF NOT EXISTS settings(k TEXT PRIMARY KEY, v TEXT);
   CREATE TABLE IF NOT EXISTS admins(id INTEGER PRIMARY KEY, email TEXT UNIQUE, pass TEXT, created TEXT);
   CREATE TABLE IF NOT EXISTS services(id INTEGER PRIMARY KEY, slug TEXT UNIQUE, name TEXT, summary TEXT, content TEXT, features TEXT, image TEXT, sort INTEGER DEFAULT 0, published INTEGER DEFAULT 0);
   CREATE TABLE IF NOT EXISTS projects(id INTEGER PRIMARY KEY, slug TEXT UNIQUE, name TEXT, category TEXT, location TEXT, client TEXT, status TEXT DEFAULT 'COMPLETED', start_date TEXT, end_date TEXT, description TEXT, scope TEXT, video TEXT, image TEXT, gallery TEXT DEFAULT '[]', featured INTEGER DEFAULT 0, published INTEGER DEFAULT 0, sort INTEGER DEFAULT 0);
   CREATE TABLE IF NOT EXISTS presets(id INTEGER PRIMARY KEY, kind TEXT, name TEXT, length_mm REAL, width_mm REAL, height_mm REAL, joint_mm REAL DEFAULT 10, source TEXT, active INTEGER DEFAULT 1, sort INTEGER DEFAULT 0);
   CREATE TABLE IF NOT EXISTS inquiries(id INTEGER PRIMARY KEY, name TEXT, phone TEXT, email TEXT, message TEXT, status TEXT DEFAULT 'new', created TEXT);
   CREATE TABLE IF NOT EXISTS hits(k TEXT, t INTEGER)");
  return $d;
}
function q($sql, $a = []) { $s = db()->prepare($sql); $s->execute($a); return $s; }
function rows($sql, $a = []) { return q($sql, $a)->fetchAll(); }
function row($sql, $a = []) { $r = q($sql, $a)->fetch(); return $r ?: null; }

function defaults() { return ['company' => 'AFAQ Construction Company', 'brand' => 'AFAQ BUILD', 'tagline' => 'Construction Company, Katlang', 'description' => '', 'address' => 'Katlang, Mardan, Khyber Pakhtunkhwa, Pakistan', 'phone' => '', 'whatsapp' => '', 'email' => '', 'hours' => '', 'maps' => '', 'facebook' => '', 'instagram' => '', 'tiktok' => '', 'youtube' => '', 'linkedin' => '', 'color_primary' => '#C9A227', 'color_bg' => '#16181A', 'color_secondary' => '#1F2124', 'cta_text' => 'Request a Quote', 'hero_headline' => 'Building What Matters.', 'hero_sub' => 'AFAQ BUILD is a construction company based in Katlang, Mardan, Khyber Pakhtunkhwa.', 'statement' => 'A construction company rooted in Katlang, Mardan.', 'intro' => 'Share your plans with us and we will get back to you. Our services, projects and construction calculators are all on this website.', 'logo' => '', 'hero_image' => '']; }
function settings() {
  static $S; if ($S) return $S; $S = defaults();
  try { foreach (rows('SELECT k,v FROM settings') as $r) if (isset($S[$r['k']]) && trim((string)$r['v']) !== '') $S[$r['k']] = $r['v']; } catch (Throwable $e) { error_log($e->getMessage()); }
  foreach (['color_primary', 'color_bg', 'color_secondary'] as $c) if (!preg_match('/^#[0-9a-fA-F]{6}$/', $S[$c])) $S[$c] = defaults()[$c];
  return $S;
}
function site_url() { global $https; return ($https ? 'https' : 'http') . '://' . preg_replace('/[^a-z0-9.:-]/i', '', $_SERVER['HTTP_HOST'] ?? 'localhost'); }
function img($name) { return $name ? '/uploads/' . rawurlencode($name) : ''; }
function redirect($to) { header('Location: ' . $to); exit; }
function slugify($s) { $s = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', (string)$s), '-')); return substr($s, 0, 80) ?: 'item'; }
function unique_slug($table, $base, $except = 0) { $b = slugify($base); $s = $b; $n = 2; while (row("SELECT id FROM $table WHERE slug=? AND id<>?", [$s, $except])) $s = $b . '-' . $n++; return $s; }
function csrf() { if (empty($_SESSION['t'])) $_SESSION['t'] = bin2hex(random_bytes(16)); return '<input type="hidden" name="_t" value="' . $_SESSION['t'] . '">'; }
function csrf_ok() { return !empty($_SESSION['t']) && hash_equals($_SESSION['t'], (string)($_POST['_t'] ?? '')); }
function flash($m = null, $ok = true) { if ($m !== null) { $_SESSION['f'] = [$m, $ok]; return; } $f = $_SESSION['f'] ?? null; unset($_SESSION['f']); return $f; }
function rate_limit($key, $max, $win) { $t = time(); q('DELETE FROM hits WHERE t<?', [$t - 86400]); $n = (int)q('SELECT COUNT(*) FROM hits WHERE k=? AND t>?', [$key, $t - $win])->fetchColumn(); if ($n >= $max) return false; q('INSERT INTO hits(k,t) VALUES(?,?)', [$key, $t]); return true; }
function ip() { return $_SERVER['REMOTE_ADDR'] ?? '0'; }
function render($view, $v = [], $layout = 'layout') { extract($v); $S = settings(); ob_start(); require ROOT . '/app/views/' . $view . '.php'; $content = ob_get_clean(); require ROOT . '/app/views/' . $layout . '.php'; }
function not_found() { http_response_code(404); render('404', ['title' => 'Page not found']); }
function paras($t) { $o = ''; foreach (preg_split('/\n{2,}/', trim(str_replace("\r", '', (string)$t))) as $p) if (trim($p) !== '') $o .= '<p>' . nl2br(h(trim($p))) . '</p>'; return $o; }

/** Validates, optionally downsizes, stores an uploaded image. Returns [status, nameOrError]: status true=ok, false=error, null=no file. */
function upload_image($f) {
  if (!is_array($f) || !isset($f['error']) || $f['error'] === UPLOAD_ERR_NO_FILE) return [null, null];
  if ($f['error'] !== UPLOAD_ERR_OK) return [false, 'Upload failed. The file may be too large for the server.'];
  if ($f['size'] > 5 * 1048576) return [false, 'The image is larger than 5 MB.'];
  $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']); $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
  $info = @getimagesize($f['tmp_name']);
  if (!$ext || !$info) return [false, 'Only JPG, PNG or WebP images are allowed.'];
  if (!is_dir(ROOT . '/uploads')) @mkdir(ROOT . '/uploads', 0755, true);
  $name = bin2hex(random_bytes(12)) . '.' . $ext; $dest = ROOT . '/uploads/' . $name;
  $made = false;
  if ($info[0] > 2000 && function_exists('imagecreatetruecolor') && ($ext !== 'webp' || function_exists('imagecreatefromwebp'))) {
    $src = $ext === 'jpg' ? @imagecreatefromjpeg($f['tmp_name']) : ($ext === 'png' ? @imagecreatefrompng($f['tmp_name']) : @imagecreatefromwebp($f['tmp_name']));
    if ($src) { $w = 1920; $hh = (int)round($info[1] * $w / $info[0]); $dst = imagecreatetruecolor($w, $hh);
      if ($ext !== 'jpg') { imagealphablending($dst, false); imagesavealpha($dst, true); }
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $hh, $info[0], $info[1]);
      $made = $ext === 'jpg' ? imagejpeg($dst, $dest, 84) : ($ext === 'png' ? imagepng($dst, $dest, 6) : imagewebp($dst, $dest, 84)); }
  }
  if (!$made && !move_uploaded_file($f['tmp_name'], $dest)) return [false, 'Could not save the image on the server.'];
  return [true, $name];
}
function delete_upload($name) { if ($name && preg_match('/^[a-f0-9]{24}\.(jpg|png|webp)$/', $name)) @unlink(ROOT . '/uploads/' . $name); }
