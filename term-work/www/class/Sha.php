<?php
class Sha
{
	static private $inst = NULL;
	
	static function getSha() : Sha
    {
        if (self::$inst == NULL) { //singleton
            self::$inst = new Sha();
        }
        return self::$inst;
    }
	
	private $minLength = 8;
	private $maxLength = 40;
	private $salt = "n7T-@*e1";
	
	public function checkLength($password)
	{
		$passLength = strlen($password);
		return ( $passLength >= $this->minLength && $passLength <= $this->maxLength )
			? true : false;
	}
	public function hashPw($password)
	{
		return hash("sha256", ($this->salt . $password));
	}
}
?>