<?php

/**
 * Casse que cuida das Validações 
 *
 * @author tutocury
 */
class Validator {

    static function isEmpty($value) {
        return !(strlen($value) > 0);
    }

    static function hasMoreThanMaxLength($value, $maxLength = 0) {
        return (strlen($value) > $maxLength);
    }

    static function isEmail($value) {
        if (preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})"
                        . "(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $value)) {
            return true;
        } else {
            return false;
        }
    }

    static function isTelefone($value) {
        if (preg_match('^\(+[0-9]{2}\) [0-9]{4}-[0-9]{4}$^', $value)) {
            return true;
        } else {
            return false;
        }
    }

    static function isCelular($value) {
        if (preg_match('^\(+[0-9]{2}\) [0-9] [0-9]{4}-[0-9]{3,4}$^', $value)) {
            return true;
        } else {
            return false;
        }
    }

    static function isNumeric($value) {
        return is_numeric($value);
    }

}
