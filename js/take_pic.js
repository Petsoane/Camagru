const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById("snap");
const errorMsgElement = document.querySelector("spam#errorMsg");

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
    context.drawImage(video, 0, 0, document.getElementById('canvas').width, document.getElementById('canvas').height);
    var canvas = document.getElementById('canvas');
});
