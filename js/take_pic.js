const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById("snap");
const errorMsgElement = document.querySelector("spam#errorMsg");
const cool_sticker = document.getElementById('cool');

const constraints = {
    audio: false,
    video: true
};

async function init() {
    try{
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        handleSuccess(stream);
    }
    catch (e) {
        errorMsgElement.innerHTML = `navigator.getUserMedia error: ${e.toString()}`;
    }
}

// success
function handleSuccess(stream){
    window.stream = stream;
    video.srcObject = stream;
}

// load init
init();

// draw the umage.
var context = canvas.getContext('2d');
snap.addEventListener('click', function() {
    console.log("Taking the p icture.");
    context.drawImage(video, 0, 0, document.getElementById('canvas').width, document.getElementById('canvas').height);
    var canvas = document.getElementById('canvas');
});

cool_sticker.addEventListener('click', function(){
    console.log("Adding the sticker");
    var pic = document.getElementById('canvas');
    var cont = pic.getContext('2d');
    var img_2 = new Image();
    // get the value from the list.
    var select = document.getElementById('select_sticker');
    if (select.value != 'none'){
        // Draw the image onto the canvas
        // img_2.src = 'server/stickers/cool.png';
        img_2.src = select.value;
        cont.drawImage(img_2, 0, 0, 60, 70);
    }
});