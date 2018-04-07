function actionMenu(id)
{
    if (document.getElementById(id).style.visibility == 'hidden') {
        document.getElementById(id).style.visibility='visible';
        document.getElementById(id).style.width='250px';
        document.getElementById('section').style.width='calc(100% - 250px)';
    }  else  {
        document.getElementById(id).style.visibility='hidden';
        document.getElementById(id).style.width='0px';
        document.getElementById('section').style.width='100%';
    }
}


function asdf(area){
  switch(area) {
    case '1': $area = "ULC"; break;
    case '2': $area = "UPM"; break;
    case '3': $area = "URC"; break;
    case '4': $area = "RTS"; break;
    case '5': $area = "DRC"; break;
    case '6': $area = "DWM"; break;
    case '7': $area = "DLC"; break;
    case '8': $area = "LTS"; break;
    case '9': $area = "LTP"; break;
    case '10': $area = "RTP"; break;
  }
}

function generateUser() {
    const DOMAINNAME = '@stadium.local.net';
    // Get data from input
    var firstName = document.getElementById('firstName').value;
    var lastName = document.getElementById('lastName').value;

    if (firstName != '' && lastName != '') {
        // Assign username
        var username = firstName.charAt(0).toLowerCase();
        username += lastName.toLowerCase();

        // Get data from database
        var users;
        var x = new XMLHttpRequest();
        x.open('GET', 'http://stadium.local.net/api/users/', true);
        x.send();

        x.onreadystatechange = function() {
          if (x.status == 200 && x.readyState == 4) {
            users = JSON.parse(x.responseText).users;

            // check if username generated is already taken by other employee
            var taken = 0;
            for (var i = 0; i < users.length; i++) {
              if (users[i].email == (username + DOMAINNAME) || users[i].email == (username + taken + DOMAINNAME)) {
                  taken++;
              }
            }
            if (taken != 0) {
              username += taken;
            }

            var email = document.getElementById('email');
            email.value = (username + DOMAINNAME);
          }
        }
    } else {
        var email = document.getElementById('email');
        email.value = '';
    }
}
