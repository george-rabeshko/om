<?php if (empty($articles)): ?>
<h2>Категорія пуста</h2>
<p>Немає данних</p>
<?php else: foreach ($articles as $a): ?>
<article id="post-<?=$a['id']?>" class="post">
  <h2 class="post-title">
    <a href="<?="?c=category&catid={$a['category']}&postid={$a['id']}"?>"><?=$a['title']?></a>
  </h2>
  <img src="<?=(is_null($a['img'])) ? 'css/img/no-photo.png' : $a['img']?>" alt="">
  <p><?=$a['content']?></p>
  <p><a href="<?="?c=category&catid={$a['category']}&postid={$a['id']}"?>" class="button">Детальніше...</a><p>
</article>
<?php endforeach; endif; ?>
