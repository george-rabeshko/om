<?php
  /**
   * Загальна модель для всіх записів
   */
  class Articles extends Model
  {
    private static $instance;
  	private $dbh;
    private $users;
    public $total;

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
    public function getAllArticles($current_page)
    {
      $range = $this->toPaginate($current_page, 'articles');
      $sql = 'SELECT id, title, substring(content, 1, 450) AS content, img, rating, date, category FROM articles ORDER BY id DESC LIMIT ' . $range['start'] . ',' . $range['num'];
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

    // Посторінкова навігація
    public function toPaginate($current_page, $table, $num = 10)
    {
      $articles_count = $this->dbh->select("SELECT count(*) FROM $table");
      $articles = $articles_count[0]['count(*)'];
      $total = intval(($articles - 1) / $num) + 1;

      if(empty($current_page) or $current_page < 0) $current_page = 1;
      if($current_page > $total) $current_page = $total;

      $start = $current_page * $num - $num;

      $this->total = $total;

      return array(
        'start' => $start,
        'num' => $num
      );
    }
  }
