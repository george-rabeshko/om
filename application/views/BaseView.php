<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="css/reset.css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/main.css" media="screen" charset="utf-8">
  </head>

  <body id="main-container">
    <!-- BEGIN header -->
    <header id="header">
      <div class="logo">
        <h1>Наше життя</h1>
        <h4>Любомльська районна газета</h4>
      </div>

      <div class="menu" id="menu">
        <nav>
          <ul>
            <?php foreach ($menu as $m): ?>
            <li><a href="<?=$m['uri']?>" <?=(strpos($_SERVER['REQUEST_URI'], $m['uri'])) ? 'class="active"' : ''?>><?=$m['name']?></a></li>
            <?php endforeach; ?>
          </ul>
        </nav>
      </div>
    </header>
    <!-- END header -->

    <!-- BEGIN page-container -->
    <div class="page-container">
      <div id="page">
        <!-- BEGIN sidebar -->
        <div class="slider">
          <img src="css/img/slide-photo.jpg" alt="Любомльська районна газета">
        </div>
        <!-- END sidebar -->

        <!-- BEGIN left-bar (categories block) -->
        <div class="left-bar">
          <div class="categories">
            <h3>Категорії</h3>
            <ul>
              <?php foreach ($categories as $c): ?>
              <li><a href="?c=category&n=<?=$c['uri']?>" <?=(strpos($_SERVER['REQUEST_URI'], $c['uri'])) ? 'class="active-category"' : ''; ?>><?=$c['name']?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <!-- END left-bar -->

        <!-- BEGIN content (article block) -->
        <div class="content">
          <?= $content; ?>
        </div>
        <!-- END content -->

        <!-- BEGIN right-bar (text-block) -->
        <div class="right-bar">
          <div>
            <h3>Інформація</h3>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
          </div>

          <div>
            <h3>Додатково</h3>
            <p>
              Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
          </div>
        </div>
        <!-- END right-bar -->
      </div>
    </div>
    <!-- END page-container -->

    <!-- BEGIN footer -->
    <footer id="footer">
      <div class="footer-cols">
        <div class="fi-column">
          <h3>Наша адреса</h3>
          <p>
            44300 м.Любомль<br>
            вул. 1 Травня, 18<br>
            тел.: (03377) 2-43-51,<br>
            2-41-31, 2-41-75, 2-22-50<br>
            e-mail: <a href="mailto:life@lb.lt.ukrtel.net">life@lb.lt.ukrtel.net</a>
          </p>
        </div>

        <div class="se-column">
          <h3>Банківські реквізити</h3>
          <p>
            р/р 26008233816001 КБ<br>
            «ПриватБанк» м.Луцьк<br>
            Код 02471710 МФО303440<br>
            Інд.под.№024717103101<br>
            № свід.02491213
          </p>
        </div>

        <div class="th-column">
          <h3>Найпопулярніші статі</h3>
          <!-- TODO: написати скрипт який виводить найпопулярніші статті -->
        </div>

        <div class="fo-column">
          <h3>Авторське право</h3>
          <p>
            Думки авторів публікацій можуть не збігатися з позицією редакції. За редакцією лишається право редагувати, скорочувати тексти або відхиляти матеріали. За достовірність інформації відповідальність несуть автори і рекламодавці. Рукописи не рецензуються і не повертаються.
          </p>
        </div>
      </div>

      <div class="copyright">
        <p>© 2010-<?= date('Y'); ?> "Наше життя" - любомльська районна газета. Всі права захищено</p>
      </div>
    </footer>
    <!-- END footer -->
  </body>
</html>
