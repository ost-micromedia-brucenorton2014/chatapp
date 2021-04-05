console.log('js/signout.js is loaded');

let signoutButton = document.querySelector('#signout');
signoutButton.addEventListener('click', signOut);

function signOut(event) {
  event.preventDefault();
  localStorage.clear();
  readMessages();
}