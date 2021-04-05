console.log('js/messages.js is loaded');


/*
** structure of main functions **
  * see if user is logged in : send them to login page
  * use localStorage to keep track of logins & selected user (not 100% secure)
  * list users
  * see if a user is already targeted for messages : suggest selecting a user
  * list messages from "fromuser" & "touser"
  * send & receive message...

//note to self (April 4)
  -get all messages from & to other user
  -display in a cool way
  -order by date

  -select other user (hardcoded for now)

*/

//fetch users
const usersSection = document.querySelector('#users');

function fetchUsers() {
  usersSection.innerHTML = '';

  fetch('app/list_users.php')
  .then(
    function(response) {
      if (response.status !== 200) {
        console.log('uhoh, we got listUsers problems: ' +
          response.status);
        return;
      }

      // Examine the text in the response
      response.json().then(function(data) {
        console.log(data);
        displayUsers(data);
      });
    }
  )
  .catch(function(err) {
    console.log('Fetch Error :-S', err);
  });

}
//fetch users
fetchUsers();

function displayUsers(data) {
  usersSection.innerHTML = '';
   //console.log(data);
  data.forEach(function (user) {
    console.log(user);
    let a = document.createElement('a');
    a.innerHTML = user.username;
    a.setAttribute('data-touserid', user.userID);
    a.addEventListener('click', selectUser);
    usersSection.append(a);
  }) 
}

//select user to chat to
function selectUser(event) {
  //hmm, now to explain "this"
  console.log(this.dataset.touserid);
  localStorage.setItem('toUserID', this.dataset.touserid);
  //reload the proper messages
  readMessages();

}

//read messages
const messageSection = document.querySelector('#messages');


function readMessages() {
  let from = localStorage.getItem('fromUserID');
  let to = localStorage.getItem('toUserID');
  //ideally should also reverify login on server side

  let messageData = new FormData();
  messageData.append('fromuser', from);
  messageData.append('touser', to);

  fetch('app/read_messages.php',{
    body: messageData,
    method: "post"
  })
  .then(
    function(response) {
      if (response.status !== 200) {
        console.log('uhoh, we got readMessages problems: ' +
          response.status);
        return;
      }

      // Examine the text in the response
      response.json().then(function(data) {
        //console.log(data);
        displayMessages(data);
      });
    }
  )
  .catch(function(err) {
    console.log('Fetch Error :-S', err);
  });
}
//call on load?
readMessages();


//display messages from db
function displayMessages(data) {
  messageSection.innerHTML = '';
  //console.log(data);
  data.forEach(function (msg) {
    console.log(msg);
    let article = document.createElement('article');
    article.innerHTML = msg.message;
    messageSection.append(article);
  })
}

//send a message
const messageForm = document.querySelector('#message-form');
messageForm.addEventListener('submit', sendMessage);

function sendMessage(event) {
  event.preventDefault();
  
  //add check to see if localStorage variables exist?
  let formData = new FormData(messageForm);
  formData.append('fromuser', localStorage.getItem('fromUserID'));
  formData.append('touser', localStorage.getItem('toUserID'));
  

  fetch('app/send_message.php',{
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