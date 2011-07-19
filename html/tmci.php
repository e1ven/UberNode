<?php
define('TMCI_REF_VALID', 0);
define('TMCI_REF_INVALID', 1);
define('TMCI_REF_INVALID_IP', 2);
define('TMCI_REF_INVALID_ARK_PUBURI', 4);
define('TMCI_REF_INVALID_ARK_NUMBER', 8);
define('TMCI_REF_INVALID_IDENTITY', 16);
define('TMCI_REF_INVALID_NODE_NAME', 32);
define('TMCI_REF_INVALID_USES_TESTNET', 64);
define('TMCI_NODE_CONNECTED', 'CONNECTED');
define('TMCI_NODE_NEVER_CONNECTED', 'NEVER CONNECTED');
define('TMCI_NODE_BACKED_OFF', 'BACKED OFF');
define('TMCI_NODE_DISCONNECTED', 'DISCONNECTED');
/**
 * TMCI Class
 * 
 * Frontend to the FreeNet TMCI 'telnet' console
 * 
 * @author Tim Mylemans
 * @copyright the iFreed.net team
 *
 */
class TMCI
{

	function ParseReference($Reference){
		$Reference = str_replace("\r", "\n", $Reference);
		$Reference = str_replace("\n\n", "\n", $Reference);
		
		$Lines = explode("\n", $Reference);
		$Count = count($Lines);
		if ($Count == 0){
			return false;
		}
		
		$Result = array();
		for ($i=0;$i<$Count;$i++)
		{
			$Line = &$Lines[$i];	
			
			if ($Line == 'End'){
				return $Result;
			}
			$Part = explode('=', $Line, 2);
			if (count($Part) == 1){
				return false;
			}
			$Result[$Part[0]] =  $Part[1];			
		}		
		return $Result;
	}
	
	// First check for validness!
	function hasPeerByReference($Reference){
		$Refs = TMCI::ParseReference($Reference);
		if (!$Refs){
			return 0;
		}		
		$identity = $Refs['identity'];
		
		$result = TMCI::RunCommand('HAVEPEER:' . $identity);
		if (!$result){
			return 0;
		}
				
		if (substr($result, 0, 4) == 'true'){
			return true;
		}else{
			return false;
		}		
	}
	
	function hasPeerByIdentity($Identity){	
		$result = TMCI::RunCommand('HAVEPEER:' . $Identity);
		if (!$result){
			return 0;
		}
				
		if (substr($result, 0, 4) == 'true'){
			return true;
		}else{
			return false;
		}		
	}
	function requestUpdate(){
		return TMCI::RunCommand('UPDATE');
	}
	function removePeerByReference($Reference){
		$Refs = TMCI::ParseReference($Reference);
		if (!$Refs){
			return 0;
		}		
		if (!TMCI::hasPeerByReference($Reference)){
			return true;
		}
		
		$identity = $Refs['identity'];
		
		$result = TMCI::RunCommand('REMOVEPEER:' . $identity);
		if (!$result){
			return 0;
		}
			
		if (substr($result, 0, 16) == 'peer removed for'){
			return true;
		}else{
			return false;
		}		
	}
	function listPeers(){
		$Data = TMCI::RunCommand('PEERS');
		$Peers = explode("\n", $Data);
		$pCount = count($Peers);
		$Result = array();
		for($i=0;$i<$pCount;$i++){
			$Peer = explode("\t", $Peers[$i]);
			if (count($Peer) != 6){
				return $Result;
			}else{
				$Result[$i]['name'] = $Peer[0];
				$Result[$i]['physical_udp'] = $Peer[1];
				$Result[$i]['identity'] = $Peer[2];
				$Result[$i]['location'] = $Peer[3];
				$Result[$i]['status'] = $Peer[4];
				$Result[$i]['idle'] = $Peer[5];
			}
		}
		
		return $Result;
	}
	function removePeerByIdentity($Identity){
		if (!TMCI::hasPeerByIdentity($Identity)){
			return true;
		}
	
		$result = TMCI::RunCommand('SETPEERLISTENONLY:' . $Identity);
		if (!$result){
			return 0;
		}
		if (substr($result, 0, 23) == 'set ListenOnly suceeded'){
			return true;
		}else{
			return false;
		}		
	}
	
