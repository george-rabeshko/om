<?php foreach ($articles as $article): ?>
<article id="post-<?= $article['id']; ?>" class="post">
  <h2 class="post-title"><a href="#"><?= $article['title']; ?></a></h2>
  <img src="<?= (is_null($article['img'])) ? 'css/img/no-photo.png' : $article['img']; ?>" alt="">
  <p><?= $article['content']; ?></p>
  <p><a href="<?= $article['category'] . '/' . $article['id']; ?>" class="button">Детальніше...</a><p>
</article>
<?php endforeach; ?>
