<?php
require __DIR__ . '/../includes/validation.php';
$casesFile = __DIR__ . '/regex-cases.json';
if (!is_file($casesFile)) { fwrite(STDERR, "Generate JSON fixtures first: node tests/export-regex-cases.js\n"); exit(2); }
$cases = json_decode((string)file_get_contents($casesFile), true, flags: JSON_THROW_ON_ERROR);
$passed = 0;
foreach ($cases as $test) {
    $actual = validate_field($test['field'], $test['input']) === null;
    $ok = $actual === $test['expected'];
    if ($ok) $passed++;
    printf("%s\t%s\t%s\t%s\t%s\t%s\n", $test['id'], $test['field'], $test['expected'] ? 'ACCEPT' : 'REJECT', $actual ? 'ACCEPT' : 'REJECT', $ok ? 'PASS' : 'FAIL', $test['remarks']);
}
$failed = count($cases) - $passed;
printf("\nPHP/server-side validation cases: %d; passed: %d; failed: %d; pass rate: %.1f%%\n", count($cases), $passed, $failed, count($cases) ? 100 * $passed / count($cases) : 0);
if (count($cases) !== 64 || $failed !== 0) exit(1);
