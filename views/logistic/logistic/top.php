
<?php
    //use_idを設定
    $_SESSION['login_id'] = current_user('id');
    //セブ在学生向け投稿の表示
    if (status()==3){
        include('request_form.php');
        //データの表示
        //全自分の投稿データ
        $sql=sprintf('SELECT * FROM logistic_posts WHERE client_id=%d ORDER BY created DESC',
           $_SESSION['login_id']
        );
        $posts=mysqli_query($db, $sql) or die (mysqli_error($db));
        //承認されたデータのみ
        $sql=sprintf('SELECT * FROM logistic_posts WHERE client_id=%d AND candidate_id IS NOT NULL ORDER BY created DESC',
           $_SESSION['login_id']
        );
        $accepted_posts=mysqli_query($db, $sql) or die (mysqli_error($db));

        //承認されていないデータのみ
        $sql=sprintf('SELECT * FROM logistic_posts WHERE client_id=%d AND candidate_id IS NULL ORDER BY created DESC',
           $_SESSION['login_id']
        );
        $unverified_posts=mysqli_query($db, $sql) or die (mysqli_error($db));

        //全投稿データ
        $sql=sprintf('SELECT * FROM logistic_posts  ORDER BY created DESC',
           $_SESSION['login_id']
        );
        $all_posts=mysqli_query($db, $sql) or die (mysqli_error($db));

        //期限の近い順
        $sql=sprintf('SELECT * FROM logistic_posts WHERE client_id=%d AND candidate_id IS NULL ORDER BY due ASC',
           $_SESSION['login_id']
        );
        $deadline_posts=mysqli_query($db, $sql) or die (mysqli_error($db));
    }

    if (status()==2){
        include('submit_accepted_show.php');
        //全投稿データ
        $sql='SELECT * FROM logistic_posts ORDER BY created DESC';
        $posts=mysqli_query($db, $sql) or die (mysqli_error($db));

        // 自分がリクエストを送ったデータで承認されていないデータのみ
        $sql=sprintf('SELECT post_id FROM candidates WHERE agent_id=%d',$_SESSION['login_id']);
        $unverified_candidates=mysqli_query($db, $sql) or die (mysqli_error($db));
        while($unverified_candidate=mysqli_fetch_assoc($unverified_candidates)){
            $sql=sprintf('SELECT * FROM logistic_posts WHERE id=%d AND accepted IS NULL ORDER BY created DESC',$unverified_candidate['post_id']);
        }
        $unverified_posts=mysqli_query($db, $sql) or die (mysqli_error($db));

        //期限の近い順
        $sql='SELECT * FROM logistic_posts  ORDER BY due ASC';
        $deadline_posts=mysqli_query($db, $sql) or die (mysqli_error($db));

        //リクエストが承認された投稿した投稿
        $sql=sprintf('SELECT id FROM candidates WHERE agent_id=%d AND desicion=1',$_SESSION['login_id']);
        $accepted_candidates=mysqli_query($db, $sql) or die (mysqli_error($db));
        while($accepted_candidate=mysqli_fetch_assoc($accepted_candidates)){
            $sql=sprintf('SELECT * FROM logistic_posts WHERE candidate_id=%d ORDER BY created DESC',$accepted_candidate['id']);
        }
        $accepted_posts=mysqli_query($db, $sql) or die (mysqli_error($db));    
    }  
?>

<!-- 表示の切り替え -->
<div class="container-fluid">
  <div class="row">   
    <div class="span12 col-lg-10 col-lg-offset-1 col-xs-12">
      <div class="btn-group btn-list">
        <a href="top?sort=posts" class="btn btn-large btn-info active">自分の投稿</a>
        <a href="top?sort=deadline" class="btn btn-large btn-info">期限の近い順</a>
        <a href="top?sort=unaccepted" class="btn btn-large btn-info">承認待ち</a>
        <?php if (status()==3):?>
          <a href="top?sort=request_index" class="btn btn-large btn-info">依頼一覧</a>
          <a href="top?sort=accepted" class="btn btn-large btn-info">承認済み</a>
          <a href="top?sort=all" class="btn btn-large btn-info">他の人の投稿も見る</a>
        <?php endif; ?>
      </div>     
    </div>
  </div>
