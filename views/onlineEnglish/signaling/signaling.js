var port = 443;
var SSL_KEY = '/etc/letsencrypt/live/nexseed.tk/privkey.pem';
var SSL_CERT= '/etc/letsencrypt/live/nexseed.tk/cert.pem';

var https = require('https');
var fs = require('fs');

var options = {
  key: fs.readFileSync(SSL_KEY),
  cert: fs.readFileSync(SSL_CERT)
};

var server = https.createServer(options);
var io = require('socket.io')(server);

server.listen(port, function() {
  console.log((new Date()) + " Server is listening on port " + port);
});

io.sockets.on('connection', function(socket) {
  // 入室
  socket.on('enter', function(roomname) {
      socket.name = roomname;
      // socket.set('roomname', roomname);
      socket.join(roomname);
  });

  socket.on('message', function(message) {
    emitMessage('message', message);
  });

  socket.on('disconnect', function() {
    var text = '相手との接続が切れました' ;
    emitMessage('user disconnected', text);
  });

  socket.on('send-message', function(text){
    if (text.length) {
      io.sockets.in(socket.name).emit('push-message', text);
    }
  });

  socket.on('send-log', function(text){
      io.sockets.in(socket.name).emit('push-log', text);
  });

  // 会議室名が指定されていたら、室内だけに通知
  function emitMessage(type, message) {
    var roomname;
    roomname = socket.name;
    // socket.get('roomname', function(err, _room) {  roomname = _room;  });

    if (roomname) {  socket.broadcast.to(roomname).emit(type, message);   }
    else {   socket.broadcast.emit(type, message);   }
  }
});
