const submitButtonClickHandler = (ev) => {
  ev.preventDefault();
  ev.currentTarget.removeEventListener('click', submitButtonClickHandler);
  ev.currentTarget.disabled = true;
  if(ev.currentTarget.parentNode) {
    ev.currentTarget.parentNode.submit();
  }
}
if (document.querySelector('#signup')) {
  const signUpButton = document.querySelector('#signup');
  signUpButton.addEventListener('click', submitButtonClickHandler);
}
if (document.querySelector('#addpost')) {
  const signUpButton = document.querySelector('#addpost');
  signUpButton.addEventListener('click', submitButtonClickHandler);
}

const imgDiv = document.createElement('div');
document.body.append(imgDiv);
const imgDivClickHandler = () => {
  imgDiv.removeEventListener('click', imgDivClickHandler);
  document.removeEventListener('keydown', imgDivClickHandler);
  imgDiv.innerHTML = '';
  imgDiv.classList.toggle('imgDiv');
}
const imgClickHandler = (ev) => {
  const img = ev.currentTarget.cloneNode();
  img.removeEventListener('click', imgClickHandler);
  img.classList.add('img');
  imgDiv.innerHTML = '';
  imgDiv.append(img);
  imgDiv.classList.toggle('imgDiv');
  imgDiv.addEventListener('click', imgDivClickHandler);
  document.addEventListener('keydown', imgDivClickHandler);
}
if (document.querySelector('img')) {
  const imgs = [...document.querySelectorAll('img')];
  imgs.forEach((img) => {
    img.addEventListener('click', imgClickHandler);
  })
}

