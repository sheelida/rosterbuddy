// $(document).ready(
//     () => {
//      $('#signin-form').on('submit',(event)=>{
//          event.preventDefault();
//          //create a spinner image
//          const spinner = `<img class="spinner" src="images/loadingSpinner.gif">`;
//          $('button[name="signin"]').append(spinner);
         
         
         
//          //get the form data
//          //email field
//          let eml = $('#email').val();
//          let pwd = $('#password').val();
//          //create a data object
//          let logindata = {email: eml, password: pwd}
//          //send the data via ajax request to handler: /ajax/login.ajax.php
//         $.ajax(
//             {url: '/ajax/login.ajax.php', method: 'post', dataType: 'json', data: logindata}
             
             
             
//         )
//          .done((response)=>{
//              //remove spinner
//              $('.spinner').remove();
//              if(response.success == true){
//                  //login is successful
//                  //take user to home page
//                  window.location.href = '/index.php';
                 
//              }
//              else{
//                  //login failed
//                  console.log('failed');
                 
//              }
//          })
         
//      });
//     }
// );
