  var localVideo = document.getElementById('local-video');
  var remoteVideo = document.getElementById('remote-video');
  var localStream = null;
  var peerConnection = null;
  var peerStarted = false;
  var mediaConstraints = {'mandatory': {'OfferToReceiveAudio':true, 'OfferToReceiveVideo':true }};

  var $script = $('#script');
  var user_name = JSON.parse($script.attr('data-name'));


  // ---- socket ------
  // create socket
  var socketReady = false;
  var socketReady = false;
  var port = 443;
  var socket = io.connect('https://nexseed.tk:' + port + '/', {secure: true});

  // socket: channel connected
  socket.on('connect', onOpened)
        .on('message', onMessage);

// 入室処理
function onOpened(evt) {
    console.log('socket opened.');
    socketReady = true;
    var roomname = getRoomName(); // 会議室名を取得する
    socket.emit('enter', roomname);
    socket.emit('send-log',user_name + 'が入室しました');
}

function getRoomName() {
  // URLに  ?roomname  とする
  var url = document.location.href;
  var args = url.split('?');
  if (args.length > 1) {
    var room = args[1];
    if (room) {
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
          console.error('An error occurred to user video');
          return;
        }
      );
    }

    $(document).ready( function(){
    startVideo();
    });

  // ---------------------- connection handling -----------------------
  function prepareNewConnection(id) {
    var pc_config = {"iceServers":[
     {"url":"stun:27.120.111.43:80"},
     {"url":"turn:27.120.111.43:80?transport=udp", "username":"hiroki", "credential":"0xbc807ee29df3c9ffa736523fb2c4e8ee"},
     {"url":"turn:27.120.111.43:80?transport=tcp", "username":"hiroki", "credential":"0xbc807ee29df3c9ffa736523fb2c4e8ee"}
    ]};
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
      socket.emit('send-log','授業を開始しました');
    } else {
      alert("Local stream not running yet - try again.");
    }
  }

  // stop the connection upon user request
  function hangUp() {
    console.log("Hang up.");
    socket.emit('send-log','授業を終了しました');
    stop();
  }

  function stop() {
    peerConnection.close();
    peerConnection = null;
    peerStarted = false;
  }

  // チャット欄
  $('input[name="message"]').on('keydown', function(e){
    var ENTER_KEY = 13;
    if (ENTER_KEY == e.keyCode) {
      var message = $(this).val() + "　(" + user_name + ")" ;
      socket.emit('send-message',message );
      $(this).val('');
    }
  });

  socket.on('push-message', function(text){
      var $message;
      $message = time()+ escapeHTML2(text) +"<br>";
      $('#tmpl').append($message).fadeIn();
      $(".panel-body").scrollTop( $("#tmpl")[0].scrollHeight );
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

  // チャットログ出力用 //

  // ログの表示(全般)
  socket.on('push-log', function(text){
      var $log;
      $log = time()+ escapeHTML2(text) +"<br>";
      $('#log').append($log).fadeIn();
  });

  // 退出した場合のログ
  function quit(){
    socket.emit('send-log',user_name + 'が退室しました');
    // ToDo 予約ページのURLを設定
    location.assign("../reserve/index");
  }

  // 通信が突如きれた場合のログ
  socket.on('user disconnected', function(text){
    var $log;
    $log = time()+ escapeHTML2(text) +"<br>";
    // 正常な退出でない場合のみ、出力する処理
    var logComment = document.getElementById("log").innerText;
    var lastLog = logComment.substr(-10);

    if (!lastLog.match(/退室しました/) ) {
      $('#log').append($log).fadeIn();
    }

  });
