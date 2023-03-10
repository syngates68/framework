<?php

class Controller
{
    public static function redirect($url)
    {
        header('Location:'.$url);
        exit();
    }

    public static function validateInputs($inputs)
    {
        $bool = true;
        $i = 0;
        while ($i < sizeof($inputs))
        {
            if (!isset($_POST[$inputs[$i]]) || $_POST[$inputs[$i]] == null || str_replace(' ', '', $_POST[$inputs[$i]]) == null)
            {
                $bool = false;
                break;
            }

            $i++;
        }

        return $bool;
    }
}