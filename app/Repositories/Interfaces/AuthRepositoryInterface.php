<?php
namespace App\Repositories\Interfaces;
interface AuthRepositoryInterface{
public function register(array $data);
public function login(array $data);
public function me();
public function logout();
public function verify(array $data);
}
