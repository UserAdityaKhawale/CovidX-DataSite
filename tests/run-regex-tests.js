const { validate } = require('../assets/js/validation.js');
const cases = require('./regex-cases.js');
const results = cases.map(test => ({ ...test, actual: validate(test.field, test.input), status: validate(test.field, test.input) === test.expected ? 'PASS' : 'FAIL' }));
for (const test of results) console.log(`${test.id}\t${test.field}\t${test.expected ? 'ACCEPT' : 'REJECT'}\t${test.actual ? 'ACCEPT' : 'REJECT'}\t${test.status}\t${test.remarks}`);
const passed = results.filter(test => test.status === 'PASS').length;
console.log(`\nClient-side validation cases: ${results.length}; passed: ${passed}; failed: ${results.length - passed}; pass rate: ${((passed / results.length) * 100).toFixed(1)}%`);
if (results.length !== 64 || passed !== results.length) process.exitCode = 1;
