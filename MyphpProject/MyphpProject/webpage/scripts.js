/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function togglePassword() {
    var upass = document.getElementById("u2_input");
    var toggleBtn = document.getElementById("toggleBtn");
    if(upass.type == "password"){
        upass.type = "text";
        toggleBtn.value = "Hide Password";
    } else {
        upass.type = "password";
        toggleBtn.value = "Show Password";
    }
}

function val(){
if(frm.userpass.value == "")
{
	alert("Enter the Password.");
	frm.userpass.focus(); 
	return false;
}
if((frm.userpass.value).length < 6)
{
	alert("Password should be minimum 6 characters.");
	frm.userpass.focus();
	return false;
}

if(frm.userpass.value == "123456")
{
    frm.userpass.focus();
    return true;
}
else {
        alert("Invaid Password")
        return false;
}


}