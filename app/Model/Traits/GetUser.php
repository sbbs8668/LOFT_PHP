<?php
namespace App\Model\Traits;

trait GetUser {

  protected function getExistedUser(string $email = '', int $id = 0, int $confirm = 1): array
  {
    $result = [];
    $parameters = [];

    if (! $email && !$id) {
      return $result;
    }

    $query = "
        SELECT `name`, `email`, `regdate`, `role`, `confirm`
        FROM `users`
    ";
    $query .= ' WHERE';
    if ($email) {
      $query .= ' `email` = :email';
      $parameters = [
        ':email' => $email
      ];
    }
    if ($email && $id) {
      $query .= ' AND `id` = :id';
      $parameters[':id'] = $id;
    } elseif ($id) {
      $query .= ' `id` = :id';
      $parameters[':id'] = $id;
    }
    $query .= ' AND `confirm` = :confirm;';
    $parameters[':confirm'] = $confirm;

    $result = $this->db->fetchOne($query, $parameters, __METHOD__);
    if (!$result) {
      $result = [];
    }
    return $result;
  }
}
