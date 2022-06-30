<?php
namespace Src;

class Routes
{
  use Getsiteroot;
  private static string $controllerName = '';
  private static string $actionName = '';
  private static Routes $selfInstance;
  private string $pathToRoot;
  private function __construct()
  {
    $this->pathToRoot = $this->gettroot();
    $fullURL = parse_url($_SERVER['REQUEST_URI']);
    $siteURI = strtolower(str_replace($this->pathToRoot, '', $fullURL['path']));
    $controllerAction = explode(DIRECTORY_SEPARATOR, $siteURI);
    if (count($controllerAction)) {
      self::$controllerName = $controllerAction[0];
      self::$actionName = $controllerAction[1] ?? '';
    }
  }
  private static function getSelf(): void
  {
    if (!isset(self::$selfInstance)) {
      self::$selfInstance = new self();
    }
  }
  public static function getController(): string
  {
    self::getSelf();
    return ucfirst(self::$controllerName);
  }
  public static function getAction(): string
  {
    self::getSelf();
    return self::$actionName;
  }
}
