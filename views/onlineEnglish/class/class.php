<?php
    $name = current_user('nickname')
?>

<link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../views/assets/css/class.css">

<section id="onlineclass">
  <!-- 授業の開始と終了は先生のみ可能 -->
  <div class="container">
    <button type="button" onclick="connect();">授業開始</button>
    <button type="button" onclick="hangUp();">授業終了</button>
    <button type="button" onclick="quit();">退室する</button>
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
        <div class="log" style="overflow: auto; background-color: white;">
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
