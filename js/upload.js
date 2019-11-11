
function prepareImg() {
    // get the image from the canvas
    var canvas = document.getElementById('canvas');
    // Get the variable of the selector.
    var select = document.getElementById('select_sticker');
    if (select.value == 'none'){
        return false;
    }
    // write the image to the string
    document.getElementById("inp_img").value = canvas.toDataURL();
}