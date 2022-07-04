const signUpButtonClickHandler = (ev) => {
  ev.preventDefault();
  ev.currentTarget.disabled = true;
  document.querySelector('#register').submit();
}
if (document.querySelector('#signup')) {
  const signUpButton = document.querySelector('#signup');
  signUpButton.addEventListener('click', signUpButtonClickHandler);
}
