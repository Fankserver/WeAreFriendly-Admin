<?php
//	Initialisieren der SQL Klasse. Aufruf erfolgt in der Config.
class arma {
	var $mysqllink=0;
	var $mysqldb="dummy";
	
	//	Funktion für den Connect zur Datenbank.
	function arma($mysqlhost,$mysqluser,$mysqlpasswd,$mysqldb) {
		$this->mysqllink=mysql_connect($mysqlhost,$mysqluser,$mysqlpasswd);
		if($this->mysqllink) {
			$this->mysqldb=$mysqldb;
		} 
		else {
			unset($this->mysqllink);
		}
	}
	
	function lesen($tabelle, $where="", $order="", $limit="", $ausgabe="", $felder="") {
		if(!$this->mysqllink) {
			return FALSE;
		}
		$query="SELECT ";
		if(strlen($felder)>0)
			$query.=$felder;
		else        
			$query.="*";
		$query.=" FROM ".$tabelle;
		if(strlen($where)>0)
			$query.=" WHERE ".$where;
		if(strlen($order)>0)
			$query.=" ORDER BY ".$order;
		if(strlen($limit)>0)
			$query.=" LIMIT ".$limit;
		$this->query=$query;
		$result=mysql_db_query($this->mysqldb, $query,$this->mysqllink);
		if(!$result) {
			print mysql_error($this->mysqllink);
			print "<br />Query:<br />".htmlentities($query);
			return FALSE;
		}
		if($ausgabe=="J")
			return $result;
		else
			$this->daten=$result;
	}
    
	function loeschen($tabelle, $where=""){
		if(!$this->mysqllink) {
			return FALSE;
		}
		$query="DELETE ";
		$query.=" FROM ".$tabelle;
		if(strlen($where)>0)
			$query.=" WHERE ".$where;
		$result=mysql_db_query($this->mysqldb, $query,$this->mysqllink);
		if(!$result) {
			print mysql_error($this->mysqllink);
			return FALSE;
		}
		else
			return TRUE;
	}

	function schreiben($tabelle, $werte) {
		if(!$this->mysqllink) {
			return FALSE;
		}
		$query="REPLACE INTO ".$tabelle." values (";
		for($i=0; $i<count($werte); $i++) {
			if(!ereg("DATE_ADD", $werte[$i]))
				$werte[$i]="'".$werte[$i]."'";
			if($i<count($werte)-1)
				$query.="".$werte[$i].", ";
			else        
				$query.="".$werte[$i]."";
		}
		$query.=")";
		$result=mysql_db_query($this->mysqldb, $query, $this->mysqllink);
		if(!$result) {
			print mysql_error($this->mysqllink);
			return FALSE;
		}
		if(!mysql_affected_rows($this->mysqllink)) {
			print mysql_error($this->mysqllink);
			return FALSE;
		}
		return TRUE;
	}

	function masterwrite($tabelle, $werte) {
		if(!$this->mysqllink) {
			return FALSE;
		}
		$query="INSERT INTO ".$tabelle." values (";
		for($i=0; $i<count($werte); $i++) {
			if(!ereg("DATE_ADD", $werte[$i]))
				$werte[$i]="'".$werte[$i]."'";
			if($i<count($werte)-1)
				$query.="".$werte[$i].", ";
			else        
				$query.="".$werte[$i]."";
		}
		$query.=")";
		$result=mysql_db_query($this->mysqldb, $query, $this->mysqllink);
		if(!$result) {
			print mysql_error($this->mysqllink);
			return FALSE;
		}
		if(!mysql_affected_rows($this->mysqllink)) {
			print mysql_error($this->mysqllink);
			return FALSE;
		}
		return TRUE;
	}

	function id() {
		if(!$this->mysqllink) {
			return FALSE;
		}
		if (($used_id=mysql_insert_id($this->mysqllink))>0)
			return $used_id;
		else
			return "";
	}		
    
	function update($tabelle, $variablen, $werte, $where="") {
		if(!$this->mysqllink) {
			return FALSE;
		}
		$query="UPDATE ".$tabelle." SET ";
		for($i=0; $i<count($werte); $i++) {
			if(!ereg("DATE_ADD", $werte[$i]))
				$werte[$i]="'".$werte[$i]."'";
			if($i<count($werte)-1)
				$query.=$variablen[$i]."=".$werte[$i].", ";
			else        
				$query.=$variablen[$i]."=".$werte[$i]."";
		}
		if(strlen($where)>0)
			$query.=" WHERE ".$where;
		$result=mysql_db_query($this->mysqldb, $query, $this->mysqllink);
		if(!$result) {
			print mysql_error($this->mysqllink);
			return FALSE;
		}
		return TRUE;
	}
}
?>