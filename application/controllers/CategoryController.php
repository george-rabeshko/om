<?php
  /**
   * Контроллер головнії сторінки
   */
  class Category extends Base
  {
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

      $a = Articles::instance();
      $this->title = '';
      $this->articles = (isset($_GET['n']))
        ? $a->getCertainArticles($_GET['n'])
        : $a->getAllArticles();
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      $data = array('articles' => $this->articles);
      $this->content = $this->setTemplate('application/views/CategoryView.php', $data);
      parent::onOutput();
    }
  }
