<?php
include('include/check.php');
$pageTitle = 'Email Candidate';

// কোন application-এর candidate-কে email
$appId = isset($_GET['app']) ? (int)$_GET['app'] : 0;
$app = $conn->query("SELECT job_applications.*, jobs.title, users.id AS seeker_user, users.name, users.email
                     FROM job_applications
                     JOIN jobs ON jobs.id = job_applications.job_id
                     JOIN seekers ON seekers.id = job_applications.seeker_id
                     JOIN users ON users.id = seekers.user_id
                     WHERE job_applications.id = $appId AND jobs.company_id = $companyId")->fetch_assoc();

if (!$app) {
  header("Location: applicants.php");
  exit;
}

$error = '';

// Status অনুযায়ী আগে থেকে লেখা subject আর message
if ($app['status'] == 'interview') {
  $subject = 'Interview invitation: ' . $app['title'];
  $message = "Dear " . $app['name'] . ",\n\nThank you for applying for " . $app['title'] . " at " . $company['name'] . ".\nWe would like to invite you for an interview.\n\nDate: \nTime: \nPlace: " . $company['address'] . "\n\nBest regards,\n" . $_SESSION['name'] . "\n" . $company['name'];
} else {
  $subject = 'You have been shortlisted: ' . $app['title'];
  $message = "Dear " . $app['name'] . ",\n\nGood news! You have been shortlisted for " . $app['title'] . " at " . $company['name'] . ".\nWe will contact you soon with the next steps.\n\nBest regards,\n" . $_SESSION['name'] . "\n" . $company['name'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $subject = trim($_POST['subject']);
  $message = trim($_POST['message']);

  if ($subject == '' || $message == '') {
    $error = 'Subject and message are required.';
  } else {
    // PHP mail() দিয়ে email পাঠানো। Laragon-এ Mail Catcher-এ দেখা যাবে।
    $headers = "From: " . $company['name'] . " <" . $_SESSION['email'] . ">\r\n";
    $headers .= "Reply-To: " . $_SESSION['email'] . "\r\n";
    @mail($app['email'], $subject, $message, $headers);

    // Seeker যেন dashboard-এও দেখতে পায়, তাই notification
    $note = $conn->real_escape_string($company['name'] . ' sent you an email: ' . $subject);
    $conn->query("INSERT INTO notifications (user_id, message) VALUES ({$app['seeker_user']}, '$note')");

    header("Location: applicants.php?sent=1");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Candidate | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>Email <?php echo $app['name']; ?></h2><p>About: <?php echo $app['title']; ?> · Status: <?php echo $statusLabel[$app['status']]; ?></p></div>
    <a href="applicants.php" class="btn btn-light">Back</a>
  </div>

  <?php if ($error != '') { ?><div class="alert alert-danger"><span><?php echo $error; ?></span></div><?php } ?>

  <form class="card" action="" method="post">
    <div class="card-body">
      <div class="form-group"><label class="form-label">To</label><input class="form-control" value="<?php echo $app['name'] . ' <' . $app['email'] . '>'; ?>" readonly></div>
      <div class="form-group"><label class="form-label">Subject <span class="req">*</span></label><input class="form-control" name="subject" value="<?php echo htmlspecialchars($subject); ?>" required></div>
      <div class="form-group"><label class="form-label">Message <span class="req">*</span></label><textarea class="form-control" name="message" rows="12" required><?php echo htmlspecialchars($message); ?></textarea></div>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Send Email</button></div>
    </div>
  </form>
</main>
<?php include('include/footer.php'); ?>
