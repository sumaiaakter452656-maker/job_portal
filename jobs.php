<?php
session_start();
include('dbconfig.php');

// ===== 1. Read the filters from the form =====
$q        = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$city     = isset($_GET['city']) ? (int)$_GET['city'] : 0;
$category = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$type     = isset($_GET['type']) ? $_GET['type'] : '';
$min      = isset($_GET['min']) ? (int)$_GET['min'] : 0;
$max      = isset($_GET['max']) ? (int)$_GET['max'] : 0;
$sort     = isset($_GET['sort']) ? $_GET['sort'] : 'new';

// ===== 2. Build the WHERE part =====
$where = "WHERE jobs.status = 'approved' AND jobs.deadline >= CURDATE()";

if ($q != '') {
  $where .= " AND (jobs.title LIKE '%$q%' OR jobs.description LIKE '%$q%' OR companies.name LIKE '%$q%')";
}
if ($city > 0) {
  $where .= " AND jobs.city_id = $city";
}
if ($category > 0) {
  $where .= " AND jobs.category_id = $category";
}
// job_type can only be one of these 5
$allTypes = array('full_time', 'part_time', 'contract', 'internship', 'remote');
if (in_array($type, $allTypes)) {
  $where .= " AND jobs.job_type = '$type'";
}
if ($min > 0) {
  $where .= " AND jobs.salary_max >= $min";
}
if ($max > 0) {
  $where .= " AND jobs.salary_min <= $max";
}

// ===== 3. Sorting =====
if ($sort == 'salary_high') {
  $order = "ORDER BY jobs.salary_max DESC";
} else if ($sort == 'salary_low') {
  $order = "ORDER BY jobs.salary_min ASC";
} else if ($sort == 'deadline') {
  $order = "ORDER BY jobs.deadline ASC";
} else {
  $order = "ORDER BY jobs.is_featured DESC, jobs.id DESC";
}

// ===== 4. Pagination =====
$perPage = 6;
$pageNo  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($pageNo < 1) $pageNo = 1;
$offset  = ($pageNo - 1) * $perPage;

$from = "FROM jobs
         JOIN companies ON companies.id = jobs.company_id
         LEFT JOIN cities ON cities.id = jobs.city_id
         LEFT JOIN categories ON categories.id = jobs.category_id";

// Total number of jobs found
$total = $conn->query("SELECT COUNT(*) AS c $from $where")->fetch_assoc()['c'];
$totalPages = ceil($total / $perPage);

// Jobs for this page
$jobs = $conn->query("SELECT jobs.*, companies.name AS company_name, companies.logo,
                             cities.name AS city_name, categories.name AS category_name
                      $from $where $order LIMIT $offset, $perPage");

// For the filter dropdowns
$cities     = $conn->query("SELECT * FROM cities ORDER BY name");
$categories = $conn->query("SELECT * FROM categories ORDER BY name");

// To keep the other filters in the pagination links
$params = $_GET;
unset($params['page']);
$link = 'jobs.php?' . http_build_query($params) . '&page=';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Find Jobs | JobHub</title>
  <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>
<body>
<?php include('navber.php'); ?>
<main>

<section class="page-header">
  <div class="container">
    <ul class="breadcrumb"><li><a href="index.php">Home</a></li><li>Jobs</li></ul>
    <h1>Find Jobs</h1><p class="muted mb-0 mt-1">Showing the latest openings from verified employers</p>
  </div>
</section>

<section class="section-sm">
  <div class="container listing-layout">
    <!-- FILTERS -->
    <aside class="card filter-box">
      <form class="card-body" action="jobs.php" method="get">
        <div class="filter-group">
          <h4>Keyword</h4>
          <div class="input-icon"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input type="text" name="q" class="form-control" placeholder="Title, skill or company" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"></div>
        </div>
        <div class="filter-group">
          <h4>Location</h4>
          <select class="form-control" name="city">
            <option value="">All locations</option>
            <?php while ($c = $cities->fetch_assoc()) { ?>
              <option value="<?php echo $c['id']; ?>" <?php if ($city == $c['id']) echo 'selected'; ?>><?php echo $c['name']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="filter-group">
          <h4>Category</h4>
          <select class="form-control" name="category">
            <option value="">All categories</option>
            <?php while ($cat = $categories->fetch_assoc()) { ?>
              <option value="<?php echo $cat['id']; ?>" <?php if ($category == $cat['id']) echo 'selected'; ?>><?php echo $cat['name']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="filter-group">
          <h4>Job Type</h4>
          <label class="check"><input type="radio" name="type" value="" <?php if ($type == '') echo 'checked'; ?>> Any</label>
          <?php foreach ($allTypes as $t) { ?>
            <label class="check"><input type="radio" name="type" value="<?php echo $t; ?>" <?php if ($type == $t) echo 'checked'; ?>> <?php echo ucwords(str_replace('_', ' ', $t)); ?></label>
          <?php } ?>
        </div>
        <div class="filter-group">
          <h4>Salary (BDT / month)</h4>
          <div class="form-row">
            <input class="form-control" type="number" name="min" placeholder="Min" value="<?php if ($min) echo $min; ?>">
            <input class="form-control" type="number" name="max" placeholder="Max" value="<?php if ($max) echo $max; ?>">
          </div>
        </div>
        <div class="filter-group">
          <h4>Sort by</h4>
          <select class="form-control" name="sort">
            <option value="new" <?php if ($sort == 'new') echo 'selected'; ?>>Newest first</option>
            <option value="salary_high" <?php if ($sort == 'salary_high') echo 'selected'; ?>>Salary: high to low</option>
            <option value="salary_low" <?php if ($sort == 'salary_low') echo 'selected'; ?>>Salary: low to high</option>
            <option value="deadline" <?php if ($sort == 'deadline') echo 'selected'; ?>>Deadline: soonest</option>
          </select>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Apply Filters</button>
        <a href="jobs.php" class="btn btn-ghost btn-block mt-1">Reset</a>
      </form>
    </aside>

    <!-- RESULTS -->
    <div>
      <div class="listing-toolbar">
        <p class="mb-0">Found <strong><?php echo $total; ?></strong> jobs</p>
      </div>

      <div class="job-list">
        <?php
        if ($total == 0) {
          echo '<div class="card"><div class="card-body">No jobs found. Try another search.</div></div>';
        }
        while ($row = $jobs->fetch_assoc()) {
          include('job-card.php');
        }
        ?>
      </div>

      <?php if ($totalPages > 1) { ?>
      <ul class="pagination">
        <?php if ($pageNo > 1) { ?>
          <li><a href="<?php echo $link . ($pageNo - 1); ?>">&laquo;</a></li>
        <?php } ?>

        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
          <?php if ($i == $pageNo) { ?>
            <li><span class="active"><?php echo $i; ?></span></li>
          <?php } else { ?>
            <li><a href="<?php echo $link . $i; ?>"><?php echo $i; ?></a></li>
          <?php } ?>
        <?php } ?>

        <?php if ($pageNo < $totalPages) { ?>
          <li><a href="<?php echo $link . ($pageNo + 1); ?>">&raquo;</a></li>
        <?php } ?>
      </ul>
      <?php } ?>
    </div>
  </div>
</section>
</main>
<?php include('footer.php'); ?>
