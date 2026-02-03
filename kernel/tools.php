<?php
    /**
    * Funcao para encriptar a password seja no login ou quando
    * se insere na BD um novo utilizador.
    * @param $password necessaria.
    */
    function encriptacao($password,$Chave=CHAVE_ENCRIPTACAO) {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
        $passcrypt = trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $Chave.$password, trim($password), MCRYPT_MODE_ECB));
        $encode = base64_encode($passcrypt);
        return md5($encode);
    }

    function NumeroValido($Str) {
        $Return = true;
        if ($Str < 0) {
		    $Return = false;
        }
    
        // We're converting input to a int, then string and comparing to original
        $Return = ($Str == strval(intval($Str)) ? true : false);
        return $Return;
    }


    function nomeiaFicheiro($origem) {
   
        //teste $string = 'Ë À Ì Â Í Ã Î Ä Ï Ç Ò È Ó É Ô Ê Õ Ö ê Ù ë Ú î Û ï Ü ô Ý õ â û ã ÿ ç'

        $normalizeChars = array(
            'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
            'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
            'Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
            'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
            'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
            'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
            'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
            'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',

            ' ' => '', //espaços out
            //Caracteres especiais que o windows aceita mas o filesystem do linux/unix ou o mysql podem não aceitar
            //#$%&()=«»@£€§{[]}'+¨´`ºª~^,;-_

            '#' => '', '$' => '', '&' => '', '(' => '', ')' => '', '=' => '', '«' => '', '»' => '', '@' => '',
            '£' => '', '€' => '', '§' => '', '{' => '', '[' => '', ']' => '', '}' => '', '\"' => '','\'' => '',
            '´' => '', '`' => '', 'º' => '', 'ª' => '', '~' => '', '^' => '', ',' => '', ';' => '', '-' => '',
            '%' => '', '+' => '', '¨' => '', '\\' =>''
        );


        //Output: E A I A I A I A I C O E O E O E O O e U e U i U i U o Y o a u a y c
        return strtr($origem, $normalizeChars);
    }


  // This is preferable to htmlspecialchars because it doesn't screw up upon a double escape
  function Str($Str) {
  		if ($Str === null || $Str === false || is_array($Str)) {
  				return '';
  		}
  		if ($Str != '' && !NumeroValido($Str)) {
  				$Str = cria_utf8($Str);
  				$Str = mb_convert_encoding($Str, "HTML-ENTITIES", "UTF-8");
  				$Str = preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,5};)/m", "&amp;", $Str);
  				$Replace = array("'", '"', "<", ">", '&#128;', '&#130;', '&#131;', '&#132;', '&#133;', '&#134;', '&#135;', '&#136;', '&#137;', '&#138;', '&#139;',
  						'&#140;', '&#142;', '&#145;', '&#146;', '&#147;', '&#148;', '&#149;', '&#150;', '&#151;', '&#152;', '&#153;', '&#154;', '&#155;', '&#156;',
  						'&#158;', '&#159;');
  				$With = array('&#39;', '&quot;', '&lt;', '&gt;', '&#8364;', '&#8218;', '&#402;', '&#8222;', '&#8230;', '&#8224;', '&#8225;', '&#710;', '&#8240;',
  						'&#352;', '&#8249;', '&#338;', '&#381;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8226;', '&#8211;', '&#8212;', '&#732;', '&#8482;', '&#353;',
  						'&#8250;', '&#339;', '&#382;', '&#376;');
  				$Str = str_replace($Replace, $With, $Str);
  		}
  		return $Str;
  }


  function cria_utf8($Str) {
  		if ($Str != "") {
  				if (is_utf8($Str)) {
  						$Encoding = "UTF-8";
  				}
  				if (empty($Encoding)) {
  						$Encoding = mb_detect_encoding($Str, 'UTF-8, ISO-8859-1');
  				}
  				if (empty($Encoding)) {
  						$Encoding = "ISO-8859-1";
  				}
  				if ($Encoding == "UTF-8") {
  						return $Str;
  				} else {
  						return @mb_convert_encoding($Str, "UTF-8", $Encoding);
  				}
  		}
  }


  function is_utf8($Str) {
  		return preg_match('%^(?:
		[\x09\x0A\x0D\x20-\x7E]			 // ASCII
		| [\xC2-\xDF][\x80-\xBF]			// non-overlong 2-byte
		| \xE0[\xA0-\xBF][\x80-\xBF]		// excluding overlongs
		| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} // straight 3-byte
		| \xED[\x80-\x9F][\x80-\xBF]		// excluding surrogates
		| \xF0[\x90-\xBF][\x80-\xBF]{2}	 // planes 1-3
		| [\xF1-\xF3][\x80-\xBF]{3}		 // planes 4-15
		| \xF4[\x80-\x8F][\x80-\xBF]{2}	 // plane 16
		)*$%xs', $Str);
  }
  

  function esc_url($url) {
 
        if ('' == $url) {
            return $url;
        }

        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = (string) $url;

        $count = 1;
        while ($count) {
            $url = str_replace($strip, '', $url, $count);
        }

        $url = str_replace(';//', '://', $url);

        $url = htmlentities($url);

        $url = str_replace('&amp;', '&#038;', $url);
        $url = str_replace("'", '&#039;', $url);

        if ($url[0] !== '/') {
            // We're only interested in relative links from $_SERVER['PHP_SELF']
            return '';
        } else {
            return $url;
        }
    }
?>
