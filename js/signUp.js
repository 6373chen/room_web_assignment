import {Validator} from '/js/modules/validator.module.js';

let validation = { username: false, email: false, password: false };

$(document).ready( () => {
  //disable the submit button
  $('button[type="submit"]').attr('disabled', true );
  watchValidation();
  $('#sign-up').on('input',( event ) => {
    let targetName = $(event.target).attr('name');
    switch(targetName){
      case 'username' :
        if( Validator.username( $(event.target).val() )){
          validation.username = true;
          $(event.target).removeClass('is-invalid');
          $(event.target).addClass('is-valid');
        }
        else{
          validation.username = false;
          $(event.target).addClass('is-invalid');
        }
        break;
      case 'email' :
        if( Validator.email( $(event.target).val() )){
          validation.email = true;
          $(event.target).removeClass('is-invalid');
          $(event.target).addClass('is-valid');
        }
        else{
          validation.email = false;
          $(event.target).addClass('is-invalid');
        }
        break;
      case 'password' :
        if( Validator.password( $(event.target).val() )){
          validation.password = true;
          $(event.target).removeClass('is-invalid');
          $(event.target).addClass('is-valid');
        }
        else{
          validation.password = false;
          $(event.target).addClass('is-invalid');
        }
        break;
      default:
        break;
    }
  });
  
});

function watchValidation(){
  if( validation.email == false || validation.username == false || validation.password == false ){
    $('button[type="submit"]').attr('disabled', true );
    let animId = requestAnimationFrame(watchValidation);
  }
  else{
    $('button[type="submit"]').removeAttr('disabled');
  }
}
