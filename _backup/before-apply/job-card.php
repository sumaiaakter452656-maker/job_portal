<?php
// একটা job-এর card। while loop-এর ভেতরে include করা হয়, তাই $row আগে থেকেই থাকে।

// Logo না থাকলে company-র নামের প্রথম ২ অক্ষর দেখাবো
$short = strtoupper(substr($row['company_name'], 0, 2));

// Salary লেখা
if ($row['salary_min'] && $row['salary_max']) {
  $salary = '৳' . number_format($row['salary_min']) . ' – ' . number_format($row['salary_max']);
} else if ($row['salary_min']) {
  $salary = '৳' . number_format($row['salary_min']);
} else {
  $salary = 'Negotiable';
}

// full_time -> Full Time
$type = ucwords(str_replace('_', ' ', $row['job_type']));
?>
<!-- পুরো card-এ click করলেই details পেজ খুলবে -->
<div class="job-card" style="cursor:pointer" onclick="location.href='job-details.php?id=<?php echo $row['id']; ?>'">
  <div class="job-card-head">
    <?php if ($row['logo']) { ?>
      <img class="company-logo" src="uploads/logos/<?php echo $row['logo']; ?>" alt="">
    <?php } else { ?>
      <div class="company-logo" style="background:#0f766e"><?php echo $short; ?></div>
    <?php } ?>
    <div class="job-card-info">
      <h3><a href="job-details.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h3>
      <p class="muted"><?php echo $row['company_name']; ?></p>
    </div>
    <button class="icon-btn" data-toggle-save title="Save job" onclick="event.stopPropagation()"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
  </div>
  <div class="job-meta">
    <span><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><?php echo $row['city_name'] ? $row['city_name'] : 'Bangladesh'; ?></span>
    <span><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg><?php echo $salary; ?></span>
    <span><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Deadline: <?php echo date('d M Y', strtotime($row['deadline'])); ?></span>
  </div>
  <div class="job-card-foot">
    <div class="tags">
      <span class="badge badge-primary"><?php echo $type; ?></span>
      <?php if ($row['is_featured']) { ?><span class="badge badge-warning">Featured</span><?php } ?>
      <?php if ($row['category_name']) { ?><span class="tag"><?php echo $row['category_name']; ?></span><?php } ?>
    </div>
    <a class="btn btn-sm btn-outline" href="job-details.php?id=<?php echo $row['id']; ?>">Apply Now</a>
  </div>
</div>