	function addReference($Reference){
		if (TMCI::hasPeerByReference($Reference))
		{
		 return false;
		}
		if (TMCI::isValidReference($Reference) == true){
			$Command = "ADDPEER:\n$Reference\n";
			TMCI::RunCommand($Command);
			if (TMCI::hasPeerByReference($Reference)){
				return true;
			}else{
				return false;
			}
		}
		
		return false;
	}
	
	function RunCommand($Command, $Server = "ubernode.net", $Port = 2323, $Timeout = 5){
		$fp = fsockopen($Server, $Port, $errno, $errstr, 5);
		if (!$fp) {
			// Temp hack to retrieve error (on error.. :P)
			$GLOBALS['TMCI']['errstr'] = $errstr;
			$GLOBALS['TMCI']['errno'] = $errno;
			
			return false;
		}
		
		fwrite($fp, "A\n" . $Command . "\nQUIT\n");
		$Data = '';
		$Empty = 0;
		while (!feof($fp)) {
			$Line = fgets($fp);
			//echo "$Line";
			$Line = str_replace("\r", "\n", $Line);
			$Line = str_replace("\n\n", "\n", $Line);
			if ($Empty == 1){
			
				$Data .= $Line;
			}
			if (($Line == "TMCI> \n") || ($Line == "\n")){
				$Empty++;
			}
			if ($Empty ==2){
				@fclose($fp);
				$Data = trim($Data);
				// Fix?
				if (substr($Data, 0, 6) == 'TMCI> '){
					$Data = substr($Data, 6);
				}
				
				return $Data;
			}
		}
		@fclose($fp);
		return false;
	}
	function isValidReference($Reference){
		$Parsed = TMCI::ParseReference($Reference);
		
		if (!$Parsed)
		{
			return false;
		}
		
		$Count = count($Parsed);
		
		for ($i=0;$i<$Count;$i++)
		{
			$Section = &$Parsed[$i];
			
			switch(strtolower($Section[0])){
				case 'physical.udp':
					if (!TMCI::isRemoteIP($Section[1]))
					{
						return TMCI_INVALID_IP;
					}
				break;
				case 'ark.puburi':
					if ($Section[1] = '')
					{
						return TMCI_REF_INVALID_ARK_PUBURI;
					}
				break;
				case 'ark.number':
					if ($Section[1] = '')
					{
						return TMCI_REF_INVALID_ARK_NUMBER;
					}
				break;
				case 'identity':
					if (($Section[1] = '') || (strlen($Section[1]) != 43))
					{
						return TMCI_REF_INVALID_IDENTITY;
					}
				break;
				case 'dsapubkey.y':
				case 'dsagroup.p':
				case 'dsagroup.g':
				case 'dsagroup.g':
				case 'version':
				case 'base64':
				case 'location':
					if ($Section[1] = '')
					{
						return TMCI_REF_INVALID;
					}
				break;
				case 'myname':
					if ($Section[1] = '')
					{
						return TMCI_REF_INVALID;
					}
				break;
				case 'testnet':
					if (strtolower($Section[1]) == 'true')
					{
						return TMCI_REF_USES_TESTNET;
					}
				break;
			}
		}
		return true;
	}
	function isRemoteIP($IP){
		$a = $IP;
		
		if ((ip2long($a) == -1) || (ip2long($a) == false)){
			return false;
		}
		if ($a == '' || TMCI::IPMatch($a, "10.0.0.0", 8) || TMCI::IPMatch($a, "127.0.0.1", 8) || TMCI::IPMatch($a, "172.16.0.0", 12) || TMCI::IPMatch($a, "192.168.0.0", 16) || TMCI::IPMatch($a, "255.255.255.255", 32))
		{
			return true;
		}
		
		return false;
	}
	function IPMatch ($ip1, $ip2, $mask) {
	  if ((ip2long($ip1) & ~(pow(2, 32-$mask)-1)) == (ip2long($ip2) & ~(pow(2, 32-$mask)-1))) return true;
	  else return false;
	}
}
?>
