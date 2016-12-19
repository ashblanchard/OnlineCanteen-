/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function togglePassword() {
    var upass = document.getElementById("u2_input");
    var toggleBtn = document.getElementById("toggleBtn");
    if (upass.type == "password") {
        upass.type = "text";
        toggleBtn.value = "Hide Password";
    } else {
        upass.type = "password";
        toggleBtn.value = "Show Password";
    }
}

function val() {
    if (frm.userpass.value == "")
    {
        alert("Enter the Password.");
        frm.userpass.focus();
        return false;
    }
    if ((frm.userpass.value).length < 6)
    {
        alert("Password should be minimum 6 characters.");
        frm.userpass.focus();
        return false;
    }

    if (frm.userpass.value == "123456")
    {
        frm.userpass.focus();
        return true;
    } else {
        alert("Invaid Password")
        return false;
    }

}

function togglePassword() {
    var upass = document.getElementById("u2_input");
    var toggleBtn = document.getElementById("toggleBtn");
    if (upass.type == "password") {
        upass.type = "text";
        toggleBtn.value = "Hide Password";
    } else {
        upass.type = "password";
        toggleBtn.value = "Show Password";
    }
}

function val() {
    if (frm.userpass.value == "")
    {
        alert("Enter the Password.");
        frm.userpass.focus();
        return false;
    }
    if ((frm.userpass.value).length < 6)
    {
        alert("Password should be minimum 6 characters.");
        frm.userpass.focus();
        return false;
    }

    if (frm.userpass.value == "123456")
    {
        frm.userpass.focus();
        return true;
    } else {
        alert("Invaid Password");
        return false;
    }
}

function checkField() {
    console.log("check!");
    var $name = document.getElementById("itemName").value;
    var $itemPrice = document.getElementById("itemPrice").value;
    var $consumerPrice = document.getElementById("consumerPrice").value;
    var $quantity = document.getElementById("quantity").value;

    /*If the required fields are empty, notify the user.*/
    if ($name.length < 1) {
        document.getElementById("itemName").style.border = "1px solid red";
        console.log("name is empty");
    }
    if ($itemPrice.length < 1) {
        document.getElementById("itemPrice").style.border = "1px solid red";
    }
    if ($consumerPrice.length < 1) {
        document.getElementById("consumerPrice").style.border = "1px solid red";
    }
    if ($quantity.length < 1) {
        document.getElementById("quantity").style.border = "1px solid red";
    }



    /*If fields are filled in*/
    if ($name.length >= 1) {
        document.getElementById("itemName").style.border = "1px solid #373a3c";
    }
    if ($itemPrice.length >= 1) {
        document.getElementById("itemPrice").style.border = "1px solid #373a3c";
    }
    if ($consumerPrice.length >= 1) {
        document.getElementById("consumerPrice").style.border = "1px solid #373a3c";
    }
    if ($quantity.length >= 1) {
        document.getElementById("quantity").style.border = "1px solid #373a3c";
    }

    /*If the numeric inputs are not numbers*/
    if (isNaN($itemPrice)) {
        document.getElementById("itemPrice").style.border = "1px solid red";
    }
    if (isNaN($consumerPrice)) {
        document.getElementById("consumerPrice").style.border = "1px solid red";
    }
    if (isNaN($quantity)) {
        document.getElementById("quantity").style.border = "1px solid red";
    }

}

function checkSettings() {
    var $camperName = document.getElementById("camperName").value;
    var $camperCabin = document.getElementById("camperCabin").value;
    var $camperBalance = document.getElementById("camperBalance").value;
    var $staffName = document.getElementById("staffName").value;

    /*If the required fields are empty*/
    if ($camperName.length < 1) {
        document.getElementById("camperName").style.border = "1px solid red";

    }
    if ($camperCabin.length < 1) {
        document.getElementById("camperCabin").style.border = "1px solid red";

    }
    if ($camperBalance.length < 1) {
        document.getElementById("camperBalance").style.border = "1px solid red";

    }
    if ($staffName.length < 1) {
        document.getElementById("staffName").style.border = "1px solid red";

        //new password


    }

    /*If the required fields are okay*/
    if ($camperName.length >= 1) {
        document.getElementById("camperName").style.border = "1px solid #373a3c";
    }
    if ($camperCabin.length >= 1) {
        document.getElementById("camperCabin").style.border = "1px solid #373a3c";
    }
    if ($camperBalance.length >= 1) {
        document.getElementById("camperBalance").style.border = "1px solid #373a3c";
    }
    if ($staffName.lentgh >= 1) {
        document.getElementById("staffName").style.border = "1px solid #373a3c";
    }

    /*if the camper balance is not a number*/
    if (isNaN($camperBalance)) {
        document.getElementById("camperBalance").style.border = "1px solid red";
    }
}

function displayNewInventory() {
    document.getElementById("newInventory").style.display = "block";
}

function closeNewInventory() {
    document.getElementById("newInventory").style.display = "none";
}

function displayAddIndividual(x) {
    if (x == 1) {
        document.getElementById("addCamper").style.display = "block";
    } else if (x == 2) {
        document.getElementById("addStaff").style.display = "block";
    }
}

function closeAddIndividual(x) {
    if (x == 1) {
        document.getElementById("addCamper").style.display = "none";
    } else if (x == 2) {
        document.getElementById("addStaff").style.display = "none";

    }
}

function displayChangePassword() {
    document.getElementById("changePassword").style.display = "block";
}

function closeChangePassword() {
    document.getElementById("changePassword").style.display = "none";
}

function uploadCamperFileAlert(){
    if (file1.value == ""){
        alert("Upload failed. Please try again.")
        return false;
    } var stuff = file1.value.match(/^(.*)(\.)(.{1,8})$/)[3];
    if (stuff != "csv") {
        alert("Please Choose .csv file");
        return false;
    } else {
        alert("Upload successful.");
        return true;
    }
}

function uploadStaffFileAlert() {
    if (file2.value == "") {
        alert("Upload failed. Please try again.")
        return false;
    } var stuff = file2.value.match(/^(.*)(\.)(.{1,8})$/)[3];
    if (stuff != "csv") {
        alert("Please Choose .csv file");
        return false;
    } else {
        alert("Upload successful.");
        return true;
    }
}
