</div>
<!-- 自分の全投稿 -->
<?php if (empty($_REQUEST['sort']) || !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'posts'):?> 
  <section class="services">
    <div class="container-fluid no-gutter row-nopadding">
      <div class= "row"> 
        <div class= "media-row col-xs-12 bg-primary" style="margin-top:30px">
        <div class="list_title">
          <h3>全ての投稿を見ることができるよ</h3>  
        </div>
          <?php while ($post=mysqli_fetch_assoc($posts)):?>
            <div class= "col-sm-6 col-xs-12 col-md-4 col-lg-4">
              <div class="well">
                <div class="media" >
                <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" style="float:left">
                  <div class="media-body" >
                    <?php if(!empty($post['candidate_id'])):?>
                      <div class="contracted"><p>CONTRACTED!</p></div>
                    <?php else:?>
                      <div class="wanted"><p>WANTED!</p></div>
                    <?php endif;?>
                    <h4 class="media-heading"><?php echo h($post['thing'])?></h4>
                    <?php 
                      //ユーザの名前を取得
                      $sql=sprintf("SELECT fullname FROM users WHERE id=%d",
                          $post['client_id']
                      );
                      $get_user_name=mysqli_query($db, $sql) or die (mysqli_error($db));
                      $user_name=mysqli_fetch_assoc($get_user_name);
                    ?>
                    <div class="list-inline list-unstyled" style="float:left">
                      <ul><?php echo h($user_name['fullname'])?>さんの投稿です</ul>
                      <ul><?php echo h($post['category'])?></ul>
                      <ul>期限:<?php echo h($post['due'])?></ul>
                      <ul><?php echo h($post['payment'])?> pessos</ul>
                      <ul><?php echo h($post['insentive'])?> </ul> 
                      <ul>[<a href="./show?id=<?php echo h($post['id'])?>">詳しく見る</a>]</ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile;?>
        </div>
      </div>
    </div>  
  </section> 
<?php endif; ?>
<!-- 全投稿 -->
<?php if (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'all'):?>
  <section class="services">
    <div class="container-fluid">
      <div class= "row"> 
        <div class= "media-row col-xs-12 bg-primary" style="margin-top:30px">
        <div class="list_title">
          <h3>みんなの投稿を見ることができるよ</h3>  
        </div>  
          <?php while ($post=mysqli_fetch_assoc($all_posts)):?>
            <div class= "col-sm-6 col-xs-12 col-md-4 col-lg-4">
              <div class="well">
                <div class="media" >
                <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" style="float:left">
                  <div class="media-body" >
                    <?php if(!empty($post['candidate_id'])):?>
                      <div class="contracted"><p>CONTRACTED!</p></div>
                    <?php else:?>
                      <div class="wanted"><p>WANTED!</p></div>
                    <?php endif;?>
                    <h4 class="media-heading"><?php echo h($post['thing'])?></h4>
                    <div class="list-inline list-unstyled" style="float:left">
                      <?php 
                        //ユーザの名前を取得
                        $sql=sprintf("SELECT fullname FROM users WHERE id=%d",
                            $post['client_id']
                        );
                        $get_user_name=mysqli_query($db, $sql) or die (mysqli_error($db));
                        $user_name=mysqli_fetch_assoc($get_user_name);
                      ?>
                      <ul><?php echo h($user_name['fullname'])?>さんの投稿</ul>
                      <ul><?php echo h($post['category'])?></ul>
                      <ul>期限:<?php echo h($post['due'])?></ul>
                      <ul><?php echo h($post['payment'])?> pessos</ul>
                      <ul><?php echo h($post['insentive'])?> </ul> 
                      <ul>[<a href="./show?id=<?php echo h($post['id'])?>">詳しく見る</a>]</ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile;?>
        </div>
      </div>
    </div>  
  </section>
<?php endif; ?>
<!-- 承認待ち -->
<?php if (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'unaccepted'):?>
  <section class="services">
    <div class="container-fluid">
      <div class= "row"> 
        <div class= "media-row col-xs-12 bg-primary" style="margin-top:30px">
          <div class="list_title">
            <h3>この投稿にリクエストを送信します</h3>  
          </div> 
          <?php while ($post=mysqli_fetch_assoc($unverified_posts)):?>
            <div class= "col-sm-6 col-xs-12 col-md-4 col-lg-4">
              <div class="well">
                <div class="media" >
                <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" style="float:left">
                  <div class="media-body" >
                    <h4 class="media-heading"><?php echo h($post['thing'])?></h4>
                    <div class="list-inline list-unstyled" style="float:left">
                      <?php 
                        //ユーザの名前を取得
                        $sql=sprintf("SELECT fullname FROM users WHERE id=%d",
                            $post['client_id']
                        );
                        $get_user_name=mysqli_query($db, $sql) or die (mysqli_error($db));
                        $user_name=mysqli_fetch_assoc($get_user_name);
                      ?>
                      <ul><?php echo h($user_name['fullname'])?>さんの投稿</ul>
                      <ul><?php echo h($post['category'])?></ul>
                      <ul>期限:<?php echo h($post['due'])?></ul>
                      <ul><?php echo h($post['payment'])?> pessos</ul>
                      <ul><?php echo h($post['insentive'])?> </ul> 
                      <ul>[<a href="./show?id=<?php echo h($post['id'])?>">詳しく見る</a>]</ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile;?>
        </div>
      </div>
    </div>  
  </section>
