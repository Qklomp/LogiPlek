/* 
 * ==================== BINDINGS ====================
 */

$('.password').keyup(function()
{
  $('#verdict').html(checkStrength($( this ).val()))
}) 

/* 
 * ==================== FUNCTIONS ====================
 */ 
  
function checkStrength(password)
{
  //initial strength
  var strength = 0
  
  //if the password length is less than 6, return message.
  if (password.length < 8) { 
    $('#verdict').removeClass()
    $('#verdict').addClass('text-danger')
    return 'te kort <i class="fa fa-thumbs-down"></i>' 
  }  
  
  if (password.length > 9) strength += 1
  if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
  if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
  if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
  if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
  
  if (strength < 2 )
  {
    $('#verdict').removeClass()
    $('#verdict').addClass('text-warning')
    return 'zwak <i class="fa fa-thumbs-down"></i>'     
  }
  else if (strength == 2 )
  {
    $('#verdict').removeClass()
    $('#verdict').addClass('text-primary')
    return 'goed, maar kan beter <i class="fa fa-thumbs-up"></i>'   
  }
  else
  {
    $('#verdict').removeClass()
    $('#verdict').addClass('text-success')
    return 'sterk <i class="fa fa-trophy"></i>'
  }
};