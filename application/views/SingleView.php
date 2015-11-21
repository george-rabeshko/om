<h2><?=$article[0]['title']?></h2>
<div class="">
  <img src="<?=(is_null($article['img'])) ? 'css/img/no-photo.png' : $a['img']?>" alt="" />
  <?=$article[0]['content']?>
</div>
