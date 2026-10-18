<?php defined('AFAQ') || exit;
$S = settings(); $svc = services_pub(6); $proj = projects_pub('', '', 3);
$facts = array_filter([['Location', $S['address'], ''], ['Phone', $S['phone'], $S['phone'] ? 'tel:' . preg_replace('/[^\d+]/', '', $S['phone']) : ''], ['WhatsApp', $S['whatsapp'], $S['whatsapp'] ? 'https://wa.me/' . preg_replace('/\D/', '', $S['whatsapp']) : ''], ['Email', $S['email'], $S['email'] ? 'mailto:' . $S['email'] : ''], ['Hours', $S['hours'], '']], function ($f) { return $f[1] !== ''; });
$defaultSvc = ['Residential Construction', 'Commercial Construction', 'Renovation & Remodeling', 'Architectural & Structural Work', 'Project Management', 'General Contracting'];
render('home', ['S' => $S, 'svc' => $svc, 'proj' => $proj, 'facts' => $facts, 'defaultSvc' => $defaultSvc, 'title' => '', 'ogimage' => $S['hero_image'] ? img($S['hero_image']) : '/assets/img/logo.jpg']);
