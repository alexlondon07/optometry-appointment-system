<?php namespace App\Http\Controllers;

/**
 * Clase que contiene varios metodos utiles
 * @author Camilo Garzon Calle
 * @version 1.0
 */
class Util extends Controller {

    /**
     *  Version de la aplicacion
     * @var String
     */
    public static function version (){
         return '20150824';
    }
    
    /**
     * Convierte un conjunto de checkbox en array
     * @param Integer $checkedcount Cantidad de checkbox
     * @param String $prefixCheckbox Prefijo de los checkbox
     * @return Array conjunto de valores encontrados en checkbox seleccionados
     */
    public static function checkBoxToArray($checkedcount, $prefixCheckbox) {
        $arr = array();
        for ($i = 0; $i < $checkedcount; $i++) {
            if (Request::get($prefixCheckbox . $i)) {
                $arr[] = intval(Input::get($prefixCheckbox . $i));
            }
        }
        return $arr;
    }

    /**
     * Toma dos array y devuleve mix de opciones relaciones
     * @param Array $arrOptions conjunto de opciones
     * @param Array $arrRelated conjunto de relaciones
     * @return Array conjunto de opciones y relaciones
     */
    public static function getCheckArray($arrOptions, $arrRelated) {
        $arrCheck = array();
        foreach ($arrOptions as $ava) {
            $isCheck = false;
            foreach ($arrRelated as $ass) {
                if ($ass->id == $ava->id) {
                    $isCheck = true;
                }
            }
            $arrCheck[] = array('name' => $ava->name,
                'id' => $ava->id,
                'check' => $isCheck);
        }
        return $arrCheck;
    }

    /**
     * Redondeo de numeros
     * @param int $numero
     * @param int $decimales
     * @return float
     */
    public static function rounding($numero, $decimales) {
        $factor = pow(10, $decimales);
        return (round($numero * $factor) / $factor);
    }

    /**
     * Método para capturar la Ip del cliente
     * @return string Ip del cliente
     */
    public static function getRealIpAddress() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP']; //check ip from share internet
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; //to check ip is pass from proxy
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /** Checks is the provided email address is formally valid
     *  @param string $email email address to be checked
     *  @return true if the email is valid, false otherwise
     */
    public static function isEmail($email) {
        $regexp = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
        if (preg_match($regexp, $email)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Metodo que convierte la hora universal en hora local
     * @param String $utc Fecha y Hora en UTC
     * @return String Fecha y Hora local
     */
    public static function timeUtecToLocal($utc) {
        $dt = new DateTime($utc);
        $tz = new DateTimeZone('America/Bogota');
        $dt->setTimezone($tz);
        return $dt->format('Y-m-d H:i:s');
    }

    /**
     * Metodo para eliminar caracteres raros de una cadena de caracteres
     * @param string $text cadena de caracteres a eliminar caracteres raros
     * @return string
     * @see http://stackoverflow.com/questions/14114411/remove-all-special-characters-from-a-string
     */
    public static function cleanString($text) {
        $utf8 = array(
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        );
        $text = preg_replace(array_keys($utf8), array_values($utf8), $text);
        $text = str_replace(array_keys($utf8), array_values($utf8), $text);
        $text = str_replace(' ', '-', $text); // Replaces all spaces with hyphens.
        $text = preg_replace('/[^A-Za-z0-9\. -]/', '', $text); // Removes special chars.
        $text = preg_replace('/-+/', '-', $text); // Replaces multiple hyphens with single one.
        return $text;
    }

}
