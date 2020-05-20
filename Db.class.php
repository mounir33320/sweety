<?php 
class Db{
	private $host = "localhost",
			$username = "root",
			$password = "root",
			$database = "sweety",
			$db;

	public function __construct($host = null, $username = null, $password = null, $database = null){
		if($host != null){
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
		}

		try{
			$this->db = new PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8", $this->username,$this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}
		catch(PDOException $e){
			$e->getMessage();
			die("<h1>Impossible de se connecter à la base de donnée</h1>");
		}
	}

	public function add(User $user){
		$q = $this->db->prepare("INSERT INTO users(ip,codePromo)
											VALUES(:ip,:codePromo)");
		$q->bindValue(":ip",$user->getIp(),PDO::PARAM_STR);
		$q->bindValue(":codePromo", $user->getCodePromo(), PDO::PARAM_STR);
		$q->execute();

		$user->hydrate(["id" => $this->db->lastInsertId()]);
	}

	public function get($ip){
		$q = $this->db->prepare("SELECT * FROM users WHERE ip = :ip");
		$q->bindValue(":ip", $ip);
		$q->execute();

		return new User($q->fetch(PDO::FETCH_ASSOC));
	}

	public function getList(){
		$q = $this->db->query("SELECT * FROM users WHERE used = false ORDER BY date_register DESC");
		return $q->fetchAll(PDO::FETCH_OBJ);
	}

	public function getTrue($id){
		if(isset($id)){
			$q = $this->db->prepare("UPDATE users SET used = true WHERE id = " .$id);
			$q->execute();
		}
	}

	public function userExist($ip){
		 $q = $this->db->prepare("SELECT ip FROM users WHERE ip = :ip");
		 $q->bindValue(":ip", $ip);
		 $q->execute();
		 return (bool) $q->fetchColumn();
	}

	public function codeExist($code){
		$q = $this->db->prepare("SELECT ip FROM users WHERE codePromo = :codePromo");
		$q->bindValue(":codePromo", $code);
		$q->execute();
		return (bool) $q->fetchColumn();
	}

	public function count(){
		return $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
	}
}