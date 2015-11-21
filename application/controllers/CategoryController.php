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

      $this->title = 'Категорії';

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
        $data = array('article' => $this->article);
        $this->content = $this->setTemplate('application/views/SingleView.php', $data);
      } else {
        $data = array('articles' => $this->articles);
        $this->content = $this->setTemplate('application/views/ArticlesView.php', $data);
      }

      parent::onOutput();
    }
  }
