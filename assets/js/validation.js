/* Shared client-side validation rules. PHP validation remains authoritative. */
(function (root) {
  'use strict';
  const rules = {
    full_name: value => /^[A-Za-z]+(?:[ -][A-Za-z]+)*$/.test(value) && value.length >= 2 && value.length <= 50,
    username: value => /^[A-Za-z][A-Za-z0-9_]{3,15}$/.test(value),
    email: value => value.length <= 254 && /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(value),
    password: value => value.length <= 128 && /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/.test(value),
    phone: value => /^[6-9]\d{9}$/.test(value),
    age: value => /^(?:[1-9]|[1-9]\d|1[01]\d|120)$/.test(value),
    city: value => /^(?=.*[A-Za-z])[A-Za-z ]{2,40}$/.test(value),
    comment: value => value.length >= 1 && value.length <= 500 && !/<[^>]*>/.test(value) && value.trim().length > 0,
    vaccination_status: value => ['Not vaccinated','Partially vaccinated','Fully vaccinated','Booster received'].includes(value),
    vaccine_or_dose: value => ['Not applicable','Dose 1','Dose 2','Booster'].includes(value)
  };
  const messages = {
    full_name:'Use 2–50 letters, spaces, or hyphens.', username:'Use 4–16 characters, starting with a letter.',
    email:'Enter a valid email address.', password:'Use 8+ characters with uppercase, lowercase, a number, and a symbol.',
    phone:'Enter a 10-digit Indian mobile number starting 6–9.', age:'Enter a whole number from 1 to 120.',
    city:'Use 2–40 letters and spaces, with at least one letter.', comment:'Write 1–500 characters without HTML tags.',
    vaccination_status:'Choose a vaccination status.', vaccine_or_dose:'Choose a vaccine or dose option.'
  };
  function validate(field, value) {
    value = String(value ?? '').trim();
    if (field === 'comment' && /<[^>]*>/.test(value)) return false;
    return Boolean(rules[field]?.(value));
  }
  if (typeof module !== 'undefined' && module.exports) module.exports = { rules, validate };
  if (typeof document === 'undefined') return;
  document.querySelectorAll('form[data-validate]').forEach(form => {
    form.addEventListener('submit', event => {
      let valid = true;
      form.querySelectorAll('[name]').forEach(field => {
        const ruleName = field.name;
        if (!(ruleName in rules)) return;
        const ok = validate(ruleName, field.value);
        const error = form.querySelector(`#err-${CSS.escape(ruleName)}`) || field.parentElement.querySelector('.field-error');
        if (!ok) {
          valid = false;
          field.setAttribute('aria-invalid','true');
          if (error) error.textContent = messages[ruleName];
        } else {
          field.removeAttribute('aria-invalid');
          if (error) error.textContent = '';
        }
      });
      if (!valid) { event.preventDefault(); form.querySelector('[aria-invalid="true"]')?.focus(); }
    });
  });
})(typeof globalThis !== 'undefined' ? globalThis : this);