<?php endif; ?>
<!-- 期限の近い順 -->
<?php if (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'deadline'):?>
  <section class="services">
    <div class="container-fluid">
      <div class= "row"> 
        <div class= "media-row col-xs-12 bg-primary" style="margin-top:30px">
        <div class="list_title">
          <h3>期限の近い順に変更ができるよ</h3>  
        </div>  
          <?php while ($post=mysqli_fetch_assoc($deadline_posts)):?>
            <div class= "col-sm-6 col-xs-12 col-md-4 col-lg-4">
              <div class="well">
                <div class="media">
                <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" style="float:left">
                  <div class="media-body" >
                    <?php if(!empty($post['candidate_id'])):?>
                      <div class="contracted"><p>CONTRACTED!</p></div>
                    <?php else:?>
                      <div class="wanted"><p>WANTED!</p></div>
                    <?php endif;?>
                    <h4 class="media-heading"><?php echo h($post['thing'])?></h4>
                    <div class="list-inline list-unstyled" style="float:left">
                      <?php 
                        //ユーザの名前を取得
                        $sql=sprintf("SELECT fullname FROM users WHERE id=%d",
                            $post['client_id']
                        );
                        $get_user_name=mysqli_query($db, $sql) or die (mysqli_error($db));
                        $user_name=mysqli_fetch_assoc($get_user_name);
                      ?>
                      <ul><?php echo h($user_name['fullname'])?>さんの投稿</ul>
                      <ul><?php echo h($post['category'])?></ul>
                      <ul>期限:<?php echo h($post['due'])?></ul>
                      <ul><?php echo h($post['payment'])?> pessos</ul>
                      <ul><?php echo h($post['insentive'])?> </ul> 
                      <ul>[<a href="./show?id=<?php echo h($post['id'])?>">詳しく見る</a>]</ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile;?>
        </div>
      </div>
    </div>  
  </section>
<?php endif; ?>
<!-- 承認済み -->
<?php if (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'accepted'):?>
  <section class="services">
    <div class="container-fluid">
      <div class= "row"> 
        <div class= "media-row col-xs-12 bg-primary" style="margin-top:30px">
          <?php if(status()==2):?>
            <div class="list_title">
              <h3>この内容を準備してね</h3>  
            </div>  
          <?php elseif(status()==3):?>
            <div class="list_title">
              <h3>受け入れられた投稿はこちら</h3>  
            </div>
          <?php endif;?>
          <?php while ($post=mysqli_fetch_assoc($accepted_posts)):?>
            <div class= "col-sm-6 col-xs-12 col-md-4 col-lg-4">
              <div class="well">
                <div class="media">
                <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" style="float:left">
                  <div class="media-body" >
                    <h4 class="media-heading"><?php echo h($post['thing'])?></h4>
                    <div class="list-inline list-unstyled" style="float:left">
                      <?php 
                        //ユーザの名前を取得
                        $sql=sprintf("SELECT fullname FROM users WHERE id=%d",
                            $post['client_id']
                        );
                        $get_user_name=mysqli_query($db, $sql) or die (mysqli_error($db));
                        $user_name=mysqli_fetch_assoc($get_user_name);
                      ?>
                      <ul><?php echo h($user_name['fullname'])?>さんの投稿</ul>
                      <ul><?php echo h($post['category'])?></ul>
                      <ul>期限:<?php echo h($post['due'])?></ul>
                      <ul><?php echo h($post['payment'])?> pessos</ul>
                      <ul><?php echo h($post['insentive'])?> </ul> 
                      <ul>[<a href="./show?id=<?php echo h($post['id'])?>">詳しく見る</a>]</ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile;?>
        </div>
      </div>
    </div>  
  </section>
<?php endif; ?>
<!-- 投稿にきたリクエスト -->
<?php if (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'request_index'):?>
  <section class="services">
    <?php include('submit_index.php');?>
  </section> 
<?php endif; ?>




  
