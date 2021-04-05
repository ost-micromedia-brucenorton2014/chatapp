console.log('js/signup.js is loaded');

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