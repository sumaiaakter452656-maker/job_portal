<?php // Modern: বাঁ দিকে রঙিন sidebar, ডান দিকে মূল তথ্য ?>
<style>
  .c2 { display: flex; min-height: 297mm; font-family: "Segoe UI", Arial, sans-serif; }
  .c2 .side { width: 72mm; background: #0c4a6e; color: #e0f2fe; padding: 16mm 9mm; }
  .c2 .side h1 { color: #fff; font-size: 25px; line-height: 1.2; margin: 0 0 6px; }
  .c2 .side .sub { color: #facc15; font-weight: 600; font-size: 14px; margin-bottom: 18px; }
  .c2 .side h3 { color: #fff; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; margin: 20px 0 8px; border-bottom: 1px solid rgba(255,255,255,.25); padding-bottom: 4px; }
  .c2 .side p { font-size: 12.5px; margin: 0 0 6px; word-break: break-word; }
  .c2 .chip { display: inline-block; background: rgba(255,255,255,.14); border-radius: 12px; padding: 3px 9px; margin: 0 4px 6px 0; font-size: 12px; }
  .c2 .main { flex: 1; padding: 16mm 12mm; color: #1e293b; }
  .c2 .main h2 { font-size: 15px; color: #0c4a6e; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 10px; }
  .c2 .main section { margin-bottom: 18px; }
  .c2 .entry { border-left: 3px solid #0284c7; padding-left: 10px; margin-bottom: 11px; }
  .c2 .entry b { font-size: 14px; }
  .c2 .meta { font-size: 12.5px; color: #64748b; }
  .c2 .main p { font-size: 13.5px; line-height: 1.55; margin: 0; }
</style>
<div class="c2">
  <div class="side">
    <h1><?php echo e($cv['name']); ?></h1>
    <?php if ($cv['headline']) { ?><div class="sub"><?php echo e($cv['headline']); ?></div><?php } ?>
    <h3>Contact</h3>
    <?php if ($cv['email']) { ?><p>✉ <?php echo e($cv['email']); ?></p><?php } ?>
    <?php if ($cv['phone']) { ?><p>☎ <?php echo e($cv['phone']); ?></p><?php } ?>
    <?php if ($cv['city']) { ?><p>⌂ <?php echo e($cv['city']); ?>, Bangladesh</p><?php } ?>
    <?php if ($cv['skills']) { ?><h3>Skills</h3><?php foreach ($cv['skills'] as $s) { ?><span class="chip"><?php echo e($s); ?></span><?php } ?><?php } ?>
    <?php if ($cv['languages']) { ?><h3>Languages</h3><?php foreach ($cv['languages'] as $x) { ?><p><?php echo e($x['title']); ?><?php if ($x['level']) echo ' — ' . e($x['level']); ?></p><?php } ?><?php } ?>
    <?php if ($cv['certificates']) { ?><h3>Certificates</h3><?php foreach ($cv['certificates'] as $x) { ?><p><?php echo e($x['title']); ?><br><small><?php echo e($x['organization']); ?></small></p><?php } ?><?php } ?>
  </div>
  <div class="main">
    <?php if ($cv['summary']) { ?><section><h2>About me</h2><p><?php echo nl2br(e($cv['summary'])); ?></p></section><?php } ?>
    <?php if ($cv['experiences']) { ?><section><h2>Work experience</h2>
      <?php foreach ($cv['experiences'] as $x) { ?><div class="entry"><b><?php echo e($x['designation']); ?></b><div class="meta"><?php echo e($x['company_name']); ?> · <?php echo cv_dates($x['start_date'], $x['end_date'], $x['is_current']); ?></div></div><?php } ?>
    </section><?php } ?>
    <?php if ($cv['educations']) { ?><section><h2>Education</h2>
      <?php foreach ($cv['educations'] as $x) { ?><div class="entry"><b><?php echo e($x['degree_title']); ?></b><div class="meta"><?php echo e($x['institution']); ?><?php if ($x['year']) echo ' · ' . e($x['year']); ?><?php if ($x['result']) echo ' · ' . e($x['result']); ?></div></div><?php } ?>
    </section><?php } ?>
    <?php if ($cv['projects']) { ?><section><h2>Projects</h2>
      <?php foreach ($cv['projects'] as $x) { ?><div class="entry"><b><?php echo e($x['title']); ?></b><div class="meta"><?php echo e($x['organization']); ?><?php $d = cv_dates($x['start_date'], $x['end_date']); if ($d) echo ' · ' . $d; ?></div></div><?php } ?>
    </section><?php } ?>
  </div>
</div>
