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
namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
/********************************************************************************
	Calss Name: PagesController
	*Type: Public function used as action of the controller
	*Input: No input
	*Author: Gautam Suri
	*Modified By: Gautam Suri
	*Output: Function to view all page list and search.
	*********************************************************************************/
class PagesController extends AppController
{

    public function index()
     {
        $layoutTitle = 'Manage CMS Pages';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        $limit = Configure::read('App.adminPageLimit');
        $this->paginate = [
            'limit' => $limit,
            'order' => [
                'Pages.created' => 'desc'
            ]
        ];        
        $keyword = $this->request->query('keyword');
        $condition = '';
        if($keyword != ''){
			$condition = ["Pages.page_title LIKE '%".$keyword."%'"];
		}
        
        $query = $this->Pages->find('all')->where($condition);       
        $pages = $this->paginate($query);
        $pages = $pages->toArray();
        $this->set(compact('pages', 'limit'));
		
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
	     'name' => 'Manage CMS Pages'
	 );
	
	 $this->set('icon','<i class="fa fa-user"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }

    
	private function adddtata($id=NULL)
    {
	$this->viewBuilder()->layout('Admin/admin');
	if(empty($id)){
	 $users = $this->Pages->newEntity();
	 $users->created=time();
	}else{
	$users = $this->Pages->find()->where(['Pages.id' => $id])->first();
	
	}
	$this->set('pages',$users);
	
        if ($this->request->is(['patch', 'post', 'put'])) {
	    
	    $users->modified=time();
	    $users = $this->Pages->patchEntity($users, $this->request->data);
	    
            if ($this->Pages->save($users)){
		
		if($id){
		    $this->Flash->success(__('Page has been edit successfully.'));
		}else{
		   $this->Flash->success(__('New Page has been added successfully.'));
		}
                return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add new type, Please try again later.'));
            }
        }

    }
    
    
    public function edit($id)
    {
	
	$layoutTitle = 'Edit Page';
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
	     'title' => 'Manage Trucks Color',
	     'link' => Configure::read('App.siteurl').'/admin/colors/index',
	     'name' => 'Manage Trucks Type'
	 );
	 $breadcrumbs[] = array(
	     'title' => '',
	     'link' => '',
	     'name' => 'Edit Trucks Type'
	 );
	 $this->set('icon','<i class="fa fa-truck"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }
    

     
    public function add()
    {
		
	$layoutTitle = 'Add Page';
        $this->set(compact('layoutTitle'));
        $users = $this->Pages->newEntity(); 
		
	$this->adddtata();
        
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
	     'name' => 'Add Page'
	 );
	 $this->set('icon','<i class="fa fa-truck"></i>');
	 $this->set('breadcrumbs',$breadcrumbs);
	 /* breadcrumbs end */
    }
	
   
    public function status($id = null) {
        $pages = $this->Pages->get($id);
		$status = '1';
		$msg = 'activated';
		if($pages->status == '1'){
			$status = '0';
			$msg = 'deactivated';
		}		
		$articles = TableRegistry::get('Pages');
		$query = $articles->query();
		$query->update()
			->set(['status' => $status])
			->where(['id' => $id])
			->execute();
		$this->Flash->success(__('Cms page has been '.$msg.' by admin.'));
		return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
    }
	
   
    public function delete($id = null)
    {
        $tag = $this->Pages->get($id);
        if ($this->Pages->delete($tag)) {
            $this->Flash->success(__('The page has been deleted.'));
        } else {
            $this->Flash->error(__('The page could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
