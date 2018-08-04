<?php
namespace App\Controller;
use Cake\Core\Configure;
use App\Controller\AppController;

use Cake\ORM\Query;
use Cake\I18n\Time;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\RequestActionTrait;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use App\Controller\Component\ImgComponent;

/********************************************************************************
	Class Name: WebservicesController
	*Type: Public function used for API for device
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Json Data for API.
*********************************************************************************/
	$req_dump = '--------------------'.date("Y-m-d h:i:s").'---------------------------->'; 
	$req_dump .= print_r($_FILES, TRUE);
	$req_dump .= print_r($_POST, TRUE);
	//$req_dump .= print_r($_REQUEST, TRUE);
	$fp = fopen('request.log', 'a');
	fwrite($fp, $req_dump);
	fclose($fp);
	
class WebservicesController extends AppController{
     var $productfile = 'http://kseducation.in/img/uploads/products/device/';
	 var $productDocUrl = 'http://kseducation.in/img/uploads/products/original/';
   
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
    }
	
	
	public function index(){
		$this->viewBuilder()->layout('');
		$this->loadModel('Users');
		$this->autoRender = false;
		$response=array();
		
		if(isset($this->request->data['action']) && method_exists($this, $this->request->data['action']) ){
			$action = trim($this->request->data['action']); 
			unset($this->request->data['action']);
			$response = $this->$action(); 
		}
		else{
			$response['status'] = 0;
			$response['msg'] = 'Invalid action key';
		}
		echo json_encode($response); exit; 
	}
	
	function IsNull($data){
		//$data = (array) $data;
		
	 return $data;	
	}
	/* action : login
	   function : User login for
	*/
	function login(){
		$required=array('email','password');
		
		if($this->request->data['email'] && $this->request->data['password']){
				$password = $this->request->data['password'];
				$email = $this->request->data['email'];
				$value=(new DefaultPasswordHasher)->hash($password);
				$user = $this->Users->find()->where(['Users.email' => $email])->first();
			  if($user){
				  if($user->status == 1) {  
					$check = (new DefaultPasswordHasher)->check($password, $user->password);
					if($check){
						$response['status'] = 1;
						$userdata=$this->profile($user->id);
						$response['response'] = $userdata['response'];
						$response['msg'] = 'You are logged in!';
					
					}else{
						$response['status'] = 0;
						$response['msg'] = 'Incorrect Password! Please forgot password!';
					}
				  
				  }else{
					  $response['status'] = 0;
					  $response['msg'] = 'Your account has been deactived, please contact administrator.';
				  }
					
			  }else{
				$response['status'] = 0;
				$response['msg'] = 'Incorrect Details! Please Signup!';  
			  }
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field '. implode(',',$required);
		}
		return $response;
		
	}
	/* action : profile
	   function : User profile details
	*/ 
	function profile($userId=NULL){
		$userId = ($userId) ? $userId : $this->request->data['userId'];
		if($userId){
			$fields=['id','social_id','email','fullName','lastname','dob','mobile','address'];
			$userInfo = $this->Users->find()->select($fields)
													->where(['Users.id' => $userId])
													->first();
			
			
			$userInfo->social_id=($userInfo->social_id) ? $userInfo->social_id : '';
			$userInfo->address=($userInfo->address) ? $userInfo->address : '';
			$userInfo->dob=($userInfo->dob) ? $userInfo->dob : '';
			$response['status'] = 1;
			$response['response'] =$userInfo;
			$response['msg'] = 'Logged user details!';  										
			
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field userId';
		}
		return $response;
	}
	/* action : register
	   function : User Register for
	*/ 
	function register(){
		$required=array('fullName','lastname', 'mobile', 'email', 'password');
		if($this->request->data['fullName'] && $this->request->data['lastname'] && $this->request->data['mobile'] && $this->request->data['email'] && $this->request->data['password']){
			
			$users = $this->Users->newEntity(); 
			$validatEmail = $this->Users->find()->where(['Users.email' => $this->request->data['email']])->count();
			if(!$validatEmail){
					$this->request->data['password2']=$this->request->data['password'];
					$this->request->data['created']=date('Y-m-d H:i:s');
					$this->request->data['login_status']=1;
					$this->request->data['logintime']=time();
					$this->request->data['lastLogin']='';
					$this->request->data['logouttime']='';
					$this->request->data['role']='U';
					$this->request->data['status']='1';
					$users = $this->Users->patchEntity($users, $this->request->data);	
					if($userInfo=$this->Users->save($users)){
						$this->registermail($userInfo->id);
						$response['status'] = 1;
						$userdata=$this->profile($userInfo->id);
						$response['response'] = $userdata['response'];
						$response['msg'] = 'You are register in scusses!';  
					}else{
						$response['status'] = 0;
						$response['msg'] = 'Oops! An error occurred while registereing';	
					}
					
				
			}else{
				$response['status'] = 0;
				$response['msg'] = 'Sorry, this email already existed';
			}					
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field '. implode(',',$required);
		}
		return $response;
	}
	
	
	/* action : socilaLogin
	   function : User Register for
	*/ 
	function socilaLogin(){
		$required=array('socialId','loginType');
		if($this->request->data['socialId'] && $this->request->data['loginType']){
			
			$users = $this->Users->newEntity();
			if($this->request->data['email']){
				$validatEmail = $this->Users->find()->where(['Users.email' => $this->request->data['email'],'Users.role' => 'U'])->first();
			}else{
				$validatEmail = $this->Users->find()->where(['Users.social_id' => $this->request->data['socialId'],'Users.role' => 'U'])->first();
			}
			if(!$validatEmail){
					
					$this->request->data['social_id']=$this->request->data['socialId'];
					$this->request->data['created']=date('Y-m-d H:i:s');
					$this->request->data['login_status']=1;
					$this->request->data['logintime']=time();
					$this->request->data['lastLogin']='';
					$this->request->data['logouttime']='';
					$this->request->data['role']='U';
					$this->request->data['status']='1';
					$users = $this->Users->patchEntity($users, $this->request->data);	
					if($userInfo=$this->Users->save($users)){
						$this->registermail($userInfo->id);
						$response['status'] = 1;
						$userdata=$this->profile($userInfo->id);
						$response['response'] = $userdata['response'];
						$response['msg'] = 'You are logged in!';  
					}else{
						$response['status'] = 0;
						$response['msg'] = 'Oops! An error occurred while social login';	
					}
					
				
			}else{
				$response['status'] = 1;
				$userdata=$this->profile($validatEmail->id);
				$response['response'] = $userdata['response'];
				$response['msg'] = 'You are logged in!';
			}					
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field '. implode(',',$required);
		}
		return $response;
	}
	
	/* action : forgetpassword
	   function : Send OTP mobile and mail
	*/ 
	function forgetpassword(){
		$required=array('email');
		if($this->request->data['email']){
		     $user = $this->Users->find()->where(['Users.email' => $this->request->data['email']])->first();
			  if(!empty($user)){
				    if($user->status == 1){
						$subject =ucfirst(Configure::read('App.siteName')).' - Forgot Password';
						   $Email_variables = [
								'fullname' => $user->fullName,
								'email' => $user->email,
								'password' =>$user->password2,
								'title_for_layout' => $subject,
							 ];
					
							$mail_template='forgotpassword';
							$email = new Email('Smtp');
							$email->template($mail_template, 'email_layout')
									->emailFormat('html')
									->viewVars($Email_variables)  
									->subject($subject)
									->to($user->email)
									->from([Configure::read('App.adminEmail')=>Configure::read('App.siteName')])
									->send();
									
					$response['status'] = 1;
					$response['msg'] = 'Password send to registered email address please check mail.';  
					}else{
					$response['status'] = 0;
					$response['msg'] = 'You account has been deactivated. Please contact administrator.';  
					}
				
			  }else{
				$response['status'] = 0;
				$response['msg'] = 'Incorrect Details! Please Signup!';  
			  }
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field '. implode(',',$required);
		}
		return $response;
	}
	
	/* action : editprofile
	   key- userId,name
	   function : password change through OTP
	*/
	function editprofile(){
		if($this->request->data['userId']){
		     $users = $this->Users->find()->where(['Users.id' => $this->request->data['userId']])->first();
			 if($users){
				   $users = $this->Users->patchEntity($users, $this->request->data);	
					if($userInfo=$this->Users->save($users)){
						$response['status'] = 1;
						$userdata=$this->profile($userInfo->id);
						$response['response'] = $userdata['response'];
						$response['msg'] = 'Details updated Successfully';  
					}else{
						$response['status'] = 0;
						$response['msg'] = 'Details failed to update. Please try again!';  
					}
			  }else{
				$response['status'] = 0;
				$response['msg'] = 'Insert Correct userId,try again';  
			  }
		
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field userId';
		}
		return $response;	
	}
	
	/* action : changepassword
	   key- userId,currentPassword,newPassword
	   function : password change through login user
	*/
	function changepassword(){
		$required=array('userId','currentPassword','newPassword');
		if($this->request->data['userId'] && $this->request->data['currentPassword'] && $this->request->data['newPassword']){
		     $users = $this->Users->find()->where(['Users.id' => $this->request->data['userId']])->first();
			 if($users){
				    $check = (new DefaultPasswordHasher)->check($this->request->data['currentPassword'], $users->password);
				    
					if($check){
						    $this->request->data['password']=$this->request->data['newPassword'];
							$this->request->data['password2']=$this->request->data['password'];
					        $users = $this->Users->patchEntity($users, $this->request->data);	
							if($userInfo=$this->Users->save($users)){
								$response['status'] = 1;
								$response['msg'] = 'Password updated Successfully';  
							}else{
								$response['status'] = 0;
								$response['msg'] = 'Details failed to update. Please try again!';  
							}
					}else{
						$response['status'] = 0;
						$response['msg'] = 'Current Password is Incorrect. Please try again!';  
					}
				   
			}else{
				$response['status'] = 0;
				$response['msg'] = 'Insert Correct userId,try again';  
			  }
		
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field '. implode(',',$required);
		}
		return $response;	
	}
	/* action : logout
	   function : User logout
	*/ 
	function logout(){
		if($this->request->data['userId']){
			 $users = $this->Users->find()->where(['Users.id' => $this->request->data['userId']])->first();
			 if($users){
					$this->request->data['login_status']=0;
					$this->request->data['lastLogin']='';
					$this->request->data['logouttime']=time();
				   $users = $this->Users->patchEntity($users, $this->request->data);	
					if($userInfo=$this->Users->save($users)){
						$response['status'] = 1;
						$response['msg'] = 'User logout Successfully';  
					}else{
						$response['status'] = 0;
						$response['msg'] = 'Details failed to update. Please try again!';  
					}
			  }else{
				$response['status'] = 0;
				$response['msg'] = 'Insert Correct userId,try again';  
			  }
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field userId';
		}
		return $response;
	}
	
	/* action : getEbook
	   key- userId
	   function : Ebook and Question Bank
	*/
	function getEbook(){
		$userId = ($userId) ? $userId : $this->request->data['userId'];
		$keyword = ($keyword) ? $keyword : $this->request->data['keyword'];
		$type = ($this->request->data['type']) ? $this->request->data['type'] : 1;
		if($userId && $type){
			$this->loadModel('Products');
			
			$condaction=array();
			if($keyword){
				$condaction['Products.title LIKE']=$keyword.'%';
			}
			$condaction['Products.status']=1;
			$condaction['Products.type']=$type;
			
			$fields=['id','title','image_name','price','free'];
			$bookInfo = $this->Products->find()->select($fields)
													->where($condaction)->contain(['Categories'=>function($q){
													return $q->select(['id','name']);
													}])
													->toArray();
			if($bookInfo){										
				$path = WWW_ROOT . 'img/uploads/products/device/';									
				foreach($bookInfo as $book){
					if(empty(file_exists($path.$book->image_name))){
						$MyImageCom = new ImgComponent();
						$MyImageCom->prepare("img/uploads/products/original/".$book->image_name);
						$MyImageCom->resize(172,239);
						$MyImageCom->save("img/uploads/products/device/".$book->image_name);
					}
					$book->image_name=($book->image_name) ? $this->productfile.$book->image_name : '';
					$book->category_name=$book->category->name;
					unset($book->category);
				}
			$response['status'] = 1;
			$response['response'] = $bookInfo;
			$response['msg'] = 'data has been get Successfully!';
			}else{
			$response['status'] = 0;
			$response['msg'] = 'No Record Found';
			}	
			
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field userId';
		}
		return $response;
	}
	
	/* action : getEbookDetails
	   function : Products details
	*/ 
	function getEbookDetails(){
		$prodId = ($prodId) ? $prodId : $this->request->data['prodId'];
		if($prodId){
			$this->loadModel('Products');
			$fields=['id','title','image_name','baseprice','price','free','short_description','writtenby','description'];
			$product = $this->Products->find()->select($fields)->where(['Products.id' => $prodId])
		            ->contain(['Categories'=>function($q){
								return $q->select(['id','name']);
							}])->first(); 
			
			if($product){
			$product->sku='KS-EDUCA'.$product->id;
			$product->category_name=$product->category->name;
			$product->image_name=($product->image_name) ? $this->productfile.$product->image_name : '';
			unset($product->category);
			
			$response['status'] = 1;
			$response['response']=$this->IsNull($product);
			$response['msg'] = 'Product details!';  										
			}else{
				$response['status'] = 0;
			$response['msg'] = 'prodId is not Valid!';
			}
		}else{
			$response['status'] = 0;
			$response['msg'] = 'Required Field prodId';
		}
		return $response;
	}
	
}	