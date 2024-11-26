document.getElementById('checkout-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    
    const form = event.target;
    const errors = {};
  
    // Validate first name
    const firstName = form.firstName.value.trim();
    if (!firstName) {
      errors.firstName = 'First name is required.';
    }
  
    // Validate last name
    const lastName = form.lastName.value.trim();
    if (!lastName) {
      errors.lastName = 'Last name is required.';
    }
  
    // Validate email
    const email = form.email.value.trim();
    if (email && !/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(email)) {
      errors.email = 'Please provide a valid email address.';
    }
  
    // Validate address
    const address = form.address.value.trim();
    if (!address) {
      errors.address = 'Address is required.';
    }
  
    // Validate country
    const country = form.country.value.trim();
    if (!country) {
      errors.country = 'Country is required.';
    }
  
    // Validate state
    const state = form.state.value.trim();
    if (!state) {
      errors.state = 'State is required.';
    }
  
    // Validate zip code
    const zip = form.zip.value.trim();
    if (!zip) {
      errors.zip = 'Zip code is required.';
    } else if (!/^[0-9]{5}$/.test(zip)) {
      errors.zip = 'Please provide a valid 5-digit zip code.';
    }
  
    // Validate shipping method
    const shippingMethod = form.shippingMethod.value;
    if (!shippingMethod) {
        errors.shippingMethod = 'Please select a shipping method.';
        const inputs = document.querySelectorAll('[name="shippingMethod"]');
        inputs.forEach(input => input.classList.add('is-invalid')); // Agrega clase a todos los radios
      } else {
        const inputs = document.querySelectorAll('[name="shippingMethod"]');
        inputs.forEach(input => input.classList.remove('is-invalid')); // Elimina clase si es válido
      }
  
    // Validate data protection checkbox
    const dataProtection = form.dataProtection.checked;
    if (!dataProtection || dataProtection == '') {
      errors.dataProtection = 'You must accept data protection.';
    }
  
    // Handle errors and display messages
    const errorFields = ['firstName', 'lastName', 'email', 'address', 'country', 'state', 'zip', 'shippingMethod', 'dataProtection'];
    errorFields.forEach(field => {
      const errorElement = document.getElementById(`${field}-error`);
      const inputElement = document.getElementById(field);
  
      if (errors[field]) {
        errorElement.textContent = errors[field];
        if (inputElement) {
          inputElement.classList.add('is-invalid');
        }
      } else {
        if (errorElement) errorElement.textContent = '';
        if (inputElement) inputElement.classList.remove('is-invalid');
      }
    });
  
    // If no errors, submit the form
    if (Object.keys(errors).length === 0) {
      form.submit();
    }
  });
  