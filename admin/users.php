<?php
include('include/check.php');
include('../dbconfig.php');


$role = isset($_GET['role']) ? $_GET['role'] : '';
$q    = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

$where = "WHERE 1";
if ($role == 'seeker' || $role == 'employer' || $role == 'admin') {
  $where .= " AND role = '$role'";
}
if ($q != '') {
  $where .= " AND (name LIKE '%$q%' OR email LIKE '%$q%')";
}

$users = $conn->query("SELECT * FROM users $where ORDER BY created_at DESC");

$statusColor = array('active' => 'badge-success', 'pending' => 'badge-warning', 'blocked' => 'badge-danger');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<!-- ================= SIDEBAR (Admin) ================= -->
<?php include('include/leftbar.php'); ?>
  <!-- ================= TOPBAR ================= -->
  <?php include('include/header.php'); ?>
  <main class="dash-content">
    <div class="page-actions">
      <div><h2>All users</h2><p>Job seekers, employers and admins.</p></div>
      <form action="" method="get" class="input-icon">
        <input class="form-control" name="q" placeholder="Search by name or email" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
      </form>
    </div>

    <!-- Role filter -->
    <div class="tabs mb-2">
      <a class="tab-btn <?php if ($role == '') echo 'active'; ?>" href="users.php">All</a>
      <a class="tab-btn <?php if ($role == 'seeker') echo 'active'; ?>" href="users.php?role=seeker">Job Seekers</a>
      <a class="tab-btn <?php if ($role == 'employer') echo 'active'; ?>" href="users.php?role=employer">Employers</a>
      <a class="tab-btn <?php if ($role == 'admin') echo 'active'; ?>" href="users.php?role=admin">Admins</a>
    </div>

    <div class="card">
      <div class="table-wrap">
        <table class="table">
          <thead><tr><th>User</th><th>Phone</th><th>Role</th><th>Joined</th><th>Status</th></tr></thead>
          <tbody>
          <?php if ($users->num_rows == 0) { ?>
            <tr><td colspan="5" class="muted">No user found.</td></tr>
          <?php } ?>
          <?php while ($u = $users->fetch_assoc()) { ?>
            <tr>
              <td><div class="cell-user"><span class="avatar sm"><?php echo strtoupper(substr($u['name'], 0, 2)); ?></span>
                <div><strong><?php echo $u['name']; ?></strong><small><?php echo $u['email']; ?></small></div></div></td>
              <td><?php echo $u['phone'] ? $u['phone'] : '-'; ?></td>
              <td><span class="badge badge-primary"><?php echo ucfirst($u['role']); ?></span></td>
              <td><?php echo date('d M Y', strtotime($u['created_at'])); ?></td>
              <td><span class="badge badge-dot <?php echo $statusColor[$u['status']]; ?>"><?php echo ucfirst($u['status']); ?></span></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  <footer class="dash-footer">&copy; 2026 JobHub — Dashboard</footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
