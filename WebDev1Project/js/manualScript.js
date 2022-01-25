function handlePopUp() {
    //get the popup and show it
    document.getElementById('confirmPopup').style.visibility = 'visible';
    //set a timer to hide the popup again
    window.setTimeout('hide()', 2000);
}

function hide() {
    document.getElementById('confirmPopup').style.visibility = 'hidden';
}
