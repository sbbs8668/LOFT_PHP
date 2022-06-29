<?php
namespace App\Model\Functions;

const APP_MODEL = 'App\\Model\\';

trait ModelSite
{
  public function modelsite(): void
  {
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
