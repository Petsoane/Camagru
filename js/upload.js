
function prepareImg() {
    // get the image from the canvas
    var canvas = document.getElementById('canvas');
    // write the image to the string
    document.getElementById("inp_img").value = canvas.toDataURL();
}