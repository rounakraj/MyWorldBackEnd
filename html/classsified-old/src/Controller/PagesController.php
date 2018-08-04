<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\Validation\Validator;
use Cake\Mailer\Email;

class PagesController extends AppController
{
    
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
        $this->Auth->allow(['test','home','display','contact', 'news', 'newsDetails', 'faq', 'view', 'community', 'subscribe', 'sendcontactmail', 'contactus']);
    }
	
	
    /********************************************************************************
	Function Name: home
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: nothing.
	*********************************************************************************/
    public function home()
    {
		return $this->redirect('/admin');
        $layoutTitle = 'Manage Member';
        
        $this->viewBuilder()->layout('home');
		
		$this->loadModel('News');
		$latesnews = $this->News->find('all')->where(['status' => 1])->limit('6')->order(['id'=>'desc'])->toArray();
		$this->set(compact('latesnews'));
		
		$this->loadModel('Products');
		$latesproducts = $this->Products->find('all')->where(['status' => 1])->limit('4')->order(['id'=>'desc'])->toArray();
		$this->set(compact('latesproducts'));
		
		$this->loadModel('Testimonials');
		$latestestimonials = $this->Testimonials->find('all')->where(['status' => 1])->limit('5')->order(['id'=>'desc'])->toArray();
		$this->set(compact('latestestimonials'));
		
    }
	
	/********************************************************************************
	Function Name: view
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to load cms pages.
	*********************************************************************************/
    public function view($slug='')
    {
		$this->loadModel('Pages');
		$pages = $this->Pages->find()->where(['Pages.status' => '1', 'Pages.slug' => $slug])->first();
		
		if($slug == 'aboutus'){
			$this->loadModel('Faqs');
			$faqs = $this->Faqs->find('all')->where(['Faqs.status' => '1'])->toArray();
			$this->set('faqs', $faqs);
		}
		if(empty($pages)){
			return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
		}
		$layoutTitle = $pages->page_title;
		$metaKeyword = $pages->meta_keyword;
		$metaDescription = $pages->meta_description;
        $this->viewBuilder()->layout('innerPage');
		
		$this->set(compact('pages', 'layoutTitle','metaKeyword','metaDescription'));
		
		
    }
		
	/********************************************************************************
	Function Name: contact
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to load contact page and send email.
	*********************************************************************************/
	public function contactus()
	{
		$errors = array();
		
		$pages = $this->Pages->find()->where(['Pages.status' => '1', 'Pages.id' => 23])->first();
		
		$layoutTitle = $pages->page_title;
		$metaKeyword = $pages->meta_keyword;
		$metaDescription = $pages->meta_description;
        $this->viewBuilder()->layout('innerPage');
		
		$this->set(compact('pages', 'layoutTitle','metaKeyword','metaDescription'));
		
				
	}
	
	/********************************************************************************
	Function Name: faqs
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to load contact page and send email.
	*********************************************************************************/
	public function faqs()
	{
		$errors = array();
		$this->loadModel('Faqs');
		$faqs = $this->Faqs->find()->where(['Faqs.status' => '1'])->toArray();
		
		$layoutTitle = 'Faq';
		$metaKeyword = 'Faq';
		$metaDescription = 'Faq';
        $this->viewBuilder()->layout('innerPage');
		
		$this->set(compact('faqs', 'layoutTitle','metaKeyword','metaDescription'));
		
	}
	
	public function contactRequest(){
				$this->loadModel('Contacts');
				$contact=$this->Contacts->newEntity();
				$this->request->data['ip_address']=$_SERVER['REMOTE_ADDR'];
				$this->request->data['name']=$this->request->data['form_name'];
				$this->request->data['email']=$this->request->data['form_email'];
				$this->request->data['subject']=$this->request->data['form_subject'];
				$this->request->data['phone']=$this->request->data['form_phone'];
				$this->request->data['massage']=$this->request->data['form_message'];
				$this->request->data['created']=date('Y-m-d H:i:s');
				
				$contact = $this->Contacts->patchEntity($contact, $this->request->data);
				if($contact=$this->Contacts->save($contact)){
					
					/****************************** Mail Send Admin***************************************************/
					$subject =ucfirst(Configure::read('App.siteName')).' - Contact Us';
					$Email_variables = [
						   'email' => $contact->email,
							'name' => $contact->name,
							'subject' => $contact->subject,
							'phone' => $contact->phone,
							'massage' => $contact->massage,
							'ip_address' => $contact->ip_address,
							'title_for_layout' => $subject
						 ];
				
					$mail_template='contactadmin';
					$email = new Email('Smtp');
					$email->template($mail_template, 'email_layout')
						->emailFormat('html')
						->viewVars($Email_variables)  
						->subject($subject)
						->to(Configure::read('App.adminEmail'))
						->from([Configure::read('App.adminEmail')=>Configure::read('App.siteName')])
						->send();
					/**********************************Mail Send Admin  ***********************************************/
				
					$subject ='Thanks For Contact To '.ucfirst(Configure::read('App.siteName'));
					$Email_variables = [
						   'fullname' => $contact->name,
						   'title_for_layout' => $subject,
						 ];
				
					$mail_template='contact';
					$email = new Email('Smtp');
					$email->template($mail_template, 'email_layout')
						->emailFormat('html')
						->viewVars($Email_variables)  
						->subject($subject)
						->to($contact->email)
						->from([Configure::read('App.adminEmail')=>Configure::read('App.siteName')])
						->send();


				}
		$response['message']='Thanks for contacting us. We’ll get back to you very soon.';
		$response['status']='true';
		echo json_encode($response);
		die;	
				
	}
	
		
	/********************************************************************************
	Function Name: contact
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to load latest news.
	*********************************************************************************/
	public function newsDetails($id='')
	{
		$errors = array();
		
		$layoutTitle = 'StudyBuddy :: Latest News';
		$this->loadModel('News');
		if($id == ''){
			return $this->redirect('/');
		}
		$news = $this->News->find()->where(['status' => 1, 'id' => $id])->first();
		//pr($news); die;
		$intagramUrl = $this->instagramUrl();
		$this->set(compact('layoutTitle', 'intagramUrl', 'banners', 'news'));
		$this->viewBuilder()->layout('innerPage');
	}
	
	/********************************************************************************
	Function Name: faq
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to faq pages.
	*********************************************************************************/
    public function faq()
    {
		$this->loadModel('Faqs');
		$faqs = $this->Faqs->find('all')->where(['Faqs.status' => '1'])->toArray();
		$layoutTitle = 'StudyBuddy :: Faqs';
        $this->viewBuilder()->layout('innerPage');
		$this->set(compact('faqs', 'layoutTitle'));
    }

	/********************************************************************************
	Function Name: community
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to load community pages.
	*********************************************************************************/
	function community(){
		$layoutTitle = 'StudyBuddy :: Community';
        $this->viewBuilder()->layout('innerPage');
		$this->loadModel('Pages');
		$slug = 'community';
		$pages = $this->Pages->find()->where(['Pages.status' => '1', 'Pages.slug' => $slug])->first();
		$this->set(compact('pages', 'layoutTitle'));
		
		$this->loadModel('Users');
		$stateList = $this->Users->find('list', ['keyField' => 'id', 'valueField' => 'state'])
							->where(['Users.role' => 'INSTITUTIONS'])
							->order(['Users.state'=>'ASC'])
							->group('state')->toArray();
							//pr($stateList); die;
		$states = $this->Users->find()
						->where(['Users.role' => 'INSTITUTIONS', 'Users.status' => 1, 'Users.state IN'=> $stateList])
						->order(['state' => 'asc'])
						->toArray();
		//pr($states); die('DD');
		$this->set(compact('states', 'stateList'));
	}
	
	/********************************************************************************
	Function Name: subscribe
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to subscribey email.
	*********************************************************************************/
	public function subscribe(){ 
	   
		if(trim($_GET['email'])){
		$this->loadModel('Subscribes');
		$get = $this->Subscribes->find()->where(['Subscribes.email'=>trim($_GET['email'])])->first();
		if(!empty($get)){
			$response['result']='error';
			$response['msg']='You have already subscribed !!';	
		}else{
		$subscribes = $this->Subscribes->newEntity();
		$this->request->data['email'] = trim($_GET['email']);
		$subscribes = $this->Subscribes->patchEntity($subscribes, $this->request->data, ['validate' => false]);
		$subscribes['created'] = date('Y-m-d H:i:s');
		$subscribes['status'] = 1;
		if ($this->Subscribes->save($subscribes)) {
			
			/****************************** Mail Send Admin***************************************************/
			$subject =ucfirst(Configure::read('App.siteName')).' - Subscribe';
			$Email_variables = [
				   'email' => $this->request->data['email'],
				   'title_for_layout' => $subject
				 ];
		
			$mail_template='subscribeadmin';
			$email = new Email('Smtp');
			$email->template($mail_template, 'email_layout')
				->emailFormat('html')
				->viewVars($Email_variables)  
				->subject($subject)
				->to(Configure::read('App.adminEmail'))
				->from([Configure::read('App.adminEmail')=>Configure::read('App.siteName')])
				->send();
			/**********************************Mail Send Admin  ***********************************************/
		
			$subject ='Thanks For Subscribe To '.ucfirst(Configure::read('App.siteName'));
			$Email_variables = [
				'email' => $this->request->data['email'],
				'title_for_layout' => $subject,
				 ];
		
			$mail_template='subscribe';
			$email = new Email('Smtp');
			$email->template($mail_template, 'email_layout')
				->emailFormat('html')
				->viewVars($Email_variables)  
				->subject($subject)
				->to($this->request->data['email'])
				->from([Configure::read('App.adminEmail')=>Configure::read('App.siteName')])
				->send();
		    
			$response['result']='success';
			$response['msg']= 'Subscribed sucessfully!!';
		}else{
			$response['result']='error';
			$response['msg']='Got Error !!';
		}
		}
		}else{
			$response['result']='error';
			$response['msg']='Please enter email address';	
		}
		echo json_encode($response);
		die;
	}
	
	/********************************************************************************
	Function Name: sendcontactmail
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to send contact mail.
	*********************************************************************************/
	public function sendcontactmail($name,$email,$subject,$message){
		if($email ==''){
			die('Get Error');
		}
		$this->loadModel('Users');
		$admin = $this->Users->find()->where(['id'=>1])->first();
		$Email_variables = [
			'name' => $name,
			'email' => $email,
			'subject' => $subject,
			'message' => $message,
			'templatemail' => Configure::read('App.adminEmail'),
			'title_for_layout' => 'Contact Us',
			'imagepath' => Configure::read('App.siteurl')                    
		];
		$mail_template='contact';
		$subject ='StudyBuddy :: Contact Us';
		//$mailto = $admin->email;
		//$mailto ='mohit@evirtualservices.com';
		$mailto ='studybuddy@studybuddyhelp.org';
		$this->sendmail($Email_variables, $mail_template, $mailto, $subject, $mailcc = '');
		echo '<spam style="color:#ff0000;">Thanks for contacting us. We\'ll get back to you very soon</spam>';
		die;
	}
	
	function video(){
		echo '<iframe width="580" height="330" src="https://www.youtube.com/embed/1C2-y94us-w" frameborder="0" allowfullscreen></iframe>';
		die;
	}
	
	
	
public function test()
     {
       
	$this->loadModel('Faqs');
               
        $keyword = "how";
        $condition = '';
        if($keyword != ''){
			$condition = [
						  'OR' => [
						   ["Faqs.question LIKE '%".$keyword."%'"],
						   ["Faqs.answer LIKE '%".$keyword."%'"]
						]
					 ];
		}        
        $query = $this->Faqs->find('all')->where($condition);  
        $news = $this->paginate($query);
        $news = $news->toArray();
	
	echo "<pre>";
	print_r($news);
	die;
	$this->set(compact('news', 'limit'));
    }
}