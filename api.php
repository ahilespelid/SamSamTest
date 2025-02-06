<?php require_once 'config.php';
header('Content-Type: application/json');

///*/ahilespelid Получаем метод запроса ///*/
$method = $_SERVER['REQUEST_METHOD'];
///*/ahilespelid Вызываем функцию по методу запроса ///*/
switch($method){
    case 'GET'   : getContacts();   break;
    case 'POST'  : addContact();    break;
    case 'PUT'   : updateContact(); break;
    case 'DELETE': deleteContact(); break;
    default      : http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']); exit;
}
///*/ahilespelid Метод получения контактов из бд///*/
function getContacts(){ global $conn;
    try{
        echo json_encode($result = (empty($res = ($conn->query('SELECT * FROM contacts'))->fetchAll(PDO::FETCH_ASSOC))) ? [] : $res);
    }catch (PDOException $e){
        http_response_code(500); 
        echo json_encode(['message' => 'Internal server error']);
}}
///*/ahilespelid Метод добавления контактов в бд///*/
function addContact(){ global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['name'], $data['phone'], $data['email'])){
        $name  = htmlspecialchars(strip_tags(trim($data['name'])));
        $phone = htmlspecialchars(strip_tags(trim($data['phone'])));
        $email = htmlspecialchars(strip_tags(trim($data['email'])));
        
        try{
            $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email) VALUES (:name, :phone, :email)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            
            if($stmt->execute()){
                http_response_code(201);
                echo json_encode(['message' => 'Контакт добавлен']);
            }else{
                http_response_code(400);
                echo json_encode(['message' => 'Ошибка при добавлении контакта']);
            }
        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(['message' => 'Internal server error']);
        }
    }else{
        http_response_code(422);
        echo json_encode(['message' => 'Не все поля заполнены']);
}}
///*/ahilespelid Метод обновления контактов в бд///*/
function updateContact(){ global $conn;   
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['id'], $data['name'], $data['phone'], $data['email'])){
        $id    = intval(htmlspecialchars(strip_tags(trim($data['id']))));
        $name  = htmlspecialchars(strip_tags(trim($data['name'])));
        $phone = htmlspecialchars(strip_tags(trim($data['phone'])));
        $email = htmlspecialchars(strip_tags(trim($data['email'])));
        
        try{
            $stmt = $conn->prepare("UPDATE contacts SET name=:name, phone=:phone, email=:email WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            
            if($stmt->execute()){
                http_response_code(200);
                echo json_encode(['message' => 'Контакт обновлён']);
            }else{
                http_response_code(404);
                echo json_encode(['message' => 'Контакт не найден']);
            }
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(['message' => 'Internal server error']);
        }
    }else{
        http_response_code(422); // Необработанные сущности
        echo json_encode(['message' => 'Не все поля заполнены']);
}}
///*/ahilespelid Метод удаления контактов в бд///*/
function deleteContact(){ global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['id'])){
        $id = intval(htmlspecialchars(strip_tags(trim($data['id']))));
        
        try{
            $stmt = $conn->prepare("DELETE FROM contacts WHERE id=:id");
            $stmt->bindParam(':id', $id);
            
            if($stmt->execute()){ 
                http_response_code(200);  
                echo json_encode(['message' => 'Контакт удалён']);
            }else{
                http_response_code(404);
                echo json_encode(['message' => 'Контакт не найден']);
            }
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(['message' => 'Internal server error']);
        }
    }else{
        http_response_code(422);
        echo json_encode(['message' => 'Не указан ID контакта']);
}}
?>