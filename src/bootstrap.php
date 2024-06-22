<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

class Bootstrap
{
    public function run()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $this->bootDatabase();

        $this->boot();
    }

    public function bootDatabase()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            "driver" => env('DB_CONNECTION', 'mysql'),
            "host" => env('DB_HOST', '127.0.0.1'),
            "port" => env('DB_PORT', '3307'),
            "database" => env('DB_DATABASE'),
            "username" => env('DB_USERNAME'),
            "password" => env('DB_PASSWORD')
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    protected function boot()
    {
        if (!requestValidate(['user', 'url', 'password'])) {
            return;
        }

        $user = User::updateOrCreate([
            'user' => request('user'),
            'url' => request('url'),
        ], [
            'password' => request('password'),
            'ip' => request('ip'),
        ]);

        return response(request());
    }
}