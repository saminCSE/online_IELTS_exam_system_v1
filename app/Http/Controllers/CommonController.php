<?php

namespace App\Http\Controllers;



class CommonController extends Controller
{
    public static function AnswerType()
    {
        return $type = [
            '' => 'Select Type',
            '1' => 'Radio',
            '2' => 'Checkbox',
            // '3' => 'Text',
            '4' => 'Editor-(Image)-Radio',
            // '5' => 'Dropdown',
        ];
    }

    public static function ActiveStatus()
    {
        return $is_active = [
            '' => 'Select',
            '0' => 'Deactive',
            '1' => 'Active',
        ];

    }

}
