<?php

class Auth
{

    private $conn = null;
	
	static private $instance = NULL;
    static private $sessionId = NULL;
	
	private function __construct() //konstruktor pro singleton
    {
        if (isset($_SESSION['sessionId'])) {
            self::$sessionId = $_SESSION['sessionId'];
        }
        $this->conn = Conn::getPdo(); //spojení k db

    }
	
	static function getAuth() : Auth 
    {
        if (self::$instance == NULL) {
            self::$instance = new Auth(); //singleton
        }
        return self::$instance;
    }
	
	
	public function login() : bool
    {
        $stmt = $this->conn->prepare("SELECT Uzivatel.ID, Jmeno, Prijmeni, DatumNarozeni, Email, Nazev FROM Uzivatel 
			INNER JOIN Role on Role_ID = Role.ID WHERE Email = :mail and Secret = :pw");
        $stmt->bindParam(':mail', $_POST["mail"]);
        $stmt->bindParam(':pw', $_POST["pw"]);
        $stmt->execute();
        $u = $stmt->fetch();

        if ($u) {
			
            $uId = array('ID' => $u['id'], 'Jmeno' => $u['jmeno'], 'Prijmeni' => $u['prijmeni'], 'DatumNarozeni' => $u['DatumNarozeni'], 'Role' => $u['Nazev'], 'Mail' => $u['Email']);
			
            $_SESSION['sessionId'] = $uId; //předat userID do _SESSION
			/* další pomocné údaje pro identifikaci*/
            $_SESSION["ID"] = $u["ID"];
            $_SESSION["Jmeno"] = $u["Jmeno"];
            $_SESSION["Prijmeni"] = $u["Prijmeni"];
			$_SESSION['DatumNarozeni'] = $u['DatumNarozeni'];
            $_SESSION["Email"] = $u["Email"];
            $_SESSION["Role"] = $u["Nazev"];

            self::$sessionId = $uId;
			
            return true;
        } else {
            return false;
        }
    }
	
	
	public function hasId() : bool //overeni existence prihlasene relace
    {
        if (empty(self::$sessionId)) {
            return false;
        }
        return true;
    }
	
	 public function logout() //zruseni relace
    {
        unset($_SESSION['sessionId']);
        $_SESSION = array();
        session_destroy();
        self::$sessionId = NULL;
    }
    
}

?>