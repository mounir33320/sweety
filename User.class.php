<?php 
class User{
	private $id,
			$ip,
			$codePromo,
            $date_register;

	public function __construct(array $datas){
		$this->hydrate($datas);
		$this->date_register = new DateTime("now");
	}

	public function hydrate(array $datas){
		foreach($datas as $key => $value){
			$method = "set" .ucfirst($key);
			if(method_exists($this, $method)){
				$this->$method($value);
			}
		}
	}

	//Getters
	public function getId(){
		return $this->id;
	}

	public function getIp(){
		return $this->ip;
	}

	public function getCodePromo(){
		return $this->codePromo;
	}

	//Setters
	public function setId($id){
		$id = (int) $id;
		if($id > 0){
			$this->id = $id;
		}
	}

	public function setIp($ip){
		$this->ip = $ip;
	}

	public function setCodePromo($code){
		$this->codePromo = $code;
	}

	public function generateCode($longueur = 8)	{
		$year = date("Y");
		$month = date("m");
		$day = date("d");

		$caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$longueurMax = strlen($caracteres);
		$chaineAleatoire = $year."-".$month."-".$day."-";
		 
		for ($i = 0; $i < $longueur; $i++)
		{
			$chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
		}
	 	return $chaineAleatoire;
	}

    /**
     * @return mixed
     */
    public function getDateRegister()
    {
        return $this->date_register;
    }

    /**
     * @param mixed $date_register
     */
    public function setDateRegister($date_register)
    {
        $this->date_register = $date_register;
    }


}