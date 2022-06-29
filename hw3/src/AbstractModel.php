<?php
namespace Src;

abstract class AbstractModel
{
  protected function getSlt(): string
  {
    return file_get_contents(__DIR__. '/salt/slt.txt');
  }
  protected function makePswd(): string
  {
    return sha1($this->getSlt() . $_POST['pswd']);
  }
  protected function clearErrors()
  {
    $_SESSION['errors'] = '';
  }
  protected function reloadSite()
  {
    header("Refresh:0");
  }
  protected function getExistedUser(int $id = 0): array
  {
    $this->db = PdoDb::getInstance();
    $query = "
        SELECT `name`, `email`, `regdate`, `role` 
        FROM `users`
        WHERE 
            `email` = :email
    ";
    if ($id) {
      $query .= ' AND `id` = :id;';
    } else {
      $query .= ';';
    }
    $parameters = [
      ':email' => $this->email
    ];
    if ($id) {
      $parameters[':id'] = $id;
    }
    $result = $this->db->fetchOne($query, $parameters, __METHOD__);
    if (!$result) {
      $result = [];
    }
    return $result;
  }
}
