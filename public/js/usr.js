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
