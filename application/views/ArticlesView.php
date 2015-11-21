<?php if (empty($articles)): ?>
<h2>Категорія пуста</h2>
<p>Немає данних</p>
<?php else: foreach ($articles as $a): ?>
<article id="post-<?=$a['id']?>" class="post">
  <h2 class="post-title">
    <a href="<?="?c=category&catid={$a['category']}&postid={$a['id']}"?>"><?=strip_tags($a['title'])?></a>
  </h2>
  <img src="<?=(is_null($a['img'])) ? 'css/img/no-photo.png' : $a['img']?>" class="intro-img" alt="">
  <p><?=strip_tags($a['content'])?>...</p>
  <p><a href="<?="?c=category&catid={$a['category']}&postid={$a['id']}"?>" class="button">Детальніше...</a><p>
</article>
<?php endforeach; endif; ?>

<?php
  $page = (isset($_GET['p'])) ? $_GET['p'] : 1;

  // Находим две ближайшие станицы с обоих краев, если они есть
  if($page - 5 > 0) $page5left = ' <a href=?c=home&p='. ($page - 5) .'>'. ($page - 5) .'</a> ';
  if($page - 4 > 0) $page4left = ' <a href=?c=home&p='. ($page - 4) .'>'. ($page - 4) .'</a> ';
  if($page - 3 > 0) $page3left = ' <a href=?c=home&p='. ($page - 3) .'>'. ($page - 3) .'</a> ';
  if($page - 2 > 0) $page2left = ' <a href=?c=home&p='. ($page - 2) .'>'. ($page - 2) .'</a> ';
  if($page - 1 > 0) $page1left = '<a href=?c=home&p='. ($page - 1) .'>'. ($page - 1) .'</a> ';

  if($page + 5 <= $total) $page5right = ' <a href=?c=home&p='. ($page + 5) .'>'. ($page + 5) .'</a>';
  if($page + 4 <= $total) $page4right = ' <a href=?c=home&p='. ($page + 4) .'>'. ($page + 4) .'</a>';
  if($page + 3 <= $total) $page3right = ' <a href=?c=home&p='. ($page + 3) .'>'. ($page + 3) .'</a>';
  if($page + 2 <= $total) $page2right = ' <a href=?c=home&p='. ($page + 2) .'>'. ($page + 2) .'</a>';
  if($page + 1 <= $total) $page1right = ' <a href=?c=home&p='. ($page + 1) .'>'. ($page + 1) .'</a>';

  // Вывод меню если страниц больше одной

  if ($total > 1) {
    Error_Reporting(E_ALL & ~E_NOTICE);
    echo "<div class=\"pstrnav\">";
    echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<span>'.$page.'</span>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
    echo "</div>";
  }
?>
