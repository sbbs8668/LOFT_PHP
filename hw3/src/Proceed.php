<?php
namespace Src;

const CONTROLLER_CLASS = 'App\\Controller';
const _404_CLASS = '_404';
const RENDER_NAME = 'renderSite';
const MODEL_NAME = 'modelSite';

const LOGIN_CONTROLLER = 'User';
const LOGIN_ACTION = 'login';

class Proceed {

  private static string $actionName;
  private static string $_404actionName;
  private static string $controllerName;
  private static string $controllerClass;

  private static object $controller;
  private static Proceed $siteStarted;

  private function __construct()
  {
    self::$_404actionName = _404_CLASS;
    self::$controllerName = Routes::getController();
    self::$actionName = Routes::getAction();
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
    self::$controllerClass = CONTROLLER_CLASS . '\\' . _404_CLASS;
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
  public static function renderSite(): void
  {
    self::$actionName = RENDER_NAME;
    self::go();
  }
  public static function modelSite(): void
  {
    self::$actionName = MODEL_NAME;
    self::go();
  }
}
