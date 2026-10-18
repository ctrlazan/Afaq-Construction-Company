<?php
if (PHP_SAPI === 'cli-server') { $p = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); if ($p !== '/' && is_file(__DIR__ . $p) && substr($p, -4) !== '.php') return false; }
require __DIR__ . '/app/bootstrap.php';
require __DIR__ . '/app/data.php';
$path = '/' . trim((string)parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$m = $_SERVER['REQUEST_METHOD'];
try {
  if ($path === '/') return require __DIR__ . '/app/pages/home.php';
  if ($path === '/services') return require __DIR__ . '/app/pages/services.php';
  if (preg_match('#^/services/([a-z0-9-]+)$#', $path, $x)) { $slug = $x[1]; return require __DIR__ . '/app/pages/service.php'; }
  if ($path === '/projects') return require __DIR__ . '/app/pages/projects.php';
  if (preg_match('#^/projects/([a-z0-9-]+)$#', $path, $x)) { $slug = $x[1]; return require __DIR__ . '/app/pages/project.php'; }
  if ($path === '/calculators') return require __DIR__ . '/app/pages/calculators.php';
  if ($path === '/contact') return require __DIR__ . '/app/pages/contact.php';
  if ($path === '/sitemap.xml') return require __DIR__ . '/app/pages/sitemap.php';
  if ($path === '/robots.txt') { header('Content-Type: text/plain'); echo "User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: " . site_url() . "/sitemap.xml\n"; return; }
  if ($path === '/admin' || strpos($path, '/admin/') === 0) return require __DIR__ . '/app/admin.php';
  not_found();
} catch (Throwable $e) {
  error_log($e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
  http_response_code(500); render('error', ['title' => 'Something went wrong']);
}
