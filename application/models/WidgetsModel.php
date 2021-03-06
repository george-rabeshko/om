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
    public function getNavigation($table_name)
    {
      $sql = 'SELECT * FROM ' . $table_name;
      return $this->dbh->select($sql);
    }
  }
