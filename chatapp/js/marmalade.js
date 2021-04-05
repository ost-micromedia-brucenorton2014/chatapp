console.log('js/marmalade.js is loaded');

//let's fetch a list of users
function listUsers(){
	fetch(`app/list_users.php`)
  .then(
    function(response) {
      if (response.status !== 200) {
        console.log('listUsers problems. Status Code: ' +
          response.status);
        return;
      }

      // Examine the text in the response
      response.json().then(function(data) {
      	console.log(data);
        //displayUsers(data);
      });
    }
  )
  .catch(function(err) {
    console.log('Fetch Error :-S', err);
  });

}

//login a user
const form = document.querySelector('#login-form');
form.addEventListener('submit', loginUser);

function loginUser(event) {
  event.preventDefault();
  let formData = new FormData(form);
  fetch('app/login.php',{
    body: formData,
    method: "post"
  })
  .then(
    function(response) {
      if (response.status !== 200) {
        console.log('uhoh, we got loginUser problems: ' +
          response.status);
        return;
      }

      // Examine the text in the response
      response.json().then(function(data) {
        console.log(data);
      });
    }
  )
  .catch(function(err) {
    console.log('Fetch Error :-S', err);
  });
  
}

//signup a user
const signupForm = document.querySelector('#signup-form');
signupForm.addEventListener('submit', signupUser);

function signupUser(event) {
  event.preventDefault();
  let formData = new FormData(signupForm);
  fetch('app/signup.php',{
    body: formData,
    method: "post"
  })
  .then(
    function(response) {
      if (response.status !== 200) {
        console.log('uhoh, we got signupUser problems: ' +
          response.status);
        return;
      }

      // Examine the text in the response
      response.json().then(function(data) {
        console.log(data);
      });
    }
  )
  .catch(function(err) {
    console.log('Fetch Error :-S', err);
  });
  
}