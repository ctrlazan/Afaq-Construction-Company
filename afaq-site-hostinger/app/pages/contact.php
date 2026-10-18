<?php defined('AFAQ') || exit; $err = []; $v = ['name' => '', 'phone' => '', 'email' => '', 'message' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($v as $k => $_) $v[$k] = trim(mb_substr((string)($_POST[$k] ?? ''), 0, $k === 'message' ? 2000 : 120));
  if (!csrf_ok()) { flash('Your session expired. Please try again.', false); redirect('/contact'); }
  if ((string)($_POST['website'] ?? '') !== '') { flash('Thank you. We have received your message and will be in touch soon.'); redirect('/contact'); }
  if (mb_strlen($v['name']) < 2) $err['name'] = 'Please enter your name.';
  if ($v['phone'] !== '' && !preg_match('/^\+?[0-9\s\-()]{7,20}$/', $v['phone'])) $err['phone'] = 'Enter a valid phone number.';
  if ($v['email'] !== '' && !filter_var($v['email'], FILTER_VALIDATE_EMAIL)) $err['email'] = 'Enter a valid email address.';
  if ($v['phone'] === '' && $v['email'] === '' && !isset($err['phone'], $err['email'])) $err['phone'] = 'Provide a phone number or an email so we can reply.';
  if (mb_strlen($v['message']) < 10) $err['message'] = 'Please write at least 10 characters.';
  if (!$err && !rate_limit('inq:' . ip(), 5, 3600)) $err['form'] = 'Too many messages from your connection. Please try again later.';
  if (!$err) { try { q('INSERT INTO inquiries(name,phone,email,message,created) VALUES(?,?,?,?,?)', [$v['name'], $v['phone'], $v['email'], $v['message'], date('c')]); flash('Thank you. We have received your message and will be in touch soon.'); redirect('/contact'); }
    catch (Throwable $e) { error_log($e->getMessage()); $err['form'] = 'Something went wrong. Please try again.'; } }
}
render('contact', ['title' => 'Contact', 'desc' => 'Contact ' . settings()['company'], 'err' => $err, 'v' => $v, 'f' => flash()]);
