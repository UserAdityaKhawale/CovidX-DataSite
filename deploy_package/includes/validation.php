<?php
declare(strict_types=1);

function validate_field(string $field, mixed $value): ?string
{
    if (!is_string($value)) return 'Enter a valid value.';
    $value = trim($value);
    $rules = [
        'full_name' => ['/^[A-Za-z]+(?:[ -][A-Za-z]+)*$/', 2, 50, 'Use 2–50 letters, spaces, or hyphens.'],
        'username' => ['/^[A-Za-z][A-Za-z0-9_]{3,15}$/', 4, 16, 'Use 4–16 characters, starting with a letter.'],
        'email' => [null, 3, 254, 'Enter a valid email address.'],
        'password' => ['/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', 8, 128, 'Use 8+ characters with uppercase, lowercase, a number, and a symbol.'],
        'phone' => ['/^[6-9]\d{9}$/', 10, 10, 'Enter a 10-digit Indian mobile number starting 6–9.'],
        'age' => ['/^(?:[1-9]|[1-9]\d|1[01]\d|120)$/', 1, 3, 'Enter a whole number from 1 to 120.'],
        'city' => ['/^(?=.*[A-Za-z])[A-Za-z ]{2,40}$/', 2, 40, 'Use 2–40 letters and spaces, with at least one letter.'],
        'comment' => [null, 1, 500, 'Write 1–500 characters without HTML tags.'],
        'vaccination_status' => [null, 1, 24, 'Choose a vaccination status.'],
        'vaccine_or_dose' => [null, 1, 80, 'Choose a dose or vaccine option.'],
        'preferred_date' => [null, 10, 10, 'Choose a valid date.'],
    ];
    if (!isset($rules[$field])) return 'Unknown field.';
    [$pattern, $min, $max, $message] = $rules[$field];
    $length = mb_strlen($value, 'UTF-8');
    if ($length < $min || $length > $max) return $message;
    if ($pattern !== null && preg_match($pattern, $value) !== 1) return $message;
    if ($field === 'email' && filter_var($value, FILTER_VALIDATE_EMAIL) === false) return $message;
    if ($field === 'comment' && (preg_match('/<[^>]*>/', $value) === 1 || trim($value) === '')) return $message;
    if ($field === 'vaccination_status' && !in_array($value, ['Not vaccinated', 'Partially vaccinated', 'Fully vaccinated', 'Booster received'], true)) return $message;
    if ($field === 'vaccine_or_dose' && !in_array($value, ['Not applicable', 'Dose 1', 'Dose 2', 'Booster'], true)) return $message;
    if ($field === 'preferred_date') {
        $date = DateTime::createFromFormat('!Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value || $date < new DateTime('today')) return $message;
    }
    return null;
}

function validate_registration(array $input): array
{
    $fields = ['full_name' => 'Full name', 'username' => 'Username', 'email' => 'Email', 'password' => 'Password', 'phone' => 'Phone', 'age' => 'Age', 'city' => 'City', 'vaccination_status' => 'Vaccination status'];
    $errors = [];
    foreach ($fields as $key => $label) {
        $error = validate_field($key, $input[$key] ?? null);
        if ($error) $errors[$key] = $error;
    }
    return $errors;
}
