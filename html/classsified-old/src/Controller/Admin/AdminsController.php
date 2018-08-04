<?php
namespace App\Controller\Admin;
use App\Controller\Admin\Component\ImgComponent;
use Cake\Event\Event;
use Cake\Core\Configure;
use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\View\Helper\HtmlHelper;
use Cake\View\Helper\FormHelper;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;

/******************************************************************************
*File Name:	 AdminsController
*Creation Date: [09-02-2016]
*Modification Date: [09-02-2016]
*Author: [Gautam Suri]
*Author: [Modified By Gautam Suri]
*Description: [This controller consist of function related to Admin.]
******************************************************************************/
class AdminsController extends AppController {

	//var $name = 'Admins';
	//public $components = array('Paginator','Email','Session','Auth','General');

	/********************************************************************************
	Function Name: beforeFilter
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: This function called before each function of the controller.
	*********************************************************************************/
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login','logout', 'dashboard', 'changepassword', 'edit', 'forgotpassword', 'reset']);
    }

	
	/********************************************************************************
	Function Name: login
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function for login action.
	*********************************************************************************/
	public function login() {
        $this->loadModel('Users');
		$this->viewBuilder()->layout('Admin/adminlogin');
        $this->set('layoutTitle', Configure::read('App.siteName').'Admin Pannel');
        if($this->Auth->user('SNSAdmin.role') == 'Admin'){
            return $this->redirect($this->Auth->redirectUrl(['controller'=>'Admins', 'action'=>'dashboard']));
        }else{
            if($this->request->data){            
                           
                $user = $this->Auth->identify();
                $user1['SNSAdmin'] = $user;
                //pr($user); die;
                if ($user['role'] == 'Admin') {
					$articles = TableRegistry::get('Users');
					$query = $articles->query();
					$query->update()
						->set(['lastLogin' => date('Y-m-d H:i:s')])
						->where(['id' => 1])
						->execute(); 
                    $this->Auth->setUser($user1);
                    $this->redirect(['controller'=>'Admins', 'action'=>'dashboard']);
                }else{
                    $this->Flash->error(__('Invalid username or password, try again'));    
                }
            } 
        }        
	}
    
    
   
    public function logout()
    {
        $this->request->session()->delete('SNSAdmin');
        return $this->redirect($this->Auth->logout());
    }
    
    
	/********************************************************************************
	Function Name: Dashboard
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to load admin dashboard.
	*********************************************************************************/
	public function dashboard() {
	$this->viewBuilder()->layout('Admin/admin');
        $layoutTitle = 'Dashboard';
        $this->set(compact('layoutTitle'));
        if($this->Auth->user('SNSAdmin.role') != 'Admin' && $this->Auth->user('SNSAdmin.role') ==''){
            return $this->redirect($this->Auth->logout());
        }
        $this->loadModel('Users');
        $detail['SNSAdmin'] = $this->Users->get(1);
        $this->request->session()->write($detail);
        
             $this->loadModel('Users');	
			 $recentUsers = $this->Users->find('all')->where(['NOT'=>['role' => 'Admin']])->order(['id' => 'desc'])->limit('5')->toArray();	
			 
			 $recentUsersCount = $this->Users->find('all')->where(['NOT'=>['role' => 'Admin']])->count();	    
			 
			 $this->loadModel('News');	$recentNews = $this->News->find('all')->order(['id' => 'desc'])->limit('5')->toArray();	$recentNewsCount = $this->News->find('all')->count();	
			 $this->loadModel('Pages');	
			 $recentPages = $this->Pages->find('all')->order(['id' => 'desc'])->limit('5')->toArray();	
			 $recentPagesCount = $this->Pages->find('all')->count();		
			 
			 
			 $this->set(compact('recentUsers','recentUsersCount','recentNews','recentNewsCount','recentPages','recentPagesCount')); 
	  $this->set('layoutTitle', 'Dashboard');
	
	/* breadcrumbs start */
	 $breadcrumbs = array();
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	
	
	 $this->set('icon','<i class="fa fa-dashboard"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
	 
	 
	}


    public function edit($id = null)
     {
        //pr($this->Auth->user());
        $id = 1;
        $this->loadModel('Users');
        $layoutTitle = 'Edit Admin Info';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        $users = $this->Users->find()->where(['id' => $id])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userimage = $this->request->data['profilePicture'];
			unset($this->request->data['profilePicture']);
            if(!empty($userimage['name'])){
				$filename = time() . $userimage['name'];
				$this->request->data['profilePicture'] = $filename;
			}	
            $users = $this->Users->patchEntity($users, $this->request->data,['validate' => 'edit']);
            $old_data = $this->Users->get($id);
			if(!empty($filename)){
				$oldfilename = $old_data->profilePicture;
			}
			$path = WWW_ROOT . 'img/uploads/users/original/';
            if ($this->Users->save($users)) {
                if (!empty($userimage) && $userimage['name'] != '') {	
                    @unlink(WWW_ROOT . 'img/uploads/users/original/'.$oldfilename);
                    @unlink(WWW_ROOT . 'img/uploads/users/thumb/'.$oldfilename);
                    move_uploaded_file($userimage['tmp_name'], $path.$filename);
                    $MyImageCom = new ImgComponent();
                    $MyImageCom->prepare("img/uploads/users/original/".$filename);
                    $MyImageCom->resize(150,100);
                    $MyImageCom->save("img/uploads/users/thumb/".$filename);	
                    $this->request->session()->write('SNSAdmin.profilePicture', $filename);
				}
                $this->request->session()->write('SNSAdmin.fullName', $this->request->data['fullName']);
                $this->request->session()->write('SNSAdmin.email', $this->request->data['email']);
                $this->Flash->success(__('The admin details has been updated.'));
                return $this->redirect(['controller' => 'Admins', 'action' => 'edit']);
            } else {                
                $this->Flash->error(__('The admin details could not be updated. Please, try again.'));
            }
        }
        $this->set(compact('users'));
	
	
	/* breadcrumbs start */
	 $breadcrumbs = array();
	 $breadcrumbs[] = array(
	     'title' => 'Back to Homepage',
	     'link' => Configure::read('App.siteurl').'/admin/dashboard',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Admin Details'
	 );
	 $this->set('icon','<i class="fa fa-recycle"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }

	
	
	public function changepassword() {
		$this->loadModel('Users');
        $users = $this->Users->find()->where(['id' => '1'])->first();
        if($this->Auth->user('SNSAdmin.role') != 'Admin' && $this->Auth->user('SNSAdmin.role') == ''){
            return $this->redirect($this->Auth->logout());
        }
		if(!empty($this->request->data)){
            $users = $this->Users->patchEntity($users, [
                    'old_password'  => $this->request->data['old_password'],
                    'password'      => $this->request->data['password1'],
                    'password1'     => $this->request->data['password1'],
                    'password2'     => $this->request->data['password2']
                ],
                ['validate' => 'password']
            );
            if ($this->Users->save($users)) {
                $this->Flash->success('Password has been changed successfully');
                $this->redirect('/admin/changepassword');
            }else{
                $this->Flash->error(__('Invalid old password entered.'));
            }
		}
        $this->viewBuilder()->layout('Admin/admin');
		$layoutTitle = 'Admin Change Password';
        $this->set(compact('layoutTitle'));
        $this->set(compact('users'));
	
	/* breadcrumbs start */
	 $breadcrumbs = array();
	 $breadcrumbs[] = array(
	     'title' => 'Back to Homepage',
	     'link' => Configure::read('App.siteurl').'/admin/dashboard',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Admin Change Password'
	 );
	 $this->set('icon','<i class="fa fa-recycle"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
	 
	}

	
	public function forgotpassword() {
		$this->viewBuilder()->layout('Admin/adminlogin');
       
		$this->loadModel('Users');
		
		if(!empty($this->request->data)) {			
			$user = $this->Users->find()->where(['Users.email' => $this->request->data['email'], 'Users.role'=>'Admin'])->first();            
            if(empty($user))
			{
				$this->Flash->error(__('Email address does not exist.'));
			}else {
                
                    
                    
		
		     /****************************** Mail Send ***************************************************/
                     $adminEmail = Configure::read('App.adminEmail');
                     $adminName = Configure::read('App.siteName');
		     $mail=array();$body=NULL;
		     $this->loadModel('Mails');
		     $mail = $this->Mails->get(1);
		     $body=str_replace('{USERNAME}',$user->username,$mail->body);
		     $body=str_replace('{PASSWORD}',$user->password2,$body);
		     $email = new Email('Smtp');
		     $email->transport('Smtp');
		     $email->to($user->email) 
			->from([$adminEmail=>$adminName])
			->subject($mail->subject)
			->emailFormat('html')
			->template('send_mail')->viewVars(['data'=>$body]);
		     $email->send();
		   
		    /**********************************Mail Send ***********************************************/
                   
                    $this->Flash->success(__('Reset password has been successfully sent on your registered email.'));
                    $this->redirect(['controller' => 'Admins', 'action' => 'forgotpassword']);
		      }
		}
        
        $layoutTitle = 'Towing App :: Forget Password';
        $this->set(compact('layoutTitle'));
	}

	
	public function reset($token=null){
        $this->loadModel('Users');
		$this->viewBuilder()->layout('Admin/adminlogin');
        //die('ddd');\
        //$token = '';
		if(!empty($token)){
			$this->set('token',$token);
            if($this->request->data){
                if($this->request->data['password1'] != $this->request->data['password2']){
                    $this->Flash->error(__('Confirm password does not match.'));
                    //$this->redirect(['controller' => 'Admins', 'action' => 'logout']);
                }elseif(strlen($this->request->data['password1']) < 5){
                    $this->Flash->error(__('Password length minmun 6 character.'));
                }else{
                    $users = $this->Users->find()->where(['Users.passwordToken' => $token, 'Users.role' => 'Admin'])->first();
                    if(!empty($users)){
                        $password = (new DefaultPasswordHasher)->hash($this->request->data['password1']);
                            
                            $articles = TableRegistry::get('Users');
                            $query = $articles->query();
                            $query->update()
                                ->set(['password' => $password, 'passwordToken' => ''])
                                ->where(['id' => $users->id])
                                ->execute();
                        $this->Flash->success(__('Password reset successfully.'));
                        $this->redirect(['controller' => 'Admins', 'action' => 'login']);
                    }else{
                        $this->Flash->error(__('This reset token has been expired.'));
                    }
                }
            }
		}else{
            $this->Flash->error(__('This reset token has been expired.'));
            $this->redirect(['controller' => 'Admins', 'action' => 'logout']);
        }
         $layoutTitle = 'StudyBuddy :: Reset Password';
        $this->set(compact('layoutTitle'));
	}
//end controller
}
