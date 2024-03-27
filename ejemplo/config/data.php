<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tipo"])) {
     include('../db/db.php'); 
    header('Content-Type: application/json');
    extract($_POST);
    $accion = match ($tipo) {
        'panel' => function () {
             echo json_encode('juvenal', JSON_UNESCAPED_UNICODE);
        }, 
        'coaguila'=>function (){
            echo json_encode('leandro', JSON_UNESCAPED_UNICODE);

        }, 
        'suma'=>function (){
            extract($_POST);
            $suma=$valor1+$valor2;
            echo json_encode($suma, JSON_UNESCAPED_UNICODE);
        }, 
        'resta'=>function (){
            extract($_POST);
            $resta=$valor1-$valor2;
            echo json_encode($resta, JSON_UNESCAPED_UNICODE);
        }, 
        'multiplicacion'=>function (){
            extract($_POST);
            $multiplicacion=$valor1*$valor2;
            echo json_encode($multiplicacion, JSON_UNESCAPED_UNICODE);
            
        }, 
        'division'=>function (){
            extract($_POST);
            $division=$valor1/$valor2;
            echo json_encode($division, JSON_UNESCAPED_UNICODE);
    },
    'usuario'=>function (){
        extract($_POST);
        require_once('../model/userModel.php'); 
        require_once('../controllers/userControllers.php');
        if(isset($_POST["accion"]))
        {
            if ($accion == 'ver'){
               /*  $horarioController->list */
            }

        }
        echo json_encode($suma, JSON_UNESCAPED_UNICODE);

    },
};
    $accion();
}
