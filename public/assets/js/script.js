document.addEventListener('DOMContentLoaded', function () {
  const togglePassword = document.querySelector('#togglepassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
  });

  const toggleConfirmPassword = document.querySelector('#toggleconfirmpassword');
  const confirmPassword = document.querySelector('#confirm-password');

  toggleConfirmPassword.addEventListener('click', function () {
      const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPassword.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
  });
});