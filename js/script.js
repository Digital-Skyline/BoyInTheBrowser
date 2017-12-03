function checkname() {
    var name=document.getElementById("username").value;

    if(name){
        $.ajax({
            type: 'post',
            url: 'Register.php',
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
    var emailE=document.getElementById("email").value;

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
