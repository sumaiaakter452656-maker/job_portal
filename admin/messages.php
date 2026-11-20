<?php
include('include/check.php');
include('../dbconfig.php');
include('../contact_table.php');
contact_setup($conn);

// ===== মুছে ফেলা =====
if (isset($_GET['delete'])) {
  $mid = (int)$_GET['delete'];
  $conn->query("DELETE FROM contact_messages WHERE id = $mid");
  header("Location: messages.php");
  exit;
}

// ===== একটা message খোলা (খুললেই "read" হয়ে যায়) =====
$open = null;
if (isset($_GET['view'])) {
  $mid = (int)$_GET['view'];
  $conn->query("UPDATE contact_messages SET is_read = 1 WHERE id = $mid");
  $open = $conn->query("SELECT * FROM contact_messages WHERE id = $mid")->fetch_assoc();
}

$messages = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages | Admin | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/leftbar.php'); ?>
<?php include('include/header.php'); ?>
<main class="dash-content">
  <div class="page-actions"><div><h2>Contact messages</h2><p>Messages sent from the Contact page.</p></div></div>

  <?php if ($open) { ?>
    <div class="card mb-3">
      <div class="card-header"><h3><?php echo htmlspecialchars($open['subject'] ? $open['subject'] : '(no subject)'); ?></h3>
        <a class="btn btn-sm btn-light" href="messages.php">Close</a></div>
      <div class="card-body">
        <p class="muted small mb-1">From <b><?php echo htmlspecialchars($open['name']); ?></b> &lt;<?php echo htmlspecialchars($open['email']); ?>&gt; · <?php echo date('d M Y, h:i A', strtotime($open['created_at'])); ?></p>
        <p><?php echo nl2br(htmlspecialchars($open['message'])); ?></p>
        <a class="btn btn-primary" href="mailto:<?php echo htmlspecialchars($open['email']); ?>?subject=<?php echo rawurlencode('Re: ' . $open['subject']); ?>">Reply by email</a>
      </div>
    </div>
  <?php } ?>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>From</th><th>Subject</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if ($messages->num_rows == 0) { ?><tr><td colspan="4" class="muted">No messages yet.</td></tr><?php } ?>
        <?php while ($m = $messages->fetch_assoc()) { ?>
          <tr>
            <td><?php if (!$m['is_read']) echo '<b>'; ?><?php echo htmlspecialchars($m['name']); ?><?php if (!$m['is_read']) echo '</b> <span class="badge badge-warning">New</span>'; ?><br><small class="muted"><?php echo htmlspecialchars($m['email']); ?></small></td>
            <td><?php echo htmlspecialchars($m['subject'] ? $m['subject'] : '(no subject)'); ?></td>
            <td><?php echo date('d M Y', strtotime($m['created_at'])); ?></td>
            <td><div class="actions">
              <a class="btn btn-sm btn-light" href="messages.php?view=<?php echo $m['id']; ?>">Open</a>
              <a class="btn btn-sm btn-light" href="messages.php?delete=<?php echo $m['id']; ?>" onclick="return confirm('Delete this message?')">Delete</a>
            </div></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
