<?php
namespace App\Controller\Admin;
use App\Controller\Admin\Component\ImgComponent;
use Cake\Datasource\ConnectionManager;
use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Routing\RequestActionTrait;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['showprofile']);
    }

    
    public function index()
    {
        $layoutTitle = 'Manage User';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        $limit = Configure::read('App.adminPageLimit');
        
        $this->paginate = [
            'limit' => $limit,
            'order' => [
                'Users.organisationName' => 'ASC'
            ],
        ];        
      $keyword = urldecode($this->request->query('keyword'));
        $condition = ['Users.role !=' => 'Admin'];
	$condition = ['Users.role' => 'U'];
        if($keyword != ''){
			$condition = [
				"Users.role != 'Admin'",
				"Users.role = 'E'",
				'OR' => [
					["Users.fullName LIKE '%".$keyword."%'"],
					["Users.email LIKE '%".$keyword."%'"]
				]				
			];
		}        
        $query = $this->Users->find('all')->where($condition);       
        $users = $this->paginate($query);

		
       $users = $users->toArray();
	 
        $this->set(compact('users', 'limit'));
	
	
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
	     'name' => 'Manage User'
	 );
	
	 $this->set('icon','<i class="fa fa-user"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }
    
    
  
    public function profile($memberId = ''){
        $layoutTitle = 'StudyBuddy :: Manage Member';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');               
        $users = $this->Users->find('all')->where(['Users.id' => $memberId])->contain(['ReportedProfiles' => ['ReportedPerson']])->select(['Users.id', 'Users.username', 'Users.email', 'Users.fullName', 'Users.profilePicture'])->first();       
        $this->set(compact('users'));
    }
    
    
    public function deleteprofile($memberid = '', $reportedid = '')
    {
        $this->loadModel('ReportedProfiles');
        $users = $this->ReportedProfiles->get($reportedid);
        if ($this->ReportedProfiles->delete($users)) {
			$this->Flash->success(__('Reporting member has been removed.'));
        } else {
            $this->Flash->error(__('Unable to remove reporting member. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'profile', $memberid]);
    }
    
   
    
   private function addUser($id=NULL)
    {
	$this->viewBuilder()->layout('Admin/admin');
	if(empty($id)){
	 $users = $this->Users->newEntity();
	 $users->created=date('Y-m-d H:i:s');
	}else{
	$users = $this->Users->find()->where(['Users.id' => $id])->first();
	$users->password=$users->password2;
	}
	$this->set('users',$users);
	
        if ($this->request->is(['patch', 'post', 'put'])) {
	    
	    
	    $this->request->data['role'] = 'U';
	    $this->request->data['password2']=$this->request->data['password'];
	    $users->modified=date('Y-m-d H:i:s');
	    $users = $this->Users->patchEntity($users, $this->request->data, ['validate' => 'employee']);
	
            if ($users=$this->Users->save($users)){
		
		if($id){
		    $this->Flash->success(__('User has been edit successfully.'));
		}else{
		     $this->regMail($users->id);
		    $this->Flash->success(__('New User has been added successfully.'));
		}
                return $this->redirect(['controller' => 'Users', 'action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add new User, Please try again later.'));
            }
        }

	
	$this->set('siteurl', Configure::read('App'));
	
	
    }
    
    
    public function edit($id)
    {
	
	$layoutTitle = 'Edit Employee';
        $this->set(compact('layoutTitle'));
	$this->addUser($id);
	
	
	 /* breadcrumbs start */
	 $breadcrumbs = array();
	 $breadcrumbs[] = array(
	     'title' => 'Back to Homepage',
	     'link' => Configure::read('App.siteurl').'/admin/dashboard',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	 $breadcrumbs[] = array(
	     'title' => 'Manage User',
	     'link' => Configure::read('App.siteurl').'/admin/users/index',
	     'name' => 'Manage User'
	 );
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Edit User'
	 );
	 $this->set('icon','<i class="fa fa-user"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    
        
	
    }
    
   
    
    function regMail($id=NULL){
	$user = $this->Users->find()->where(['Users.id' => $id])->first();
	if($user){
		$adminEmail = Configure::read('App.adminEmail');
		$adminName = Configure::read('App.siteName');
		
		    
		     /****************************** Mail Send Admin***************************************************/		  
		     $mail=array();$body=NULL;
		     $this->loadModel('Mails');
		     $mail = $this->Mails->get(10);
		     $body=str_replace('{NAME}',$user->fullName,$mail->body);
		     $body=str_replace('{EMAIL}',$user->email,$body);
		     $email = new Email('Smtp');
		     $email->transport('Smtp');
		     $email->to($adminEmail) 
			->from([$user->email=>$user->fullName.' '.$user->lastName])
			->subject($mail->subject)
			->emailFormat('html')
			->template('send_mail')->viewVars(['data'=>$body]);
		     $email->send();
		   
		    /**********************************Mail Send Admin***********************************************/
		    
		    
		    /****************************** Mail Send User***************************************************/		  
		     $mail=array();$body=NULL;
		     $this->loadModel('Mails');
		     $mail = $this->Mails->get(5);
		     $body=str_replace('{NAME}',$user->fullName,$mail->body);
		     $body=str_replace('{EMAIL}',$user->email,$body);
		     $body=str_replace('{PASSWORD}',$user->password2,$body);
		     $email->reset();
		     $email->transport('Smtp');
		     $email->to($user->email) 
			->from([$adminEmail=>$adminName])
			->subject($mail->subject)
			->emailFormat('html')
			->template('send_mail')->viewVars(['data'=>$body]);
		     $email->send();
		     
		    
		    /**********************************Mail Send User***********************************************/
		    
		    
		   
		  	
	}
	    
    }
     
    public function add()
    {
	$layoutTitle = 'Add User';
        $this->set(compact('layoutTitle'));
        $users = $this->Users->newEntity(); 
	$this->addUser();
	
	 /* breadcrumbs start */
	 $breadcrumbs = array();
	  $breadcrumbs[] = array(
	     'title' => 'Back to Homepage',
	     'link' => Configure::read('App.siteurl').'/admin/dashboard',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	 $breadcrumbs[] = array(
	     'title' => 'Manage User',
	     'link' => Configure::read('App.siteurl').'/admin/users/index',
	     'name' => 'Manage User'
	 );
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Add User'
	 );
	 $this->set('icon','<i class="fa fa-user"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
        
	
    }
    
    public function delete($id = null)
    {
        $users = $this->Users->get($id);
        if ($this->Users->delete($users)) {
			//@unlink(WWW_ROOT . 'img/uploads/users/original/'.$users->profilePicture);
			//@unlink(WWW_ROOT . 'img/uploads/users/thumb/'.$users->profilePicture);
            $this->Flash->success(__('User has been deleted.'));
        } else {
            $this->Flash->error(__('User could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'index']);
    }
    
    
   
    public function status($id){

		$users = $this->Users->get($id);
		$status = '1';
		$msg = 'activated';
		if($users->status == '1'){
			$status = '0';
			$msg = 'deactivated';
		}
		
		$articles = TableRegistry::get('Users');
		$query = $articles->query();
		$query->update()
			->set(['status' => $status])
			->where(['id' => $id])
			->execute();		
			if($status==1){
			$users = $this->Users->get($id);
							
			
			}
			
		
		return $this->redirect(['controller' => 'Users', 'action' => 'index']);
	}
    
   
    public function details($id){
        $layoutTitle = 'Employee Details';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');        
		$users = $this->Users->find()->where(['Users.id' => $id])->first();
        if(!empty($users)){
            $this->set(compact('users'));
        }else{
            $this->Flash->error(__('User doesnot exist.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }
	}    
	

	
}