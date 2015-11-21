<?php
  /**
   * Контроллер головнії сторінки
   */
  class Category extends Base
  {
    protected $article;
    protected $articles;

    // Конструктор
    function __construct()
    {
      parent::__construct();
    }

    // Віртуальний обробник запиту. Задає інформацію для шаблона
    protected function onInput()
    {
      parent::onInput();

      // Підключаємо необхідні компоненти
      $a = Articles::instance();
      $dbh = Database::instance();

      $this->title = 'Категорії';

      if ($this->isPost()) {
        $data = array(
          'author' => $_POST['author'],
          'content' => $_POST['text'],
          'date' => date("Y-m-d"),
          'postid' => $_GET['postid']
        );

        if ($dbh->insert('comments', $data)) {
          setcookie('note', 'Коментар буде додано після перевірки модератором.');
          header('Location: #comments');
        }
      }

      if (isset($_COOKIE['note'])) setcookie('note', '');

      if (isset($_GET['postid']))
        $this->article = $a->getArticle($_GET['postid']);
      elseif (isset($_GET['catid']))
        $this->articles = $a->getCertainArticles($_GET['catid']);
      else
        $this->articles = $a->getAllArticles();
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      if (!empty($this->article)) {
        // Підключаємо необхідні компоненти
        $a = Articles::instance();

        $data = array(
          'article' => $this->article,
          'comments' => $a->getComments($_GET['postid']),
          'note' => (isset($_COOKIE['note'])) ? $_COOKIE['note'] : false
        );
        $this->content = $this->setTemplate('application/views/SingleView.php', $data);
      } else {
        $data = array('articles' => $this->articles);
        $this->content = $this->setTemplate('application/views/ArticlesView.php', $data);
      }

      parent::onOutput();
    }
  }
