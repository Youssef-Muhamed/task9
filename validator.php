<?php
class Validator{

    function Clean($input){
        return   strip_tags(trim($input));
    }

    function validate($input,$flag,$length = 6){

        $status = true;
        switch ($flag) {
            case 1:
                # code...
                if(empty($input)){
                    $status = false;
                }
                break;

            case 2:
                # code ...
                if(!filter_var($input,FILTER_VALIDATE_EMAIL)){
                    $status = false;
                }
                break;


            case 3:
                # code ...
                if(strlen($input) < $length){
                    $status = false;
                }
                break;
            case 4:
                # code ...
                if(!filter_var($input,FILTER_VALIDATE_INT)){
                    $status = false;
                }
                break;

            case 5:
                #code ....
                $allowedExtension = ["jpg","png","jpeg"];
                if(!in_array($input,$allowedExtension)){
                    $status = false;
                }
                break;

            case 6 :
                # code .....
                if(!preg_match('/^01[0-2,5][0-9]{8}$/',$input)){
                    $status = false;
                }
                break;


            case 7 :
                # code .....
                if(!preg_match('/^[a-zA-Z\s]*$/',$input)){
                    $status = false;
                }
                break;

        }
        return $status ;
    }
}