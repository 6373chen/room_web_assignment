//to be loaded in useraccount.twig
import {Validator} from '/js/modules/validator.module.js';

$(document).ready(
  () => {
    //'input' occurs when use inputs any field in the form
    //we delegate the event listener to the form
    $('#useraccount').on('input', (event) => {
      const target = $(event.target);
      switch( target.attr('name') ){
        case 'username':
          let username = target.val();
          let validUser = ( Validator.username(username) ) ? true : false;
          changeValidationStatus(validUser,target);
          break;
        case 'email':
          let email = target.val();
          let validEmail = ( Validator.email(email) ) ? true : false;
          changeValidationStatus(validEmail,target);
          break;
        case 'password1':
          let password11 = target.val();
          let password21 = $('[name="password2"]').val();
          let validPassword1 = ( Validator.twoPasswords(password11,password21) ) ? true : false;
          if( password11.length > 0 ){
            //change both status
          }
          changeValidationStatus(validPassword1,target);
          break;
        case 'password2':
          let password22 = target.val();
          let password12 = $('[name="password1"]').val();
          let validPassword2 = ( Validator.twoPasswords(password12,password22) ) ? true : false;
          changeValidationStatus(validPassword2,target);
          break;
      }
    });
  }
);

function changeValidationStatus(valid,target){
  if( valid ){
    target.removeClass('is-invalid');
    target.addClass('is-valid');
  }
  else{
    target.removeClass('is-valid');
    target.addClass('is-invalid');
  }
}

function xhrRequest( destinationUrl, data ){
  $.ajax({ 
    url: destinationUrl,
    dataType: 'json',
    method: 'post'
  })
  .done( (response) => {
    return response;
  })
  .fail( (error) => {
    console.log(error);
  });
}