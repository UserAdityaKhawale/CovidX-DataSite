<?php
require __DIR__ . '/includes/bootstrap.php';
if (current_user()) redirect('index.php');
$pageTitle = 'Create account'; $errors = []; $values = [];
if (request_is_post()) {
    if (!verify_csrf()) $errors['_form'] = 'Your form session expired. Refresh the page and try again.';
    $values = array_map(static fn($v) => is_string($v) ? trim($v) : '', $_POST);
    $errors += validate_registration($values);
    if (!$errors) {
        $db = db_or_error();
        if (!$db) $errors['_form'] = 'We could not save your account. Check that MySQL is running.';
        else {
            $check = $db->prepare('SELECT username,email FROM users WHERE username = :username OR email = :email'); $check->execute(['username'=>$values['username'], 'email'=>$values['email']]); $existing = $check->fetch();
            if ($existing) $errors['_form'] = 'An account with those details already exists. Try another username or email.';
            else {
                try {
                    $insert = $db->prepare('INSERT INTO users (full_name,username,email,password_hash,phone,age,city,vaccination_status) VALUES (:full_name,:username,:email,:password_hash,:phone,:age,:city,:vaccination_status)');
                    $insert->execute(['full_name'=>$values['full_name'],'username'=>$values['username'],'email'=>$values['email'],'password_hash'=>password_hash($values['password'], PASSWORD_DEFAULT),'phone'=>$values['phone'],'age'=>(int)$values['age'],'city'=>$values['city'],'vaccination_status'=>$values['vaccination_status']]);
                    flash('success','Your account is ready. Sign in to continue.'); redirect('login.php');
                } catch (PDOException $error) { error_log('Registration failed: '.$error->getMessage()); $errors['_form']='We could not save your account. Review your details and try again.'; }
            }
        }
    }
}
require __DIR__ . '/includes/header.php';
?>
<main class="container auth-layout"><section class="auth-aside"><span class="eyebrow">JOIN THE COMMUNITY</span><h1>Make an account.<br><span class="accent">Stay informed.</span></h1><p>Use the portal’s information tools and take part in the academic demonstration.</p><div class="auth-points"><span>✳ &nbsp; Transparent data notes</span><span>✚ &nbsp; Helpful health resources</span><span>⌁ &nbsp; Community discussion</span></div><small>Use fictional details when demonstrating this academic project.</small></section><section class="form-card"><div class="form-heading"><span class="eyebrow">CREATE AN ACCOUNT</span><h2>Register</h2><p>Fields marked <b>*</b> are required.</p></div><?php if (isset($errors['_form'])): ?><div class="alert error" role="alert"><?= h($errors['_form']) ?></div><?php endif; ?>
<form method="post" data-validate="register" novalidate><?= csrf_field() ?>
<div class="form-grid"><label class="field"><span>Full name <b>*</b></span><input name="full_name" autocomplete="name" required minlength="2" maxlength="50" value="<?= h($values['full_name'] ?? '') ?>" aria-describedby="err-full_name"><small id="err-full_name" class="field-error"><?= h($errors['full_name'] ?? '') ?></small></label>
<label class="field"><span>Username <b>*</b></span><input name="username" autocomplete="username" required minlength="4" maxlength="16" value="<?= h($values['username'] ?? '') ?>" aria-describedby="err-username"><small id="err-username" class="field-error"><?= h($errors['username'] ?? '') ?></small></label>
<label class="field"><span>Email address <b>*</b></span><input type="email" name="email" autocomplete="email" required maxlength="254" value="<?= h($values['email'] ?? '') ?>" aria-describedby="err-email"><small id="err-email" class="field-error"><?= h($errors['email'] ?? '') ?></small></label>
<label class="field"><span>Password <b>*</b></span><input type="password" name="password" autocomplete="new-password" required minlength="8" maxlength="128" aria-describedby="err-password"><small id="err-password" class="field-error"><?= h($errors['password'] ?? '8+ characters, uppercase, lowercase, number, and symbol.') ?></small></label>
<label class="field"><span>Phone <b>*</b></span><input type="tel" name="phone" inputmode="numeric" autocomplete="tel" required maxlength="10" value="<?= h($values['phone'] ?? '') ?>" aria-describedby="err-phone"><small id="err-phone" class="field-error"><?= h($errors['phone'] ?? '') ?></small></label>
<label class="field"><span>Age <b>*</b></span><input type="number" name="age" min="1" max="120" required value="<?= h($values['age'] ?? '') ?>" aria-describedby="err-age"><small id="err-age" class="field-error"><?= h($errors['age'] ?? '') ?></small></label>
<label class="field"><span>City <b>*</b></span><input name="city" autocomplete="address-level2" required maxlength="40" value="<?= h($values['city'] ?? '') ?>" aria-describedby="err-city"><small id="err-city" class="field-error"><?= h($errors['city'] ?? '') ?></small></label>
<label class="field"><span>Vaccination status <b>*</b></span><select name="vaccination_status" required aria-describedby="err-vaccination_status"><option value="">Choose status</option><?php foreach (['Not vaccinated','Partially vaccinated','Fully vaccinated','Booster received'] as $option): ?><option <?= ($values['vaccination_status'] ?? '')===$option?'selected':'' ?>><?= h($option) ?></option><?php endforeach; ?></select><small id="err-vaccination_status" class="field-error"><?= h($errors['vaccination_status'] ?? '') ?></small></label></div>
<button class="button primary full-button" type="submit">Create account <span aria-hidden="true">→</span></button><p class="form-switch">Already registered? <a href="login.php">Log in</a></p></form></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
