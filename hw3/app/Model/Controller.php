<?php
namespace App\Model;

const APP_MODEL = 'App\\Model\\';

trait Controller
{
  public function modelController(): void
  {
    if (!isset($this->modelClassPath)) {
      $this->toMain();
      exit;
    }
    $modelPath = $this->modelClassPath[0];
    $modelClass =  $this->modelClassPath[1];
    $modelMethod = strtolower($this->modelClassPath[1]);
    $modelFullName = APP_MODEL . $modelPath . '\\' . $modelClass;
    if (
      class_exists($modelFullName) &&
      method_exists($modelFullName, $modelMethod)
    ) {
      $model = new $modelFullName;
      $model->$modelMethod();
    }
  }
}
