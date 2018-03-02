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
