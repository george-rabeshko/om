<h2><?=$article[0]['title']?></h2>
<div class="">
  <img src="<?=(is_null($article['img'])) ? 'css/img/no-photo.png' : $a['img']?>" alt="" />
  <?=$article[0]['content']?>
</div>

<!-- <?php if (ALLOW_COMMENTS): ?> -->
<div class="comments">
  <h3>Коментарі</h3>

  <div class="add-comment">
    <h4>Додати новий</h4>

    <form action="" method="post" class="comment-form">
      <input type="text" name="author" value="" placeholder="Ім’я">
      <textarea name="text" cols="30" rows="10" placeholder="Коментар"></textarea>
      <input type="submit" class="submit button" value="Надіслати">
    </form>
  </div>

  <div class="last-comments">
    <h4>Останні додані</h4>

    <?php if (empty($comments)): ?>
    <p class="bold">Коментарі відсутні</p class="bold">
    <?php else: foreach ($comments as $comment): ?>
    <div class="comment">
      <h6 class="bold"><?=$comment['author']?></h6>
      <p class="date">(<?=$comment['date']?>)</p>
      <p><?=$comment['content']?></p>
    </div>
    <?php endforeach; endif; ?>
  </div>
</div>
<!-- <?php endif; ?> -->
