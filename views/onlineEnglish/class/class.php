<?php
    // ToDo ユーザー名を動的に代入するように書き換える
    $hash = array("tencho","hiro","natsu","hina","koich");
    $key = array_rand($hash);
    $name = $hash[$key];
?>

<link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../views/assets/css/class.css">
<script type="text/javascript" src="../../views/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../../views/assets/js/bootstrap.js"></script>

<section id="onlineclass">
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
        <div class="log" style="background-color: white;">
          <ul class="chat">
              <li class="right clearfix" style="margin-bottom: 0px;">
                  <div class="chat-body clearfix">
                    <div id="log" style="display:none;">
                    </div>
                  </div>
              </li>
          </ul>
        </div>
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
                  <div class="panel-body" style="overflow: auto; padding-bottom: 0px;padding-top: 0px;" >
                      <ul class="chat">
                          <li class="right clearfix" style="margin-bottom: 0px;">
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
</section>

<!-- socket -->
<script src="../../views/assets/js/socket.io.js"></script>

<!-- online英会話メインjs -->
<script id="script" type="text/javascript" src="../../views/assets/js/class.js"
  data-name = '<?php echo json_safe_encode($name); ?>'
></script>
