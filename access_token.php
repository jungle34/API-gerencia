<?php
include('../dbcon.php');

if($json = file_get_contents('php://input')){
    $data = json_decode($json, true);
    $user = $data['user'];
    $pass = $data['pass'];
}else{
    echo "Para exucutar está requisição, inclua um request body";
}

if(isset($user) || isset($pass)){
    $accessDB = "SELECT * FROM controllers WHERE user LIKE '$user' AND pass LIKE '$pass'";
    $resDb = mysqli_query($conn, $accessDB);
    $i = mysqli_num_rows($resDb);
    if($i == 1){
        $access_data = mysqli_fetch_assoc($resDb);
        $access_token = $access_data['token'];
        if(empty($access_token)){
            $dia = date('d/m/Y');
            $dont = crypt($user, $dia);
            $dontCry = md5($dont);
            $access = "APP-CTRL#".$dontCry;
            $up_token = "UPDATE controllers SET token = '$access' WHERE user = '$user'";
            if(mysqli_query($conn, $up_token)){
                echo "Este é seu Bearer Token:  \n".$access;
            }else{
                echo "Parece que houve um problema com a sua requisição!";
            }
        }else{
            $dia = date('d/m/Y');
            $dont = crypt($user, $dia);
            $dontCry = md5($dont);
            $access = "APP-CTRL#".$dontCry;
            $up_token = "UPDATE controllers SET token = '$access' WHERE user LIKE '$user'";
            if(mysqli_query($conn, $up_token)){
                echo "Este é Bearer Token:  \n".$access;
            }else{
                echo "Parece que houve um problema com a sua requisição!";
            }
        }
        
    }else{
        echo "usuario ou senha invalidos";
    }

}



