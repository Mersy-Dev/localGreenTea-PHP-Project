<?php
    $db_name = 'mysql:host=localhost;dbname=greentea_db';
    $db_user = 'root';
    $db_pass = '';

    $conn = new PDO($db_name, $db_user, $db_pass);



    function unique_id(){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $chars_length = strlen($chars);
        $randomString = '';
        for($i = 0; $i < 20; $i++){
            $randomString .= $chars[rand(0, $chars_length - 1)];
        }
        return $randomString;
    }

?>