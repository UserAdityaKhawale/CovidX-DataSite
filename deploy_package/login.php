<?php
require __DIR__ . '/includes/bootstrap.php';
if (current_user()) redirect('index.php');
$pageTitle='Log in'; $error=''; $username='';
if (request_is_post()) {
    $username = is_string($_POST['username'] ?? null) ? trim($_POST['username']) : '';
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    if (!verify_csrf()) $error='Your form session expired. Refresh the page and try again.';
    elseif ($username==='' || $password==='') $error='Enter your username and password.';
    else {
        $db=db_or_error(); $stmt=$db?->prepare('SELECT id,full_name,username,email,password_hash FROM users WHERE username = :username LIMIT 1');
        if (!$stmt) $error='Sign-in is temporarily unavailable. Check that MySQL is running.';
        else { $stmt->execute(['username'=>$username]); $account=$stmt->fetch(); if ($account && password_verify($password,$account['password_hash'])) { session_regenerate_id(true); unset($account['password_hash']); $_SESSION['user']=$account; $_SESSION['last_activity']=time(); flash('success','Welcome back, '.$account['username'].'.'); redirect('index.php'); } $error='The username or password was not accepted.'; }
    }
}
require __DIR__ . '/includes/header.php';
?>
<main class="container auth-layout login-layout"><section class="auth-aside"><span class="eyebrow">WELCOME BACK</span><h1>Your public-health<br><span class="accent">resource hub.</span></h1><p>Sign in to submit a vaccination demonstration record or join the comments section.</p><div class="auth-points"><span>🔒 &nbsp; Passwords are stored as hashes</span><span>✳ &nbsp; Data is labeled with its source</span></div></section><section class="form-card login-card"><div class="form-heading"><span class="eyebrow">MEMBER ACCESS</span><h2>Log in</h2><p>Enter the account details you registered with.</p></div><?php if($error): ?><div class="alert error" role="alert"><?= h($error) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><label class="field"><span>Username</span><input name="username" autocomplete="username" required maxlength="16" value="<?= h($username) ?>"></label><label class="field"><span>Password</span><input type="password" name="password" autocomplete="current-password" required maxlength="128"></label><button class="button primary full-button" type="submit">Log in <span aria-hidden="true">→</span></button><p class="form-switch">New here? <a href="register.php">Create an account</a></p></form></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
