<?php
namespace App\Controller;

use App\Controller\AppController;

class AdminsController extends AppController
{
public function login()
    {
      return $this->redirect(['controller' => 'Admins', 'action' => 'login','prefix'=>'admin']);
    }
}