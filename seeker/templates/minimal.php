<?php // Minimal: plain, small section names on the left, lots of white space ?>
<style>
  .c3 { padding: 22mm 22mm; font-family: "Helvetica Neue", Arial, sans-serif; color: #111827; }
  .c3 h1 { font-size: 34px; font-weight: 300; margin: 0; letter-spacing: -0.5px; }
  .c3 .sub { font-size: 15px; color: #6b7280; margin: 4px 0 2px; }
  .c3 .contact { font-size: 12.5px; color: #6b7280; margin-bottom: 26px; }
  .c3 .sec { display: grid; grid-template-columns: 34mm 1fr; gap: 10px; padding: 14px 0; border-top: 1px solid #e5e7eb; }
  .c3 .label { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #9ca3af; padding-top: 2px; }
  .c3 .it { margin-bottom: 9px; font-size: 13.5px; }
  .c3 .it b { font-weight: 600; }
  .c3 .gray { color: #6b7280; font-size: 12.5px; }
  .c3 p { margin: 0; font-size: 13.5px; line-height: 1.6; }
</style>
<div class="c3">
  <h1><?php echo e($cv['name']); ?></h1>
  <?php if ($cv['headline']) { ?><div class="sub"><?php echo e($cv['headline']); ?></div><?php } ?>
  <div class="contact"><?php echo e(implode('   /   ', array_filter(array($cv['email'], $cv['phone'], $cv['city'])))); ?></div>

  <?php if ($cv['summary']) { ?><div class="sec"><div class="label">About</div><p><?php echo nl2br(e($cv['summary'])); ?></p></div><?php } ?>
  <?php if ($cv['experiences']) { ?><div class="sec"><div class="label">Experience</div><div>
    <?php foreach ($cv['experiences'] as $x) { ?><div class="it"><b><?php echo e($x['designation']); ?></b>, <?php echo e($x['company_name']); ?><br><span class="gray"><?php echo cv_dates($x['start_date'], $x['end_date'], $x['is_current']); ?></span></div><?php } ?>
  </div></div><?php } ?>
  <?php if ($cv['educations']) { ?><div class="sec"><div class="label">Education</div><div>
    <?php foreach ($cv['educations'] as $x) { ?><div class="it"><b><?php echo e($x['degree_title']); ?></b>, <?php echo e($x['institution']); ?><br><span class="gray"><?php echo e(trim($x['year'] . ' ' . ($x['result'] ? '· ' . $x['result'] : ''))); ?></span></div><?php } ?>
  </div></div><?php } ?>
  <?php if ($cv['projects']) { ?><div class="sec"><div class="label">Projects</div><div>
    <?php foreach ($cv['projects'] as $x) { ?><div class="it"><b><?php echo e($x['title']); ?></b><?php if ($x['organization']) echo ', ' . e($x['organization']); ?><br><span class="gray"><?php echo cv_dates($x['start_date'], $x['end_date']); ?></span></div><?php } ?>
  </div></div><?php } ?>
  <?php if ($cv['skills']) { ?><div class="sec"><div class="label">Skills</div><p><?php echo e(implode('  ·  ', $cv['skills'])); ?></p></div><?php } ?>
  <?php if ($cv['certificates']) { ?><div class="sec"><div class="label">Certificates</div><div>
    <?php foreach ($cv['certificates'] as $x) { ?><div class="it"><?php echo e($x['title']); ?><?php if ($x['organization']) echo ' <span class="gray">— ' . e($x['organization']) . '</span>'; ?></div><?php } ?>
  </div></div><?php } ?>
  <?php if ($cv['languages']) { ?><div class="sec"><div class="label">Languages</div>
    <p><?php $l = array(); foreach ($cv['languages'] as $x) { $l[] = e($x['title']) . ($x['level'] ? ' (' . e($x['level']) . ')' : ''); } echo implode(', ', $l); ?></p></div><?php } ?>
</div>
