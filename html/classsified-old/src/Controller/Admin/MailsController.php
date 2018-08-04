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


class MailsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['showprofile']);
    }

    
    public function index()
    {
        $layoutTitle = 'Manage Mail';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        $limit = Configure::read('App.adminPageLimit');
        
        $this->paginate = [
            'limit' => $limit,
            'order' => [
                'Mails.organisationName' => 'ASC'
            ],
        ];        
      $keyword = urldecode($this->request->query('keyword'));
       
        if($keyword != ''){
			$condition = [
				
				'OR' => [
					["Mails.title LIKE '%".$keyword."%'"],
					["Mails.subject LIKE '%".$keyword."%'"]
				]				
			];
		}        
        $query = $this->Mails->find('all')->where($condition);       
        $users = $this->paginate($query);
       $users = $users->toArray();
	 
        $this->set(compact('users', 'limit'));
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
        return $this->redirect(['controller' => 'Mails', 'action' => 'profile', $memberid]);
    }
    
    
    
    
   private function adddtata($id=NULL)
    {
	$this->viewBuilder()->layout('Admin/admin');
	if(empty($id)){
	 $users = $this->Mails->newEntity();
	 $users->created=date('Y-m-d H:i:s');
	}else{
	$users = $this->Mails->find()->where(['Mails.id' => $id])->first();
	$users->password=$users->password2;
	}
	$this->set('users',$users);
	
        if ($this->request->is(['patch', 'post', 'put'])) {
	   
	    
	    $users = $this->Mails->patchEntity($users, $this->request->data, ['validate' => 'mail']);
	    $users->modified=date('Y-m-d H:i:s');
	
            if ($this->Mails->save($users)){
		
		if($id){
		    $this->Flash->success(__('Mail has been edit successfully.'));
		}else{
		   //  $this->regMail($id->id);
		    $this->Flash->success(__('New Mail has been added successfully.'));
		}
                return $this->redirect(['controller' => 'Mails', 'action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add new employee, Please try again later.'));
            }
        }

    }
    
    
    public function edit($id)
    {
	
	$layoutTitle = 'Edit Mail';
        $this->set(compact('layoutTitle'));
	$this->adddtata($id);
        
	
    }
    
  
    
    function regMail($id=NULL){
	$user = $this->Mails->find()->where(['Mails.id' => $id])->first();
	if($user){
		$adminEmail = Configure::read('App.adminEmail');
		$adminName = Configure::read('App.siteName');
		
		    
		     /****************************** Mail Send Admin***************************************************/		  
		     $mail=array();$body=NULL;
		     $this->loadModel('Mails');
		     $mail = $this->Mails->get(10);
		     $body=str_replace('{NAME}',$user->fullName.' '.$user->lastName,$mail->body);
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
		    
		    
		   
		  die; 		
	}
	    
    }
     
    public function add()
    {
	$layoutTitle = 'Add Mail';
        $this->set(compact('layoutTitle'));
        $users = $this->Mails->newEntity(); 
	$this->adddtata();
        
	
    }
    
    public function delete($id = null)
    {
        $users = $this->Mails->get($id);
        if ($this->Mails->delete($users)) {
			@unlink(WWW_ROOT . 'img/uploads/users/original/'.$users->profilePicture);
			@unlink(WWW_ROOT . 'img/uploads/users/thumb/'.$users->profilePicture);
            $this->Flash->success(__('Member has been deleted.'));
        } else {
            $this->Flash->error(__('Member could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Mails', 'action' => 'index']);
    }
    
   
    public function status($id){

		$users = $this->Mails->get($id);
		$status = '1';
		$msg = 'activated';
		if($users->status == '1'){
			$status = '0';
			$msg = 'deactivated';
		}
		
		$articles = TableRegistry::get('Mails');
		$query = $articles->query();
		$query->update()
			->set(['status' => $status])
			->where(['id' => $id])
			->execute();		
			if($status==1){
			$users = $this->Mails->get($id);
							
			
			}
			
		
		return $this->redirect(['controller' => 'Mails', 'action' => 'index']);
	}
    
    
        public function details($id){
            $layoutTitle = 'Mail Details';
            $this->set(compact('layoutTitle'));
            $this->viewBuilder()->layout('Admin/admin');        
                    $users = $this->Mails->find()->where(['Mails.id' => $id])->first();
            if(!empty($users)){
                $this->set(compact('users'));
            }else{
                $this->Flash->error(__('Member doesnot exist.'));
                return $this->redirect(['controller' => 'Mails', 'action' => 'index']);
            }
	}    

}