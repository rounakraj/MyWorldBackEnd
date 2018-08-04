<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use MetzWeb\Instagram\Instagram;
use Cake\ORM\Entity;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'home'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'home',
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email']
                ]
            ]
        ]);
		
		$this->loadModel('GlobalParameters');
			$globe=$this->GlobalParameters->find('list', [
										'keyField' => 'key', 
										'valueField' => ['value']
										])->toArray();
										
			$globalparameters = new Entity($globe);
			$this->set(compact('globalparameters'));
			
			//Social Logins
			define('FACEBOOK_APP_ID', '1433271346786198');
			define('FACEBOOK_APP_SECRET', '29fdf8a2f9598fb3232537c15535ce6e');
			define('FACEBOOK_REDIRECT_URI', Configure::read('App.siteurl').'fbslogin');


			//Google App Details
			define('GOOGLE_APP_NAME', 'KS Education'); 
			define('GOOGLE_OAUTH_CLIENT_ID', '460591983506-di2r678cupotgd0bnpcm8tnnk4mcrsa7.apps.googleusercontent.com');
			define('GOOGLE_OAUTH_CLIENT_SECRET', 'V6Smk_NGn5oE6_fXi499qVBl');
			define('GOOGLE_OAUTH_REDIRECT_URI', Configure::read('App.siteurl').'googlelogin');
			define("GOOGLE_SITE_NAME",Configure::read('App.siteurl'));	
			
			//Payment Details Development
			define('MERCHANT_KEY', 'gtKFFx');
			define('SALT', 'eCwWELxi');
			define('PAYU_BASE_URL', 'https://test.payu.in');
			// End point - change to https://secure.payu.in for LIVE mode
			
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        $this->set('BASEPATH', Configure::read('App.siteurl'));
		    
        if($this->Auth->user('OyeWebsUser.id') == ''){
			
            $this->loadComponent('Cookie');
            $userCookies = $this->Cookie->read('UserCookies');
            
            
            if(!empty($userCookies)){
                
                $user = $this->Users->find()
                                ->where([                                    
                                    'Users.email' => $userCookies['session']['OyeWebsUser']['email'],
                                    'Users.role' => 'U',
                                    'Users.status' => 1
                                ])->first();
                $user1['OyeWebsUser'] = $user;
                $this->Auth->setUser($user1);
                
                
            }
			
			
		
		
			   $this->set('siteurl',Configure::read('App.siteurl'));
        }
        if($this->Auth->user('OyeWebsUser.id')){
			$this->loadModel('Users');
			$users_login = $this->Users->find()->where(['Users.id' => $this->Auth->user('OyeWebsUser.id')])->first();
			$this->set('users_login', $users_login);
			}
        
        
    }
    
    function currenlogin(){
		if($this->Auth->user('OyeWebsUser.id')){
		$this->loadModel('Users');
		$users_login = $this->Users->find()->where(['Users.id' => $this->Auth->user('OyeWebsUser.id')])->first();
		$this->set('users_login', $users_login);
		return $users_login;
		}else{
			return $this->redirect(['controller'=>'Users', 'action' => 'login']);
		}
		
	}
    
	
	function registermail($userId=NULL){
				$this->loadModel('Users');
				$data = $this->Users->find()->where(['Users.id' => $userId])->first();
				
				/****************************** Mail Send Admin***************************************************/
				$subject =ucfirst(Configure::read('App.siteName')).' - New Registration';
				$Email_variables = [
					   'fullname' => 'Admin',
					   'email' => ($data->email) ? $data->email : 'Login With Social',
					   'username' => $data->fullName .' '.$data->lastname ,
					  'title_for_layout' => $subject
					 ];
			
				$mail_template='admin_registation';
				$email = new Email('Smtp');
				$email->template($mail_template, 'email_layout')
				    ->emailFormat('html')
				    ->viewVars($Email_variables)  
				    ->subject($subject)
				    ->to(Configure::read('App.adminEmail'))
				    ->from([Configure::read('App.adminEmail')=>Configure::read('App.siteName')])
				    ->send();
				/**********************************Mail Send Admin  ***********************************************/
				
				$subject ='Welcome to '.ucfirst(Configure::read('App.siteName'));
				$Email_variables = [
					   'fullname' => $data->fullName,
					   'email' => $data->email,
					   'password' => $data->password2,
					   'title_for_layout' => $subject,
					 ];
			    if($data->email){
				$mail_template='registration';
				$email = new Email('Smtp');
				$email->template($mail_template, 'email_layout')
				    ->emailFormat('html')
				    ->viewVars($Email_variables)  
				    ->subject($subject)
				    ->to($data->email)
				    ->from([Configure::read('App.adminEmail')=>Configure::read('App.siteName')])
				    ->send();	
				}					
	}
    
    
    
}
