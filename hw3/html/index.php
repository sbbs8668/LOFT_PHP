<?php
session_start();
$_SESSION['error'] = '';
require_once '../vendor/autoload.php';
use Src\Proceed;

/*set path to template ($this->fileTemplateUrl) and path to model class ($this->modelClassPath) */
/*if url is wrong, sets both for redirect to 404*/
Proceed::startSite();

/*here it takes the path to model from the previous step and proceed it in Model\Traits\ModelSite.php*/
/*eg: url is '/user/login' \app\Model\User\Login::login()' will run*/
/*if there was nothing in the uri '/' it goes to \app\Model\User\Login::login()'*/
/*from here: Proceed->__construct()->!self::$controllerName && !self::$actionName->self::setCurrentPage();*/
Proceed::modelSite();

/*here it proceeds after the model was completed and loads a template from ($this->fileTemplateUrl)*/
/*eg: url is '/user/login' \app\View\User\ login.phtml' will load*/
Proceed::renderSite();
