<?php
  /**
   * Контролер сторінки авторизації
   */
  class Login extends Base
  {
    private $login;

    // Конструктор
    public function __construct()
    {
      parent::__construct();
      $this->login = '';
    }

    // Віртуальний обробник запиту. Задає інформацію для шаблона
    protected function OnInput()
    {
      // Вихід користувача із системи
      $users = Users::instance();
      $users->logout();

      parent::onInput();

      // Обробка надсилання форми
      if ($this->isPost()) {
        if ($users->login(
          $_POST['login'],
          $_POST['password'],
          isset($_POST['remember'])
        )) {
          header('Location: .');
          die();
        }

        $this->login = $_POST['login'];
      }
    }

    // Віртуальний генератор HTML
    protected function OnOutput()
    {
      // Генерація контенту форми входу
      $data = array('login' => $this->login);
      $this->content = $this->setTemplate('application/views/LoginView.php', $data);
      
      parent::OnOutput();
    }
  }
