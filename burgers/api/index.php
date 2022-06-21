<?php

/*get order data*/
$orderData = $_POST;
/*check the data*/
const ORDER_SUCCESS = 'Спасибо, ваш заказ будет доставлен по адресу: ';
const YOUR_ORDER_ID_TEXT = 'Номер вашего заказа: ';
const ORDER_COUNT_MARKER = '@@';
const YOUR_ORDER_COUNT_TEXT = 'Это ваш '.ORDER_COUNT_MARKER.'-й заказ!';
const ORDER_ERROR = ['Cannot proceed your order.', 'Fill in all fields, please.'];

foreach ($orderData as $field) {
    if (!$field) {
        echo json_encode(ORDER_ERROR);
        exit;
    }
}

const DB_NAME = 'db.json';
const DB_DEF_CONTENT = ['users' => [], 'orders' => []];

/*update db*/
function updateDb($data): void
{
    $db = fopen(DB_NAME, 'w');
    fwrite($db, json_encode($data));
    fclose($db);
}

/*proceed the order*/
function proceedOrder(array $orderData): void
{
    /*connect to db*/
    if (!file_exists(DB_NAME)) {
        updateDb(DB_DEF_CONTENT);
    }
    $db = json_decode(file_get_contents(DB_NAME), true);

    /*check if this user exists*/
    $userEmail = $orderData['email'];
    $checkUser = array_search($userEmail, $db['users']);

    if (!$checkUser) {
        /*create user*/
        $userID = count($db['users']) ? count($db['users']) + 1 : 1;
        $db['users'][$userID] = $userEmail;
    } else {
        $userID = $checkUser;
    }

    /*insert the order*/
    unset($orderData['email']);
    $orderId = rand(strlen($orderData['name']) ** 5, strlen($orderData['comment']) ** 6);
    $orderData['id'] = $orderId;
    $db['orders'][$userID][] = $orderData;

    /*update db*/
    updateDb($db);

    /*response to frontend*/
    $userOrdersCountText = str_replace(ORDER_COUNT_MARKER, count($db['orders'][$userID]), YOUR_ORDER_COUNT_TEXT);
    unset($orderData['id']);
    unset($orderData['name']);
    unset($orderData['phone']);
    unset($orderData['comment']);
    $address = implode(' ', $orderData);
    echo json_encode([ORDER_SUCCESS . $address, YOUR_ORDER_ID_TEXT . $orderId, $userOrdersCountText]);
}

proceedOrder($orderData);
exit;
