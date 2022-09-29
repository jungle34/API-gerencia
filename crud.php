<?php
include('dbcon.php');
$bearer = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
$ac = $bearer[1];
$access_verify = "SELECT * FROM controllers WHERE token LIKE '$ac'";
$result_access = mysqli_query($conn, $access_verify);
$num = mysqli_num_rows($result_access);
if($num == 1){
    $json = file_get_contents('php://input');
    if($request_body = json_decode($json, true)){
        $method = $request_body['funcao'];
        $nome = $request_body['nome'];
        $cpf = $request_body['cpf'];
        $rg  = $request_body['rg'];
        $tel = $request_body['telefone'];
        
        // Atualiza Pessoa
        if($method == "atualizar"){
            $select = "SELECT * FROM pessoas WHERE cpf LIKE '$cpf'";
            $result = mysqli_query($conn, $select);
            $data = mysqli_fetch_assoc($result);
            $num = mysqli_num_rows($result);
            if($num == 1){
                if(empty($nome)){
                    $nome = $data['nome'];
                }
                if(empty($rg)){
                    $rg = $data['rg'];
                }
                if(empty($tel)){
                    $tel = $data['telefone'];
                }
                $update = "UPDATE pessoas SET nome = '$nome', cpf = '$cpf', rg = '$rg', telefone = '$tel' WHERE cpf = '$cpf'";
                if(mysqli_query($conn, $update)){
                    echo "Os dados de ".$nome." foram alterados com sucesso!";
                }
            }else{
                echo "Insira o cpf de alguém já cadastrado";
            }
        }
        // Cria Pessoa
        if($method == "criar"){
            $verify = "SELECT * FROM pessoas WHERE cpf LIKE '$cpf'";
            $veri_res= mysqli_query($conn, $verify);
            $num = mysqli_num_rows($veri_res);
            if($num == 0){
                $insert = "INSERT INTO pessoas (nome, cpf, rg, telefone) VALUES ('$nome', '$cpf', '$rg', '$tel')";
                if(mysqli_query($conn, $insert)){
                    echo "Cadastro de ".$nome." foi realizado com sucesso!";
                }
            }else{
                echo "CPF Já cadastrado!";
            }
        }
        // Deleta Pessoa
        if($method == "deletar"){
            $verify = "SELECT * FROM pessoas WHERE cpf LIKE '$cpf'";
            $veri_res= mysqli_query($conn, $verify);
            $num = mysqli_num_rows($veri_res);
            if($num == 1){
                $delete = "DELETE FROM pessoas WHERE cpf LIKE '$cpf'";
                if(mysqli_query($conn, $delete)){
                    echo $cpf." excluido com sucesso!";
                }
            }else{
                echo "Insira o cpf de alguém já cadastrado";
            }
        }
        // Lista pessoas
        if($method == "ler"){
            $ler = "SELECT * FROM pessoas";
            $result = mysqli_query($conn, $ler);
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            print_r($data);
        }
    }
    
}