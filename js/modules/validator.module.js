//module for validating email, username, passwords on client side
export class Validator{
  static email( email ){
    //split the characters into array
    let chars = email.split('');
    //count how many @ symbol in the email
    let atCount = 0;
    chars.forEach( (chr) => {
      if( chr == '@' ){
        atCount++;
      }
    });
    //check where '@' occurs
    let at = email.indexOf('@');
    //check where the last '.' occurs
    let dot = email.lastIndexOf('.');
    //get length of the email string
    let len = email.length;
    //if email has an '@' after first character and a '.' after '@" and before the end
    if( at > 0 && dot > at && dot < len-2 && atCount == 1){
      return true;
    }
    else{
      return false;
    }
  }
  static username( username ){
    //check for length
    if( username.length < 6 ){
      return false;
    }
    //check for space
    else if( username.indexOf(' ') !== -1){
      return false;
    }
    //check if it contains letters or numbers
    else if( this.isAlphaNumeric(username) == false ){
      return false;
    }
    else{
      return true;
    }
  }
  static password( password ){
    return (password.length >= 8) ? true : false;
  }
  //function to check two passwords
  static twoPasswords( password1, password2){
    //if password 2 has not been filled
    if( password2 == '' ){
      return this.password( password1 );
    }
    else{
      let validPassword1 = this.password(password1);
      let validPassword2 = this.password(password2);
      let match = (password1 == password2) ? true : false;
      if( validPassword1 && validPassword2 && match ){
        return true;
      }
    }
  }
  static isAlphaNumeric( str ){
    let result = true;
    let allowedChrs = 'abcdefghijklmnopqrstuvwxyz1234567890';
    let allowed = allowedChrs.split('');
    let usernameChrs = str.split('');
    usernameChrs.forEach( (chr) =>{
      if( allowedChrs.indexOf( chr.toLowerCase()) == -1){
       result = false;
      }
    });
    return result;
  }
  isNotAlphaNumeric(str){
    return ( !this.isAlphaNumeric( str )) ? true : false;
  }
}
