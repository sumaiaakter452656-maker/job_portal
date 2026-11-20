<?php // Executive: coloured header band on top, two columns below ?>
<style>
  .c4 { font-family: "Segoe UI", Arial, sans-serif; color: #1e293b; min-height: 297mm; }
  .c4 .band { background: linear-gradient(135deg, #0c4a6e, #0284c7); color: #fff; padding: 14mm 16mm 12mm; }
  .c4 .band h1 { margin: 0; font-size: 30px; }
  .c4 .band .sub { color: #facc15; font-size: 15px; font-weight: 600; margin-top: 4px; }
  .c4 .band .contact { margin-top: 10px; font-size: 12.5px; color: #e0f2fe; }
  .c4 .band .contact span { margin-right: 16px; }
  .c4 .body { display: grid; grid-template-columns: 1fr 62mm; gap: 12mm; padding: 12mm 16mm; }
  .c4 h2 { font-size: 13px; letter-spacing: 1.5px; text-transform: uppercase; color: #0284c7; margin: 0 0 8px; }
  .c4 section { margin-bottom: 16px; }
  .c4 .job { margin-bottom: 10px; }
  .c4 .job b { font-size: 14px; }
  .c4 .meta { font-size: 12.5px; color: #64748b; }
  .c4 p { font-size: 13.5px; line-height: 1.55; margin: 0; }
  .c4 .box { background: #f0f9ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 14px; }
  .c4 .box p { font-size: 12.5px; margin-bottom: 4px; }
  .c4 .bar { height: 5px; background: #bae6fd; border-radius: 3px; margin: 2px 0 7px; }
  .c4 .bar i { display: block; height: 5px; width: 80%; background: #0284c7; border-radius: 3px; }
</style>
<div class="c4">
  <div class="band">
    <h1><?php echo e($cv['name']); ?></h1>
    <?php if ($cv['headline']) { ?><div class="sub"><?php echo e($cv['headline']); ?><?php if ($cv['years']) echo ' · ' . $cv['years'] . '+ years experience'; ?></div><?php } ?>
    <div class="contact">
      <?php if ($cv['email']) { ?><span>✉ <?php echo e($cv['email']); ?></span><?php } ?>
      <?php if ($cv['phone']) { ?><span>☎ <?php echo e($cv['phone']); ?></span><?php } ?>
      <?php if ($cv['city']) { ?><span>⌂ <?php echo e($cv['city']); ?></span><?php } ?>
    </div>
  </div>
  <div class="body">
    <div>
      <?php if ($cv['summary']) { ?><section><h2>Summary</h2><p><?php echo nl2br(e($cv['summary'])); ?></p></section><?php } ?>
      <?php if ($cv['experiences']) { ?><section><h2>Experience</h2>
        <?php foreach ($cv['experiences'] as $x) { ?><div class="job"><b><?php echo e($x['designation']); ?></b> — <?php echo e($x['company_name']); ?><div class="meta"><?php echo cv_dates($x['start_date'], $x['end_date'], $x['is_current']); ?></div></div><?php } ?>
      </section><?php } ?>
      <?php if ($cv['projects']) { ?><section><h2>Projects</h2>
        <?php foreach ($cv['projects'] as $x) { ?><div class="job"><b><?php echo e($x['title']); ?></b><div class="meta"><?php echo e($x['organization']); ?><?php $d = cv_dates($x['start_date'], $x['end_date']); if ($d) echo ' · ' . $d; ?></div></div><?php } ?>
      </section><?php } ?>
      <?php if ($cv['educations']) { ?><section><h2>Education</h2>
        <?php foreach ($cv['educations'] as $x) { ?><div class="job"><b><?php echo e($x['degree_title']); ?></b><div class="meta"><?php echo e($x['institution']); ?><?php if ($x['year']) echo ' · ' . e($x['year']); ?><?php if ($x['result']) echo ' · ' . e($x['result']); ?></div></div><?php } ?>
      </section><?php } ?>
    </div>
    <div>
      <?php if ($cv['skills']) { ?><div class="box"><h2>Skills</h2><?php foreach ($cv['skills'] as $s) { ?><p><?php echo e($s); ?></p><div class="bar"><i></i></div><?php } ?></div><?php } ?>
      <?php if ($cv['languages']) { ?><div class="box"><h2>Languages</h2><?php foreach ($cv['languages'] as $x) { ?><p><?php echo e($x['title']); ?><?php if ($x['level']) echo ' — ' . e($x['level']); ?></p><?php } ?></div><?php } ?>
      <?php if ($cv['certificates']) { ?><div class="box"><h2>Certificates</h2><?php foreach ($cv['certificates'] as $x) { ?><p><b><?php echo e($x['title']); ?></b><br><?php echo e($x['organization']); ?></p><?php } ?></div><?php } ?>
    </div>
  </div>
</div>
