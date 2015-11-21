<?php
  /**
   * Загальна модель для всіх записів
   */
  class Articles extends Model
  {
    private static $instance;
  	private $dbh;
    private $users;

  	// Отримання єдиного екземпляру класу (singleton)
  	public static function instance()
  	{
  		if (self::$instance == null)
  			self::$instance = new Articles;

  		return self::$instance;
  	}

  	// Конструктор
  	public function __construct()
  	{
  		$this->dbh = Database::instance();
      $this->users = Users::instance();
  	}

    // Видобування статті з бази данних
    public function getArticle($postid)
    {
      $sql = 'SELECT * FROM articles WHERE id = ' . $postid;
      return $this->dbh->select($sql);
    }

    // Отримання списку категорій
    public function getAllArticles()
    {
      $sql = 'SELECT id, title, substring(content, 1, 450) AS content, img, rating, date, category FROM articles ORDER BY id DESC';
      return $this->dbh->select($sql);
    }

    // Отримання списку категорій
    public function getCertainArticles($catid)
    {
      $sql = 'SELECT id, title, substring(content, 1, 450) AS content, img, rating, date, category FROM articles WHERE category = ' . $catid;
      return $this->dbh->select($sql);
    }

    // Видобування статті з бази данних
    public function getComments($postid)
    {
      $sql = 'SELECT * FROM comments WHERE postid = ' . $postid . ' AND `show` = 1 ORDER BY id DESC';
      return $this->dbh->select($sql);
    }

    // Отримати назву категорії
    public function getCategoryName($id)
    {
      $sql = 'SELECT name FROM categories WHERE id = ' . $id;
      return $this->dbh->select($sql);
    }
  }
