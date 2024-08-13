function doubleHidePassword() {
     var w = document.getElementById("cpassword");
     var x = document.getElementById("password");
     var y = document.getElementById("hide1");
     var z = document.getElementById("hide2");

     if (x.type === 'password') { // shows password
          w.type = "text";
          x.type = "text";
          y.style.display = "block";
          z.style.display = "none";
     } else { // hides password
          w.type = "password";
          x.type = "password";
          y.style.display = "none";
          z.style.display = "block";
     }
}

function hidePassword() {
     var x = document.getElementById("password");
     var y = document.getElementById("hide1");
     var z = document.getElementById("hide2");

     if (x.type === 'password') { // shows password
          x.type = "text";
          y.style.display = "block";
          z.style.display = "none";
     } else { // hides password
          x.type = "password";
          y.style.display = "none";
          z.style.display = "block";
     }
}