var port = 80;
var io = require('socket.io').listen(port);
console.log((new Date()) + " Server is listening on port " + port);

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
