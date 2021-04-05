console.log('js/login.js is loaded');

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
        //console.log(data);
        storeSession(data);
      });
    }
  )
  .catch(function(err) {
    console.log('Fetch Error :-S', err);
  });
  
}

function storeSession(data) {
  console.log(data[0].userID, data[0].userName);
  localStorage.setItem('fromUserID', data[0].userID);
  localStorage.setItem('fromUserName', data[0].userName);

}
