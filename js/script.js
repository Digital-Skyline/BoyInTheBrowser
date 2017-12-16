function validate(form) {
  var fail = validateUsername(form.username.value);
  fail += validateEmail(form.email.value);
  fail += validatePassword(form.password.value);
  if (fail == "") { return true; }
  else { alert(fail); return false; }
}

function validateUsername(field) {
  if (field == "") { return "No username was entered.\n"; }
  else if (field.length < 6) {
      return "Username must be at least 6 characters.\n"; }
  else if (/[^a-zA-Z0-9_-]/.test(field)) {
      return "Only letters, numbers, -, and _ are allowed in usernames.\n"; }
  return "";
}

function validateEmail(field) {
  if (field == "") { return "No email was entered.\n"; }
  else if (!((field.indexOf(".") > 0) && (field.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(field)) {
      return "The email address is invalid.\n"; }
  return "";
}

function validatePassword(field) {
  if (field == "") { return "No password was entered.\n"; }
  else if (field.length < 6) {
    return "Password must be at least 6 characters.\n"; }
  else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) || !/[0-9]/.test(field)) {
    return "Password requires one of each of A-Z, a-z, and 0-9.\n"; }
  return "";
}


function checkname() {
    var name = document.getElementById("username").value;

    if(name){
        $.ajax({
            type: 'post',
            url: 'register.php',
            data: {
            username:name,
            },
            success: function (response) {
                $('#name_status').html(response);
                if(response=="OK") {
                    return true;
                }else{
                    return false;
                }
            }
        });
    }else{
        $('#name_status').html("");
        return false;
    }
}

function checkemail() {
    var emailE = document.getElementById("email").value;

    if(emailE){
        $.ajax({
            type: 'post',
            url: 'Register.php',
            data: {
              email:emailE,
            },
            success: function (response) {
                $('#email_status').html(response);
                if(response=="OK"){
                    return true;
                }else{
                    return false;
                }
            }
        });
    }else{
        $('#email_status').html("");
        return false;
    }
}

function checkpass() {

}

function openTab(evt, task) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(task).style.display = "block";
    evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
