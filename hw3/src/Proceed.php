<?php

namespace Src;
use Src\Traits;

/*class prefix for all callable classes from the "app" folder / "App" namespace*/
const CONTROLLER_CLASS = 'App\\Controller';

const _404_ACTION = '_404';

const LOGIN_CONTROLLER = 'User';
const LOGIN_ACTION = 'login';

const MODEL_ACTION = 'modelController';
const RENDER_ACTION = 'renderSite';

class Proceed {

  use Traits\Routes;

  private static string $_404actionName;
  private static string $controllerClass;

  private static object $controller;
  private static Proceed $siteStarted;

  private function __construct()
  {
    self::$_404actionName = _404_ACTION;

    $this->getRoutes();

    if (!self::$controllerName && !self::$actionName) {
        self::setCurrentPage();
    }
  }
  private static function setCurrentPage(): void
  {
    self::$controllerName = LOGIN_CONTROLLER;
    self::$actionName = LOGIN_ACTION;
  }
  private static function set404(): void
  {
    self::$actionName = self::$_404actionName;
    self::$controllerClass = CONTROLLER_CLASS . '\\' . _404_ACTION;
  }
  private static function go(): void
  {
    if (
      class_exists(self::$controllerClass) &&
      method_exists(self::$controllerClass, self::$actionName)
    ) {
      if (!isset(self::$controller)) {
        self::$controller = new self::$controllerClass;
      }
      self::$controller->{self::$actionName}();
    } else {
      self::set404();
      self::go();
    }
  }
  public static function startSite(): void
  {
    if(!isset(self::$siteStarted)) {
      self::$siteStarted = new self();
      self::$controllerClass = CONTROLLER_CLASS . '\\' . self::$controllerName;
    }
    self::go();
  }
  public static function modelSite(): void
  {
    self::$actionName = MODEL_ACTION;
    self::go();
  }
  public static function renderSite(): void
  {
    self::$actionName = RENDER_ACTION;
    self::go();
  }
}
