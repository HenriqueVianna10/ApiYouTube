<?php
header("Acess-Control-allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Acess-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Acess-Control-Max-Age: 3600");
header("Acess-Control-Allow-Headers: Content-Type, Acess-Control-Allow-Headers, Authorizathion, X-Requested-With");

require_once("../../vendor/autoload.php");
use App\Controller\GameController;

$controller = null;
$id = null;
$data  = null;
$method = $_SERVER["REQUEST_METHOD"];
$uri = $_SERVER["REQUEST_URI"];
$unsetcount = 2;

//Tratar a URI

$ex = explode("/", $uri);


for ($i = 0; $i <$unsetCount; $i++){
    unset($ex[$i]);
}

$ex = array_filters(array_values($ex));

if(isset($ex[0])){
    $controller = $ex[0];
}
    
if(isset($ex[1])){
    $id = $ex[1];
}

parse_str(file_get_contents('php://input'), $data);

echo json_encode(["controller" => $controller, "id" => $id]);

//Fim do Tratamento da URI

$gameController = new GameController();
switch($method) {
        case 'GET':
            if($controller != null && $id == null){
                echo $gameController->readALL();
            }elseif($controller != null && $id != null){
            echo $gameController->readById($id);
            }else{
            echo json_encode(["result" => "invalid"]);               
            }

        break;

        case 'POST':
            if($controller != null && $id == null){
              echo $gameController->create($data);
            }else{
              echo json_encode(["result" => "invalid"]);
            }
        break;

        case  'PUT':
            if($controller != null && $id != null){
             echo $gameController->update($id, $data);
            }else{
                echo json_encode(["result" => "invalid"]);
            }
        break;

        case 'DELETE':
            if($controller != null && $id != null){
                echo $gameController->update($id);
               }else{
                   echo json_encode(["result" => "invalid"]);
               }
        break;

        default:
        echo json_encode(["result" => "invalid request" ]);
        break;


}

?>