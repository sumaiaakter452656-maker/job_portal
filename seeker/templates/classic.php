<?php // Classic: এক কলাম, মাঝখানে নাম, serif শিরোনাম ?>
<style>
  .c1 { padding: 18mm 20mm; font-family: Georgia, "Times New Roman", serif; color: #1f2937; }
  .c1 h1 { text-align: center; font-size: 30px; margin: 0; letter-spacing: 1px; }
  .c1 .sub { text-align: center; color: #475569; margin: 4px 0 6px; font-size: 15px; }
  .c1 .contact { text-align: center; font-size: 12.5px; color: #475569; padding-bottom: 10px; border-bottom: 2px solid #1f2937; }
  .c1 h2 { font-size: 14px; text-transform: uppercase; letter-spacing: 2px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px; margin: 18px 0 8px; }
  .c1 .row { display: flex; justify-content: space-between; font-size: 13.5px; }
  .c1 .row b { font-size: 14px; }
  .c1 .muted { color: #64748b; font-size: 12.5px; }
  .c1 p { font-size: 13.5px; line-height: 1.55; margin: 0 0 6px; }
  .c1 .item { margin-bottom: 9px; }
</style>
<div class="c1">
  <h1><?php echo e($cv['name']); ?></h1>
  <?php if ($cv['headline']) { ?><div class="sub"><?php echo e($cv['headline']); ?></div><?php } ?>
  <div class="contact"><?php echo e(implode('  •  ', array_filter(array($cv['email'], $cv['phone'], $cv['city'])))); ?></div>

  <?php if ($cv['summary']) { ?><h2>Profile</h2><p><?php echo nl2br(e($cv['summary'])); ?></p><?php } ?>

  <?php if ($cv['experiences']) { ?><h2>Experience</h2>
    <?php foreach ($cv['experiences'] as $x) { ?>
      <div class="item"><div class="row"><b><?php echo e($x['designation']); ?></b><span class="muted"><?php echo cv_dates($x['start_date'], $x['end_date'], $x['is_current']); ?></span></div>
      <div class="muted"><?php echo e($x['company_name']); ?></div></div>
    <?php } ?>
  <?php } ?>

  <?php if ($cv['educations']) { ?><h2>Education</h2>
    <?php foreach ($cv['educations'] as $x) { ?>
      <div class="item"><div class="row"><b><?php echo e($x['degree_title']); ?> (<?php echo e($x['level']); ?>)</b><span class="muted"><?php echo e($x['year']); ?></span></div>
      <div class="muted"><?php echo e($x['institution']); ?><?php if ($x['result']) echo ' — ' . e($x['result']); ?></div></div>
    <?php } ?>
  <?php } ?>

  <?php if ($cv['projects']) { ?><h2>Projects</h2>
    <?php foreach ($cv['projects'] as $x) { ?>
      <div class="item"><div class="row"><b><?php echo e($x['title']); ?></b><span class="muted"><?php echo cv_dates($x['start_date'], $x['end_date']); ?></span></div>
      <?php if ($x['organization']) { ?><div class="muted"><?php echo e($x['organization']); ?></div><?php } ?></div>
    <?php } ?>
  <?php } ?>

  <?php if ($cv['skills']) { ?><h2>Skills</h2><p><?php echo e(implode(', ', $cv['skills'])); ?></p><?php } ?>

  <?php if ($cv['certificates']) { ?><h2>Certificates</h2>
    <?php foreach ($cv['certificates'] as $x) { ?><p><b><?php echo e($x['title']); ?></b><?php if ($x['organization']) echo ' — ' . e($x['organization']); ?> <span class="muted"><?php echo cv_dates($x['start_date'], $x['end_date']); ?></span></p><?php } ?>
  <?php } ?>

  <?php if ($cv['languages']) { ?><h2>Languages</h2>
    <p><?php $l = array(); foreach ($cv['languages'] as $x) { $l[] = e($x['title']) . ($x['level'] ? ' (' . e($x['level']) . ')' : ''); } echo implode(', ', $l); ?></p>
  <?php } ?>
</div>
