<?php
namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Mailer\Email;

class AppController extends Controller
{
    //...

    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Admins',
                'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'Admins',
                'action' => 'login',
                ]
        ]);
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'view', 'display','add','edit']);
        $this->set('PATH', Configure::read('App.siteurl'));
	
	
	
	
        $action = array('login', 'reset', 'forgotpassword', 'showprofile');
        if (in_array($this->request->params['action'], $action) && $this->request->params['prefix'] == 'admin')
        {
            
        }else{
            if ($this->request->session()->read('SNSAdmin.role') != 'Admin' && $this->request->session()->read('SNSAdmin') =='') {				
                $redirect = $this->request->session()->read('REDIRECT');
                if(isset($redirect)){
                    $this->request->session()->delete('REDIRECT');
                    $cont = $redirect['controller'];
                    $act = $redirect['action'];
                    $pass = $redirect['pass']; 
                    return $this->redirect(['controller'=>$cont, 'action'=>$act, $pass]);
                }
                $data['controller']     = $this->request->params['controller'];
                $data['action']         = $this->request->params['action'];
                $data['prefix']         = $this->request->params['prefix'];
                $data['pass']           = '';
                if(isset($this->request->params['pass']['0']) && $this->request->params['pass']['0'] !='')
                $data['pass'] = $this->request->params['pass']['0'];
                if(!empty($data['pass'])){
                    if(isset($this->request->params['pass']['1']) && $this->request->params['pass']['1'] !='')
                    $data['pass'] = $this->request->params['pass']['0']."/".$this->request->params['pass']['1'];
                }
                $this->request->session()->write('REDIRECT', $data);
                $this->redirect(['controller' => 'Admins', 'action' => 'login']);
            }
        }
    }
    
    
   
    
     /********************************************************************************
	Function Name: random_password
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Girish Kumar Sinha
	*Modified By: Girish Kumar Sinha
	*Output: Function for generate n length random password.
	*********************************************************************************/
    public function random_password($length = '10'){
		//$this->autoRender = false;	
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;		
	}
}