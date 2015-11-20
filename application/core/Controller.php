<?php
  /**
   * Самий базовий клас.
   * Тут описуються методи, які притаманні будь-якому сайту.
   */
  abstract class Controller
  {
    // Конструктор
    function __construct()
    {
      # code...
    }

    // Обробка HTTP-запиту
    public function request()
    {
      $this->onInput();
      $this->onOutput();
    }

    // Віртуальний обробник запиту. Задає інформацію для шаблона
    protected function onInput()
    {
      # code...
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      # code...
    }

    // Перевірка на get-запит
    protected function isGet()
    {
      return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    // Перевірка на post-запит
    protected function isPost()
    {
      return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    // Генерація HTML-шаблону в змінну
    protected function setTemplate($path, $data = array())
    {
      foreach ($data as $key => $value) {
        $$key = $value;
      }

      ob_start();
        include $path;
      return ob_get_clean();
    }
  }
