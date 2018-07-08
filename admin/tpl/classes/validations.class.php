<?php

class Validations {
	
	public function first_name($first_name) {
		if(strlen($first_name) > 32) {
			return array('status' => 'error', 'message' => 'Ime mo�e sadr�avati maksimalno 32 znaka.');
		}
		return false;
	}
	
	public function last_name($last_name) {
		if(strlen($last_name) > 32) {
			return array('status' => 'error', 'message' => 'Prezime mo�e sadr�avati maksimalno 32 znaka.');
		}
		return false;
	}
	
	
	public function username($username) {
		if(strlen($username) > 16) {
			return array('status' => 'error', 'message' => 'Korisni�ko ime mo�e sadr�avati maksimalno 16 znakova.');
		}
		return false;
	}
	
	public function email($email) {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return array('status' => 'error', 'message' => 'Krivi unos e-mail formata.');
		} else {
			return false;
		}
	}
	
	public function password($password, $password2) {
		if(strlen($password) < 8) {
			return array('status' => 'error', 'message' => 'Lozinka mora imat minimalno 8 znakova!');
		} else {
			if($password !== $password2) {
				return array('status' => 'error', 'message' => 'Lozinke se ne poklapaju.');
			}
		}
		return false;
	}
	
	public function upcoming($upcoming_day) {
		foreach($upcoming_day as $day) {
			if(empty($day)) {
				return array('status' => 'error', 'message' => 'Datum mora biti unesen!');
			}
		}
		return false;
	}

	// public function permissions($permission) {
		// if($permission === '0') {
			// return array('status' => 'error', 'message' => 'Tip korisni�kog ra�una nije u redu.');
		// } else {
			// return false;
		// }
	// }
	
}

?>