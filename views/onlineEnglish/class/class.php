<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
<script type="text/javascript" src="../../views/assets/js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../views/assets/css/class.css">

<div class="container">
  <div id="parent_box">
    <video id="remote-video" autoplay style="width: 600px; height: 450px; border: 1px solid black;"></video>
    <div id="child_box">
      <video id="local-video" autoplay style="width: 160px; height: 120px; border: 1px solid black;"></video>
    </div>
  </div>

  <br>
  <button type="button" onclick="connect();">授業開始</button>
  <button type="button" onclick="hangUp();">授業終了</button>

  <div id="layer2">
    <input type="text" name="message" placeholder="発言を入力">
  </div>

  <div id="tmpl" style="display:none;">
  </div>
</div>


<!-- socket -->
<script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>
<script type="text/javascript" src="../../views/assets/js/class.js"></script>
