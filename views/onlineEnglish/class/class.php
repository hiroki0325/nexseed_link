<link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../views/assets/css/class.css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="../../views/assets/js/bootstrap.js"></script>

<!-- 授業の開始と終了は先生のみ可能 -->
<div class="container">
  <button type="button" onclick="connect();">授業開始</button>
  <button type="button" onclick="hangUp();">授業終了</button>
  <br>
  <br>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-9">
      <div id="parent_box">
        <video id="remote-video" autoplay></video>
        <div id="child_box">
          <video id="local-video" autoplay></video>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="log"></div>
    </div>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span>  ChatSpace
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <ul class="chat">
                        <li class="right clearfix">
                            <div class="chat-body clearfix">
                              <div id="tmpl" style="display:none;">
                              </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                      <div id="layer2">
                        <input type="text" name="message" class="input" placeholder="発言を入力">
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- socket -->
<script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>

<!-- online英会話メインjs -->
<script type="text/javascript" src="../../views/assets/js/class.js"></script>
