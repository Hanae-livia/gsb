<?php

namespace GSB\GSB;

/**
 * Class Flash
 *
 * Permet d'enregistrer une variable en session qui disparait quand on récupère le flash (get)
 */
class Flash
{

    /**
     * Permet d'enregistrer un message
     *
     * @param $name
     * @param $message
     */
    public static function set ($name, $message)
    {
        $_SESSION[$name] = $message;
    }

    /**
     * Permet de récupérer un message flash et le supprime
     *
     * @param $name
     *
     * @return string
     */
    public static function get ($name)
    {
        $flash = '';
        if (isset($_SESSION[$name])) {
            $flash = $_SESSION[$name];
            unset ($_SESSION[$name]);
        }

        return $flash;
    }

    /**
     * Vérifie si le flash existe
     * @param $name
     *
     * @return bool
     */
    public static function has ($name)
    {
        return isset($_SESSION[$name]);
    }
} 