
<?php
    
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

    $sql=sprintf('SELECT * FROM logistic_posts WHERE client_id=%d ORDER BY due ASC',
       $_SESSION['login_id']
    );
    $deadline_posts=mysqli_query($db, $sql) or die (mysqli_error($db));
?>

<!-- 表示の切り替え -->
<a href="top?sort=accepted">承認済み</a>
<a href="top?sort=unaccepted">承認待ち</a>
<a href="top?sort=all">全投稿データ</a>
<a href="top?sort=deadline">期限の近い順</a>
<!--全件表示 -->
<?php if ( empty($_REQUEST['sort']) || $_REQUEST['sort'] == 'all'):?>
  <h4>いままでの投稿</h4>
  <?php while ($post=mysqli_fetch_assoc($posts)):?>
    <div>
      <p><?php echo h($post['thing'])?></p>
      <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" width=100 hight=100>
      <p>カテゴリー:<?php echo h($post['category'])?></p>
      <p><?php echo h($post['insentive'])?></p>
      <p><?php echo h($post['payment'])?> pessos</p>
      <p>期限:<?php echo h($post['due'])?></p>
      <p>投稿日:<?php echo h($post['created'])?></p> 
      [<a href="./show?id=<?php echo h($post['id'])?>">show</a>]
    </div>
  <?php endwhile;?>
<?php elseif ($_REQUEST['sort'] == 'accepted'):?>
  <!-- 承認済みデータの表示 -->
  <h4>承認済み依頼</h4>
  <?php while ($post=mysqli_fetch_assoc($accepted_posts)):?>
    <div>
      <p><?php echo h($post['thing'])?></p>
      <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" width=100 hight=100>
      <p>カテゴリー:<?php echo h($post['category'])?></p>
      <p><?php echo h($post['insentive'])?></p>
      <p><?php echo h($post['payment'])?> pessos</p>
      <p>期限:<?php echo h($post['due'])?></p>
      <p>投稿日:<?php echo h($post['created'])?></p> 
      [<a href="./show?id=<?php echo h($post['id'])?>">show</a>]
    </div>
  <?php endwhile;?>
<?php elseif ($_REQUEST['sort'] == 'unaccepted'):?>
  <!-- 承認待ちデータの表示 -->
  <h4>承認待ち依頼</h4>
  <?php while ($post=mysqli_fetch_assoc($unverified_posts)):?>
    <div>
      <p><?php echo h($post['thing'])?></p>
      <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" width=100 hight=100>
      <p>カテゴリー:<?php echo h($post['category'])?></p>
      <p><?php echo h($post['insentive'])?></p>
      <p><?php echo h($post['payment'])?>pesso</p>
      <p>期限:<?php echo h($post['due'])?></p>
      <p>投稿日:<?php echo h($post['created'])?></p>
      [<a href="./show?id=<?php echo h($post['id'])?>">show</a>]
    </div>
  <?php endwhile;?>
<?php elseif ($_REQUEST['sort'] == 'deadline'):?>
  <!-- 期限の近い順 -->
  <h4>期限の近い順</h4>
  <?php while ($post=mysqli_fetch_assoc($deadline_posts)):?>
    <div>
      <p><?php echo h($post['thing'])?></p>
      <img src="../../views/logistic/logistic/image_thing/<?php echo h($post['image'])?>" width=100 hight=100>
      <p>カテゴリー:<?php echo h($post['category'])?></p>
      <p><?php echo h($post['insentive'])?></p>
      <p><?php echo h($post['payment'])?>pesso</p>
      <p>期限:<?php echo h($post['due'])?></p>
      <p>投稿日:<?php echo h($post['created'])?></p>
      [<a href="./show?id=<?php echo h($post['id'])?>">show</a>]
    </div>
  <?php endwhile;?>
<?php endif; ?>


