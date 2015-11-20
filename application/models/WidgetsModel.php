<?php
  /**
   * Базова модель
   */
  class Widgets extends Model
  {
    private static $instance;
  	private $dbh;
    private $users;

    // Отримання єдиного екземпляру класу (singleton)
  	public static function instance()
  	{
  		if (self::$instance == null)
  			self::$instance = new Widgets;

  		return self::$instance;
  	}

    // Конструктор
  	public function __construct()
  	{
  		$this->dbh = Database::instance();
      $this->users = Users::instance();
  	}

    // Отримання списку категорій
    public function getCategories()
    {
      $sql = 'SELECT * FROM categories';
      return $this->dbh->select($sql);
    }
  }
