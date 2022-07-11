const submitButtonClickHandler = (ev) => {
  ev.preventDefault();
  ev.currentTarget.removeEventListener('click', submitButtonClickHandler);
  ev.currentTarget.disabled = true;
  if(ev.currentTarget.parentNode) {
    ev.currentTarget.parentNode.submit();
  }
}
if (document.querySelector('#signup')) {
  const button = document.querySelector('#signup');
  button.addEventListener('click', submitButtonClickHandler);
}
if (document.querySelector('#addpost')) {
  const button = document.querySelector('#addpost');
  button.addEventListener('click', submitButtonClickHandler);
}
if (document.querySelector('#submitrecovery')) {
  const button = document.querySelector('#submitrecovery');
  button.addEventListener('click', submitButtonClickHandler);
}
if (document.querySelector('#changeuser')) {
  const button = document.querySelector('#changeuser');
  button.addEventListener('click', submitButtonClickHandler);
}

if (document.querySelector('.post-errors')) {
  setTimeout(()=> {
    if (document.querySelector('.post-errors')) {
      document.querySelector('.post-errors').style.display = 'none';
    }
  }, 5000);
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
  img.classList.remove('user-avatar');
  img.classList.remove('post-user-avatar');
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

const getImages = async () => {
    const parameters = {
      url: `${window.location.origin}/loft/blog/blog/postapi`,
      data: {
        method: 'POST',
        body: JSON.stringify(['img']),
      }
    };
    const response = await fetch(parameters.url, parameters.data);
    if (response.ok) {
      return await response.text();
    } else {
      return '';
  }
}
const images = [...document.querySelectorAll('img[id*="imgImg"]')] || [];
const avatars = [...document.querySelectorAll('img[id*="avtImg"]')] || [];
if (images.length || avatars.length) {
  getImages().then((response) => {
    if (response) {
      const imagesAll = JSON.parse(response);
      for (const imageKey in imagesAll) {
        const imageNode = images.find((imageNode) => imageNode.id.includes(imageKey));
        if (imageNode) {
          imageNode.src = imagesAll[imageKey].image;
          imageNode.classList.remove('img-border');
        }
        const avatarNode = avatars.find((avatarNode) => avatarNode.id.includes(imageKey));
        if (avatarNode) {
          avatarNode.src = imagesAll[imageKey].avatar;
          avatarNode.classList.remove('avatar-border');
        }
      }
    }
  })
}
const enableBlog = () => {
  const user = document.querySelector('.user');
  const blog = document.querySelector('.blog');
  if (user && blog) {
    user.classList.remove('display-none');
    blog.classList.remove('display-none');
  }
  window.removeEventListener('load', enableBlog);
}
window.addEventListener('load', enableBlog);


