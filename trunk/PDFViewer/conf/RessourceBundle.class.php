<?php
class RessourceBundle{
	private static $_messages = array ();
	public static function _loadResources ($path){
		
		if (($f = @fopen ($path, 'r')) !== false) {
			$key = null;//juste pour ne pas avoir un warning d'existence
			// de la variable $key dans les analyseurs de code.

			$multiline = false;
			$linenumber = 0;
			while (!feof ($f)) {								
				if ($line = fgets ($f, 1024)){
					// length required for php < 4.2
					$linenumber++;
					if ($multiline){
						if (preg_match ("/^([^#]+)(\#?.*)$/", $line, $match)){
							// toujours vrai en fait
							$value = trim ($match[1]);
							if (strpos ($value, "\\u") !== false){
								$value=RessourceBundle::_utf16 ($value);
							}
							if ($multiline = (substr($value, -1) == "\\")){
								RessourceBundle::$_messages[$key] .= substr ($value,0,-1);
							}else{
								RessourceBundle::$_messages[$key] .= $value;
							}
						}
					}elseif (preg_match ("/^\s*(([^#=]+)=([^#]+))?(\#?.*)$/", $line, $match)){
						if ($match[1] != ''){
							// on a bien un cle=valeur
							$value = trim($match[3]);
							if($multiline = (substr($value,-1) == "\\")){
								$value = substr ($value,0,-1);
							}

							$key = trim($match[2]);

							if (strpos ($match[1], "\\u" ) !== false){
								$key = RessourceBundle::_utf16 ($key);
								$value = RessourceBundle::_utf16 ($value);
							}
							RessourceBundle::$_messages[$key] = $value;
						}else{
							if ($match[4] != '' && substr($match[4], 0, 1) != '#'){
								//throw new CopixException (_i18n ('copix:copix.error.i18n.syntaxError', array ($path, $linenumber)));
							}
						}
					}else{
						//throw new CopixException (_i18n ('copix:copix.error.i18n.syntaxError', array ($path, $linenumber)));
					}
				}
			}
			fclose ($f);
		}
	}

	public static function _utf16 ($str) {
		while (ereg ("\\\\u[0-9A-F]{4}", $str,$unicode)) {
			$repl = "&#".hexdec( $unicode[0] ).";";
			$str = str_replace( $unicode[0],$repl,$str );
		}
		return $str;
	}
	
	public static function get ($key){	
		if (isset (RessourceBundle::$_messages[$key])){
			return RessourceBundle::$_messages[$key];
		}else{
			return null;
		}
	}

}

?>