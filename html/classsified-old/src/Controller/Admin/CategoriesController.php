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

class CategoriesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['showprofile']);
    }

    
    public function index()
    {
        $layoutTitle = 'Manage Category';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        $limit = Configure::read('App.adminPageLimit');
        
        $this->paginate = [
            'limit' => $limit,
            'order' => [
                'Categories.id' => 'DESC'
            ],
        ];        
      $keyword = urldecode($this->request->query('keyword'));
       
        if($keyword != ''){
			$condition = [
				
				'OR' => [
					["Categories.categoryName LIKE '%".$keyword."%'"],
					
				]				
			];
		}        
        $query = $this->Categories->find('all')->where($condition);       
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
	     'name' => 'Manage Category'
	 );
	 $this->set('icon','<i class="fa fa-truck"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }
    
    
   
    
    
    
   private function adddtata($id=NULL)
    {
	$this->viewBuilder()->layout('Admin/admin');
	if(empty($id)){
	 $users = $this->Categories->newEntity();
	 $users->created=time();
	}else{
	$users = $this->Categories->find()->where(['Categories.id' => $id])->first();
	
	}
	
	$this->set('categories',$users);
        if ($this->request->is(['patch', 'post', 'put'])) {
	    
	    $users->modified=date('Y-m-d H:i:s');
	    $users = $this->Categories->patchEntity($users, $this->request->data, ['validate' => 'category']);
	
            if ($this->Categories->save($users)){
		
		if($id){
		    $this->Flash->success(__('Category has been edit successfully.'));
		}else{
		   $this->Flash->success(__('New Category has been added successfully.'));
		}
                return $this->redirect(['controller' => 'Categories', 'action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add new type, Please try again later.'));
            }
        }

    }
    
    
    public function edit($id)
    {
	
	$layoutTitle = 'Edit Category';
        $this->set(compact('layoutTitle'));
	$this->adddtata($id);
        
	/* breadcrumbs start */
	 $breadcrumbs = array();
	 $breadcrumbs[] = array(
	     'title' => 'Back to Homepage',
	     'link' => Configure::read('App.siteurl').'/admin/dashboard',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	 $breadcrumbs[] = array(
	     'title' => 'Manage Category',
	     'link' => Configure::read('App.siteurl').'/admin/categories/index',
	     'name' => 'Manage Category'
	 );
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Edit Category'
	 );
	 $this->set('icon','<i class="fa fa-truck"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }
    
  
     
    public function add()
    {
	$layoutTitle = 'Add Truck Type';
        $this->set(compact('layoutTitle'));
        $users = $this->Categories->newEntity(); 
	$this->adddtata();
        
	/* breadcrumbs start */
	 $breadcrumbs = array();
	 $breadcrumbs[] = array(
	     'title' => 'Back to Homepage',
	     'link' => Configure::read('App.siteurl').'/admin/dashboard',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	 $breadcrumbs[] = array(
	     'title' => 'Manage Category',
	     'link' => Configure::read('App.siteurl').'/admin/categories/index',
	     'name' => 'Manage Category'
	 );
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Add Category'
	 );
	 $this->set('icon','<i class="fa fa-truck"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }
    
    public function delete($id = null)
    {
        $users = $this->Categories->get($id);
        if ($this->Categories->delete($users)) {
		
            $this->Flash->success(__('Truck Type has been deleted.'));
        } else {
            $this->Flash->error(__('Truck Type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Categories', 'action' => 'index']);
    }
    
   
    public function status($id){

		$users = $this->Categories->get($id);
		$status = '1';
		$msg = 'activated';
		if($users->status == '1'){
			$status = '0';
			$msg = 'deactivated';
		}
		
		$articles = TableRegistry::get('Categories');
		$query = $articles->query();
		$query->update()
			->set(['status' => $status])
			->where(['id' => $id])
			->execute();		
			if($status==1){
			$users = $this->Categories->get($id);
							
			
			}
			
		
		return $this->redirect(['controller' => 'Categories', 'action' => 'index']);
	}
    
}