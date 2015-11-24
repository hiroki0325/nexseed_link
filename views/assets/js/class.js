  var localVideo = document.getElementById('local-video');
  var remoteVideo = document.getElementById('remote-video');
  var localStream = null;
  var peerConnection = null;
  var peerStarted = false;
  var mediaConstraints = {'mandatory': {'OfferToReceiveAudio':true, 'OfferToReceiveVideo':true }};


  // ---- socket ------
  // create socket
  var socketReady = false;
  var socket = io.connect("https://nexseedlink-test.herokuapp.com/");

  // socket: channel connected
  socket.on('connect', onOpened)
        .on('message', onMessage);

function onOpened(evt) {
    console.log('socket opened.');
    socketReady = true;

    var roomname = getRoomName(); // 会議室名を取得する
    socket.emit('enter', roomname);
}

function getRoomName() { // たとえば、 URLに  ?roomname  とする
  var url = document.location.href;
  var args = url.split('?');
  if (args.length > 1) {
    var room = args[1];
    if (room != "") {
      return room;
    }
  }
  return "_defaultroom";
}

  // socket: accept connection request
  function onMessage(evt) {
    if (evt.type === 'offer') {
      console.log("Received offer, set offer, sending answer....");
      onOffer(evt);
    } else if (evt.type === 'answer' && peerStarted) {
      console.log('Received answer, settinng answer SDP');
    onAnswer(evt);
    } else if (evt.type === 'candidate' && peerStarted) {
      console.log('Received ICE candidate...');
    onCandidate(evt);
    } else if (evt.type === 'user dissconnected' && peerStarted) {
      console.log("disconnected");
      stop();
    }
  }



  // ----------------- handshake --------------
  // var textForSendSDP = document.getElementById('text-for-send-sdp');
  // var textForSendICE = document.getElementById('text-for-send-ice');
  // var textToReceiveSDP = document.getElementById('text-for-receive-sdp');
  // var textToReceiveICE = document.getElementById('text-for-receive-ice');
  var iceSeparator = '------ ICE Candidate -------';
  var CR = String.fromCharCode(13);

  function onSDP() {
    var text = textToReceiveSDP.value;
  var evt = JSON.parse(text);
  if (peerConnection) {
    onAnswer(evt);
  }
  else {
    onOffer(evt);
  }

  textToReceiveSDP.value ="";
  }

  //--- multi ICE candidate ---
  function onICE() {
    var text = textToReceiveICE.value;
  var arr = text.split(iceSeparator);
  for (var i = 1, len = arr.length; i < len; i++) {
      var evt = JSON.parse(arr[i]);
    onCandidate(evt);
    }

  textToReceiveICE.value ="";
  }


  function onOffer(evt) {
    console.log("Received offer...");
  console.log(evt);
    setOffer(evt);
  sendAnswer(evt);
  peerStarted = true;  // ++
  }

  function onAnswer(evt) {
    console.log("Received Answer...");
  console.log(evt);
  setAnswer(evt);
  }

  function onCandidate(evt) {
    var candidate = new RTCIceCandidate({sdpMLineIndex:evt.sdpMLineIndex, sdpMid:evt.sdpMid, candidate:evt.candidate});
    console.log("Received Candidate...");
  console.log(candidate);
    peerConnection.addIceCandidate(candidate);
  }

  function sendSDP(sdp) {
    var text = JSON.stringify(sdp);
  console.log("---sending sdp text ---");
  console.log(text);
  textForSendSDP = text;

  // send via socket
  socket.json.send(sdp);
  }

  function sendCandidate(candidate) {
    var text = JSON.stringify(candidate);
  console.log("---sending candidate text ---");
  console.log(text);
  textForSendICE = text;
  textForSendICE.value = (textForSendICE.value + CR + iceSeparator + CR + text + CR);
  textForSendICE.scrollTop = textForSendICE.scrollHeight;

  // send via socket
  socket.json.send(candidate);
  }

  // ---------------------- video handling -----------------------
  // start local video
    function startVideo() {
      navigator.webkitGetUserMedia({video: true, audio: true},
        function (stream) { // success
          localStream = stream;
          localVideo.src = window.URL.createObjectURL(stream);
          localVideo.play();
          localVideo.volume = 0;
        },
        function (error) { // error
          console.error('An error occurred: [CODE ' + error.code + ']');
          return;
        }
      );
    }

    $(document).ready( function(){
    startVideo();
    });

  // ---------------------- connection handling -----------------------
