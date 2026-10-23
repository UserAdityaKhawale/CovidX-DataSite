const fs = require('node:fs');
const path = require('node:path');
const cases = require('./regex-cases.js');
fs.writeFileSync(path.join(__dirname, 'regex-cases.json'), JSON.stringify(cases, null, 2) + '\n');
