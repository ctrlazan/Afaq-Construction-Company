<?php defined('AFAQ') || exit;
$B = [[215,215,80,285],[305,105,95,395],[410,215,70,285],[490,305,70,195]]; $g = '';
for ($i = 0; $i <= 16; $i++) $g .= 'M' . ($i * 40) . ' 0V600'; for ($i = 0; $i <= 15; $i++) $g .= 'M0 ' . ($i * 40) . 'H640'; ?>
<svg class="arch <?= h($cls ?? '') ?>" viewBox="0 0 640 600" role="img" aria-label="Architectural line drawing of buildings and a construction crane">
<path d="<?= $g ?>" class="faint"/>
<?php foreach ($B as [$x, $y, $w, $hh]): ?><rect pathLength="1" class="draw" x="<?= $x ?>" y="<?= $y ?>" width="<?= $w ?>" height="<?= $hh ?>"/>
<?php for ($n = 1; $n < floor($hh / 36); $n++): ?><line pathLength="1" class="draw soft" x1="<?= $x ?>" x2="<?= $x + $w ?>" y1="<?= $y + 36 * $n ?>" y2="<?= $y + 36 * $n ?>"/><?php endfor; ?>
<line pathLength="1" class="draw soft" x1="<?= $x + $w / 2 ?>" x2="<?= $x + $w / 2 ?>" y1="<?= $y ?>" y2="<?= $y + $hh ?>"/><?php endforeach; ?>
<polygon pathLength="1" class="draw" points="24,440 112,368 200,440"/><rect pathLength="1" class="draw" x="44" y="440" width="146" height="60"/><rect pathLength="1" class="draw" x="102" y="456" width="30" height="30"/>
<path pathLength="1" class="draw" d="M117 456V486M102 471H132"/><path pathLength="1" class="draw" d="M20 512Q320 470 620 512"/>
<path pathLength="1" class="draw" d="M590 500V70M590 70L450 70M590 70L628 100M590 100L450 70M590 100L628 100M520 70V135M520 135H536"/>
<line pathLength="1" class="draw soft" x1="20" x2="620" y1="540" y2="540"/><path pathLength="1" class="draw soft" d="M20 556H620M20 548V564M620 548V564"/></svg>