function prepareNewConnection(id) {
  var pc_config = {"iceServers":[ {"url":"stun:stun.l.google.com:19302"} ]};
  var peer = null;
  try {
    peer = new webkitRTCPeerConnection(pc_config);
  } catch (e) {
    console.log("Failed to create PeerConnection, exception: " + e.message);
  }

    // send any ice candidates to the other peer
    peer.onicecandidate = function (evt) {
      if (evt.candidate) {
        console.log(evt.candidate);
        sendCandidate({type: "candidate",
                          sdpMLineIndex: evt.candidate.sdpMLineIndex,
                          sdpMid: evt.candidate.sdpMid,
                          candidate: evt.candidate.candidate}
    );
      } else {
        console.log("End of candidates. ------------------- phase=" + evt.eventPhase);
      }
    };

    console.log('Adding local stream...');
    peer.addStream(localStream);

    peer.addEventListener("addstream", onRemoteStreamAdded, false);
    peer.addEventListener("removestream", onRemoteStreamRemoved, false);

    // when remote adds a stream, hand it on to the local video element
    function onRemoteStreamAdded(event) {
      console.log("Added remote stream");
      remoteVideo.src = window.URL.createObjectURL(event.stream);
    }

    // when remote removes a stream, remove it from the local video element
    function onRemoteStreamRemoved(event) {
      console.log("Remove remote stream");
      remoteVideo.src = "";
    }

    return peer;
  }

  function sendOffer() {
    peerConnection = prepareNewConnection();
    peerConnection.createOffer(function (sessionDescription) { // in case of success
      peerConnection.setLocalDescription(sessionDescription);
      console.log("Sending: SDP");
      console.log(sessionDescription);
      sendSDP(sessionDescription);
    }, function () { // in case of error
      console.log("Create Offer failed");
    }, mediaConstraints);
  }

  function setOffer(evt) {
    if (peerConnection) {
    console.error('peerConnection alreay exist!');
  }
    peerConnection = prepareNewConnection();
    peerConnection.setRemoteDescription(new RTCSessionDescription(evt));
  }

  function sendAnswer(evt) {
    console.log('sending Answer. Creating remote session description...' );
  if (! peerConnection) {
    console.error('peerConnection NOT exist!');
    return;
  }

    peerConnection.createAnswer(function (sessionDescription) { // in case of success
      peerConnection.setLocalDescription(sessionDescription);
      console.log("Sending: SDP");
      console.log(sessionDescription);
      sendSDP(sessionDescription);
    }, function () { // in case of error
      console.log("Create Answer failed");
    }, mediaConstraints);
  }

  function setAnswer(evt) {
    if (! peerConnection) {
    console.error('peerConnection NOT exist!');
    return;
  }
  peerConnection.setRemoteDescription(new RTCSessionDescription(evt));
  }

  // -------- handling user UI event -----
  // start the connection upon user request
  function connect() {
    if (!peerStarted && localStream && socketReady) { // **
  //if (!peerStarted && localStream) { // --
      sendOffer();
      peerStarted = true;
    } else {
      alert("Local stream not running yet - try again.");
    }
  }

  // stop the connection upon user request
  function hangUp() {
    console.log("Hang up.");
    stop();
  }

  function stop() {
    peerConnection.close();
    peerConnection = null;
    peerStarted = false;
  }

  $('input[name="message"]').on('keydown', function(e){
    var ENTER_KEY = 13;
    if (ENTER_KEY == e.keyCode) {
      socket.emit('send-message',$(this).val() );
      $(this).val('');
    }
  });

  socket.on('push-message', function(text){
      var $message;
      $message = time()+ escapeHTML2(text) + "<br>";
      // $($message).html('<br>');
      $('#tmpl').prepend($message).fadeIn();
  });

  function escapeHTML2(html) {
    return jQuery('<div>').text(html).html();
  }

  // 1桁の数字を0埋めで2桁にする
  var toDoubleDigits = function(num) {
    num += "";
    if (num.length === 1) {
      num = "0" + num;
    }
   return num;
  };

  function time(){
    //時刻データを取得して変数jikanに格納する
    var jikan= new Date();

   //時・分・秒を取得する
   var hour = toDoubleDigits(jikan.getHours());
   var minute = toDoubleDigits(jikan.getMinutes());
   var second = toDoubleDigits(jikan.getSeconds());

    return (hour+":"+minute+":"+second+"　");
  }
