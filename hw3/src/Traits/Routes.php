<?php
namespace Src\Traits;

trait Routes
{
  use Getsiteroot;

  private static string $actionName;
  private static string $controllerName;

  private function getRoutes(): void
  {
    $pathToRoot = $this->getRoot();
    $fullURL = parse_url($_SERVER['REQUEST_URI']);
    $siteURI = strtolower(str_replace($pathToRoot, '', $fullURL['path']));
    $controller0_Action1 = explode(DIRECTORY_SEPARATOR, $siteURI);
    if (count($controller0_Action1)) {

      /*class name - first letter upperCase*/
      self::$controllerName = ucfirst($controller0_Action1[0]);

      /*method name within the 'Controller' class name*/
      /*as it comes from the url, kebabCase cannot be set for the method name*/
      /*all methods, that are called from this controller structure*/
      /*have to be named all the way in lowercase*/
      /*eg: cannot be userLogin, only userlogin, as it is not possible to get*/
      /*kebabCase from the url, eg noone will put userLogin in the address bar*/
      /*only userlogin, and it is not possible to decide what has to happen*/
      /*usErLogIn or userLogIn etc*/
      self::$actionName = $controller0_Action1[1] ?? '';
    }
  }
}
