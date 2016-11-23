/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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

function upload1()
{
if(file1.value == "")
{
    alert("Upload failed")
    return false;
}
var stuff = file1.value.match(/^(.*)(\.)(.{1,8})$/)[3];
if(stuff != "csv"){
    alert("Please Choose .csv file");
    return false;
}
else
{
    alert("Upload successfully");
    return true;
}

    
}

function upload2()
{
if(file2.value == "")
{
    alert("upload failed")
    return false;
}
var stuff = file1.value.match(/^(.*)(\.)(.{1,8})$/)[3];
if(stuff != "csv"){
    alert("Please Choose .csv file");
    return false;
}
else
{
    alert("Upload successfully");
    return true;
}


}


