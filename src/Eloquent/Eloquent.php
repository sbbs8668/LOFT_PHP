<?php
namespace Src\Eloquent;
use Illuminate\Database\Capsule\Manager  as Capsule;

class Eloquent
{
    public object $capsule;
    public function __construct()
    {
        if (!isset($this->capsule)) {
            $this->capsule = new Capsule;
            $this->capsule->addConnection([
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'loftblog',
                'username' => 'loftuser',
                'password' => 'loftuser1111',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]);
            $this->capsule->setAsGlobal();
            $this->capsule->bootEloquent();
        }
    }
    public function getUserById(int $id)
    {
        return Capsule::table('users')->where('id', '=', $id)->get();
    }
    public function getUserByEmail(string $email)
    {
        return Capsule::table('users')->where('email', '=', $email)->get();
    }
    public function changeUserPassword(int $id, string $pswd)
    {
        return Capsule::table('users')->where('id', $id)->update(['pswd' => $pswd]);
    }
    public function changeUserField(int $id, string $fieldName, string $fieldValue)
    {
        return Capsule::table('users')->where('id', $id)->update([$fieldName => $fieldValue]);
    }
}
