<?php
require('PdoDb.php');

const ORDER_SUCCESS = 'Спасибо, ваш заказ будет доставлен по адресу: ';
const YOUR_ORDER_ID_TEXT = 'Номер вашего заказа: ';
const YOUR_ORDER_COUNT_TEXT = ['Это ваш ', '-й заказ!'];
const ORDER_ERROR = ['Cannot proceed your order.', 'Fill in all fields, please.'];
const DB_ERROR = ['Cannot proceed your order.', 'Please try again later.'];

class Orders
{
    private $db;

    public function __construct()
    {
        $this->db = PdoDb\PdoDb::getInstance();
    }

    public function getUserId(string $email): int
    {
        $query = "SELECT `id` FROM `users` where `email` = :email";
        $parameters = [':email' => $email];
        $result = $this->db->fetchOne($query, $parameters);
        return $result['id'] ?? 0;
    }
    public function insertNewOrder(int $userId, array $orderData): int
    {
        $check = 0;
        $i = 0;
        while(!$check && $i < 3) {
            $query = "INSERT INTO `orders` (`userId`, `order`) VALUES (:id, :order);";
            $parameters = [
                ':id' => $userId,
                ':order' => json_encode($orderData),
            ];
            $check = $this->db->exec($query, $parameters);
            $i++;
        }
        if($check) {
            return $this->db->getLastId();
        }
        return 0;
    }
    public function countUserOrders(int $userId): int
    {
        $query = "SELECT `id` FROM `orders` where `userId` = :userId";
        $parameters = [':userId' => $userId];
        $result = $this->db->fetchAll($query, $parameters);
        return count($result);
    }
    public function createNewUser(string $newUserEmail): int
    {
        $check = 0;
        $i = 0;
        while(!$check && $i < 3) {
            $query = "INSERT INTO `users` (`email`) VALUES (:email);";
            $parameters = [
                ':email' => $newUserEmail,
            ];
            $check = $this->db->exec($query, $parameters);
            $i++;
        }
        if ($check) {
            /*check if user inserted*/
            $newUserId = $this->getUserId($newUserEmail);
            if ($newUserId) {
                return $newUserId;
            }
        }
        return 0;
    }
    public function returnError(string $text): void
    {
        echo $text;
        exit;
    }
}

$orders = new Orders;

/*get order data*/
$orderData = $_POST;
if (!$orderData) {
    exit;
}

/*check the data*/
foreach ($orderData as $field) {
    if (!$field) {
        $orders->returnError(json_encode(ORDER_ERROR));
        exit;
    }
}

$userEmail = $orderData['email'];
unset($orderData['email']);

$newOrderId = 0;
$userId = $orders->getUserId($userEmail);

if (!$userId) {
    /*create new user*/
    $userId = $orders->createNewUser($userEmail);
}

if ($userId) {
    /*insert new order*/
    $newOrderId = $orders->insertNewOrder($userId, $orderData);
}

if (!$userId || !$newOrderId) {
    $orders->returnError(json_encode(DB_ERROR));
}

/*order ordered*/
/*count users orders*/
$userOrdersNumber = $orders->countUserOrders($userId);

/*respond to frontend*/
unset($orderData['id']);
unset($orderData['name']);
unset($orderData['phone']);
unset($orderData['comment']);
$address = implode(' ', $orderData);
$userOrdersCountText = YOUR_ORDER_COUNT_TEXT[0] . $userOrdersNumber . YOUR_ORDER_COUNT_TEXT[1];

echo json_encode([ORDER_SUCCESS . $address, YOUR_ORDER_ID_TEXT . $newOrderId, $userOrdersCountText]);
exit;
