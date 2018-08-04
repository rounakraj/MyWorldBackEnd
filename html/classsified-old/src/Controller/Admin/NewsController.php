<?php
namespace App\Controller\Admin;
use App\Controller\Admin\AppController;
use App\Controller\Admin\Component\ImgComponent;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\View\Helper\TimeHelper;

class NewsController extends AppController
{

    /********************************************************************************
	Function Name: index
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to view all faq lists.
	*********************************************************************************/
    public function index()
     {
        $layoutTitle = 'Manage News';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        $limit = Configure::read('App.adminPageLimit');
        $this->paginate = [
            'limit' => $limit,
            'order' => [
                'News.created' => 'desc'
            ]
        ];        
        $keyword = $this->request->query('keyword');
        $condition = '';
        if($keyword != ''){
			$condition = [
						  'OR' => [
						   ["News.title LIKE '%".$keyword."%'"],
						   ["News.description LIKE '%".$keyword."%'"]
						]
					 ];
		}        
        $query = $this->News->find('all')->where($condition);       
        $news = $this->paginate($query);
        $news = $news->toArray();
        $this->set(compact('news', 'limit'));
		
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
	     'name' => 'Manage News'
	 );
	 $this->set('icon','<i class="fa fa-book"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }

    
    /********************************************************************************
	Function Name: add
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to add new faq.
	*********************************************************************************/
    public function add()
    {				$this->loadModel('Categories');                      

	
	$catrgories=$this->Categories->find('list')->select(['id','name'])->where(['status' =>1])->order(['name'=>'ASC'])->toArray();		
	$this->set(compact('catrgories'));
	
         $layoutTitle = 'Add News';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        $news = $this->News->newEntity(); 
        if ($this->request->data) {
			$newsimage = $this->request->data['image'];
			unset($this->request->data['image']);
			$filename = time() . $newsimage['name'];
			$this->request->data['image'] = $filename;
            $news = $this->News->patchEntity($news, $this->request->data, ['validate' => true]); 
            $news['created'] = date('Y-m-d H:i:s');
			$news['date'] = date('Y-m-d H:i:s');
			$path = WWW_ROOT . 'img/uploads/news/original/';
            if ($this->News->save($news)) {
			   if (!empty($newsimage) && $newsimage['name'] != '') {	
                    move_uploaded_file($newsimage['tmp_name'], $path.$filename);
                    $MyImageCom = new ImgComponent();
                    $MyImageCom->prepare("img/uploads/news/original/".$filename);
                    $MyImageCom->resize(75,75);
                    $MyImageCom->save("img/uploads/news/thumb/".$filename);	
				}
                $this->Flash->success(__('New has been added successfully.'));
                return $this->redirect(['controller' => 'News', 'action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add faq, Please try again later.'));
            }
		 }else{
			$this->Flash->error(__('Please fill all data in proper format.'));
		 }
        $this->set(compact('news')); 		        $this->set(compact('faq'));
		
			/* breadcrumbs start */
	 $breadcrumbs = array();
	 $breadcrumbs[] = array(
	     'title' => 'Back to Homepage',
	     'link' => Configure::read('App.siteurl').'/admin/dashboard',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	 $breadcrumbs[] = array(
	     'title' => 'Manage News',
	     'link' => Configure::read('App.siteurl').'/admin/news/index',
	     'name' => 'Manage News'
	 );
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Add News'
	 );
	 $this->set('icon','<i class="fa fa-book"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }
    
    
    /********************************************************************************
	Function Name: edit
	*Type: Public function used as action of the controller
	*Input: New id
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to update faq.
	*********************************************************************************/
    public function edit($id)
     { 
	     $this->loadModel('Categories');   
		 $catrgories=$this->Categories->find('list')->select(['id','name'])->where(['status' =>1])->order(['name'=>'ASC'])->toArray();		
	     $this->set(compact('catrgories'));
	
        $layoutTitle = 'Edit News';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        $news = $this->News->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$newsimage = $this->request->data['image'];
			unset($this->request->data['image']);
            if(!empty($newsimage['name'])){
				$filename = time() . $newsimage['name'];
				$this->request->data['image'] = $filename;
			}	
            $news = $this->News->patchEntity($news, $this->request->data, ['validate' => true]);
			$old_data = $this->News->get($id);
			if(!empty($filename)){
				$oldfilename = $old_data->image;
			}
			$path = WWW_ROOT . 'img/uploads/news/original/';
            if ($this->News->save($news)) {
			   if (!empty($newsimage) && $newsimage['name'] != '') {	
                    @unlink(WWW_ROOT . 'img/uploads/news/original/'.$oldfilename);
                    @unlink(WWW_ROOT . 'img/uploads/news/thumb/'.$oldfilename);
                    move_uploaded_file($newsimage['tmp_name'], $path.$filename);
                    $MyImageCom = new ImgComponent();
                    $MyImageCom->prepare("img/uploads/news/original/".$filename);
                    $MyImageCom->resize(75,75);
                    $MyImageCom->save("img/uploads/news/thumb/".$filename);	
				}
                $this->Flash->success(__('News has been updated successfully.'));
                return $this->redirect(['controller' => 'News', 'action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to update news. Please, try again.'));
            }
        }
        $this->set(compact('news'));
		
			/* breadcrumbs start */
	 $breadcrumbs = array();
	 $breadcrumbs[] = array(
	     'title' => 'Back to Homepage',
	     'link' => Configure::read('App.siteurl').'/admin/dashboard',
	     'name' => '<i class="glyphicon glyphicon-home"></i> Dashboard'
	 );
	 $breadcrumbs[] = array(
	     'title' => 'Manage News',
	     'link' => Configure::read('App.siteurl').'/admin/news/index',
	     'name' => 'Manage News'
	 );
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Edit News'
	 );
	 $this->set('icon','<i class="fa fa-book"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }
    
    /********************************************************************************
	Function Name: status
	*Type: Public function used as action of the controller
	*Input: New id
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to change status of news.
	*********************************************************************************/
    public function status($id = null) {
        $news = $this->News->get($id);
		$status = '1';
		$msg = 'activated';
		if($news->status == '1'){
			$status = '0';
			$msg = 'deactivated';
		}		
		$articles = TableRegistry::get('News');
		$query = $articles->query();
		$query->update()
			->set(['status' => $status])
			->where(['id' => $id])
			->execute();
		$this->Flash->success(__('News has been '.$msg.' successfully.'));
		return $this->redirect(['controller' => 'News', 'action' => 'index']);
    }
	
    /********************************************************************************
	Function Name: edit
	*Type: Public function used as action of the controller
	*Input: New id
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to delete record from department.
	*********************************************************************************/
    public function delete($id = null)
    {
        $users = $this->News->get($id);
        if ($this->News->delete($users)) {			
            $this->Flash->success(__('News has been deleted.'));
        } else {
            $this->Flash->error(__('News could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'News', 'action' => 'index']);
    }
    
    /********************************************************************************
	Function Name: details
	*Type: Public function used as action of the controller
	*Input: New id
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to view faq.
	*********************************************************************************/
    public function details($id){
        $layoutTitle = 'StudyBuddy ::  News Details';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');        
		$news = $this->News->find()->where(['News.id' => $id])->first();
        if(!empty($news)){
            $this->set(compact('news'));
        }else{
            $this->Flash->error(__('News doesnot exist.'));
            return $this->redirect(['controller' => 'News', 'action' => 'index']);
        }
	}
    
    
    /********************************************************************************
	Function Name: view
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to view faq information.
	*********************************************************************************/
    public function view($faqId = '')
     {
        $this->loadModel('News');              
        $faq = $this->News->find()->where(['News.id' => $faqId])->first();       
        $this->set(compact('faq'));
    }
}