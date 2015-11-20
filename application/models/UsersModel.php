<?php
  /**
   * Модель для створення та управління користувачами
   */
  class Users
  {
    private static $instance;	// екземпляр класу
  	private $db;              // драйвер БД
  	private $sid;             // ідентифікатор поточної сесії
  	private $uid;             // ідентифікатор потоіного користувача
  	private $onlineMap;       // карта online користувачів

    // Отримання єдиного екземпляру класу (singleton)
  	public static function instance()
  	{
  		if (self::$instance == null)
  			self::$instance = new Users();

  		return self::$instance;
  	}

  	// Конструктор
  	public function __construct()
  	{
  		$this->db = Database::instance();
  		$this->sid = null;
  		$this->uid = null;
  		$this->onlineMap = null;
  	}

    /**
     * Очистка невикористовуваних сесій
     */
  	public function clearSessions()
  	{
      $t = "time_last < '%s'";
  		$min = date('Y-m-d H:i:s', time() - 60 * 20);
  		$where = sprintf($t, $min);
  		$this->db->delete('sessions', $where);
  	}

    /**
     * Авторизація
     * $login     - логін
     * $password  - пароль
     * $remember  - чи треба запам’ятовувати користувача в куках
     * результат  - true чи false
     */
  	public function login($login, $password, $remember = true)
  	{
  		// добуваємо користувача з БД
  		$user = $this->getByLogin($login);

  		if ($user == null)
  			return false;

  		$id_user = $user['id_user'];

  		// перевіряємо пароль
  		if ($user['password'] != md5($password . PASS_PREF))
  			return false;

  		// запам’ятовуємо імя та md5(пароль)
  		if ($remember)
  		{
  			$expire = time() + 3600 * 24 * 100;
  			setcookie('login', $login, $expire);
  			setcookie('password', md5($password . PASS_PREF), $expire);
  		}

  		// відкриваємо сесію та запам’ятовуємо SID
  		$this->sid = $this->openSession($id_user);

  		return true;
  	}

    /**
     * Вихід із сайту
     */
  	public function logout()
  	{
  		setcookie('login', '', time() - 1);
  		setcookie('password', '', time() - 1);
  		unset($_COOKIE['login']);
  		unset($_COOKIE['password']);
  		unset($_SESSION['sid']);
  		$this->sid = null;
  		$this->uid = null;
  	}

    /**
     * Отримання користувача
     * $id_user   - якщо не вказоний, брати поточного
     * результат  - об’єкт користувача
     */
  	public function get($id_user = null)
  	{
  		// Якщо id_user не вказаний, беремо його по поточній сесії.
  		if ($id_user == null)
  			$id_user = $this->getUid();

  		if ($id_user == null)
  			return null;

  		// А тепер просто повертаємо користувача по id_user.
  		$t = "SELECT * FROM users WHERE id_user = '%d'";
  		$query = sprintf($t, $id_user);
  		$result = $this->db->select($query);
  		return $result[0];
  	}

    /**
     * Отримуємо користувача по логіну
     */
  	public function getByLogin($login)
  	{
  		$t = "SELECT * FROM users WHERE login = '%s'";
  		$query = sprintf($t, $login);
  		$result = $this->db->select($query);
  		return $result[0];
  	}

    /**
     * Перевірка наявності привілегії
     * $priv      - ім’я привілегії
     * $id_user   - якщо не вказаний, то для поточного користувача
     * результат  - true або false
     */
  	public function can($priv, $id_user = null)
  	{
  		if ($id_user == null)
  		    $id_user = $this->getUid();

  		if ($id_user == null)
  		    return false;

  		$t = "SELECT count(*) as cnt FROM privs2roles p2r
  		      LEFT JOIN users u ON u.id_role = p2r.id_role
  		      LEFT JOIN privs p ON p.id_priv = p2r.id_priv
  		      WHERE u.id_user = '%d' AND p.name = '%s'";

  		$query  = sprintf($t, $id_user, $priv);
  		$result = $this->db->select($query);

  		return ($result[0]['cnt'] > 0);
  	}

    /**
     * Перевірка авктивності користувача
     * $id_user   - ідентифікатор
     * результат  - true або false
     */
  	public function isOnline($id_user)
  	{
  		if ($this->onlineMap == null)
  		{
  		    $t = "SELECT DISTINCT id_user FROM sessions";
  		    $query  = sprintf($t, $id_user);
  		    $result = $this->db->select($query);

  		    foreach ($result as $item)
  		    	$this->onlineMap[$item['id_user']] = true;
  		}

  		return ($this->onlineMap[$id_user] != null);
  	}

    /**
     * Отриманя id поточного користувача
     * результат  - UID
     */
  	public function getUid()
  	{
  		// Перевірка кешу
  		if ($this->uid != null)
  			return $this->uid;

  		// Беремо по поточній сесії
  		$sid = $this->getSid();

  		if ($sid == null)
  			return null;

  		$t = "SELECT id_user FROM sessions WHERE sid = '%s'";
  		$query = sprintf($t, $sid);
  		$result = $this->db->select($query);

      // Якщо сесію не знайшли - значить користувач не авторизований
  		if (count($result) == 0)
  			return null;

      // Якщо знайшли - запам’ятовуємо її
  		return $this->uid = $result[0]['id_user'];
  	}

    /**
     * Повертає ідентифікатор поточнії сесії
     * результат  - UID
     */
  	private function getSid()
  	{
  		// Перевірка кешу
  		if ($this->sid != null)
  			return $this->sid;

  		// Шукаємо SID в сесії
  		$sid = isset($_SESSION['sid']);

  		// Якщо знайшли, то намагаємося оновити time_last в базі
  		// Заодно перевіряємо чи є там сесія
  		if ($sid != null)
  		{
  			$session = array();
  			$session['time_last'] = date('Y-m-d H:i:s');
  			$t = "sid = '%s'";
  			$where = sprintf($t, $sid);
  			$affected_rows = $this->db->update('sessions', $session, $where);

  			if ($affected_rows == 0)
  			{
  				$t = "SELECT count(*) FROM sessions WHERE sid = '%s'";
  				$query = sprintf($t, $sid);
  				$result = $this->db->select($query);

  				if ($result[0]['count(*)'] == 0)
  					$sid = null;
  			}
  		}

      // Сесія відсутня? Шукаємо лонін і md5 (пароль) в куках
  		// Тобіж намагаємося перепідключитися
  		if ($sid == null && isset($_COOKIE['login']))
  		{
  			$user = $this->getByLogin($_COOKIE['login']);

  			if ($user != null && $user['password'] == $_COOKIE['password'])
  				$sid = $this->openSession($user['id_user']);
  		}

  		// Запам’ятовуємо в кеш
  		if ($sid != null)
  			$this->sid = $sid;

  		// Повертаємо, нарешті, SID
  		return $sid;
  	}

    /**
     * Відкриття нової сесії
     * $id_user   - ідентифікатор
     * результат  - SID
     */
  	private function openSession($id_user)
  	{
  		// Генеруємо SID
  		$sid = $this->generateStr(10);

  		// Вставляемо SID в БД
  		$now = date('Y-m-d H:i:s');
  		$session = array();
  		$session['id_user'] = $id_user;
  		$session['sid'] = $sid;
  		$session['time_start'] = $now;
  		$session['time_last'] = $now;
  		$this->db->insert('sessions', $session);

  		// Реєструємо сесію в PHP сесію
  		$_SESSION['sid'] = $sid;

  		// Повертаємо SID
  		return $sid;
  	}

    /**
     * Генерація випадкової послідовності символів
     * $length    - її довжина
     * результат  - випадкови рядок
     */
  	private function generateStr($length = 10)
  	{
  		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
  		$code = "";
  		$clen = strlen($chars) - 1;

  		while (strlen($code) < $length)
        $code .= $chars[mt_rand(0, $clen)];

  		return $code;
  	}
  }
