<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\Entity;

class GlobalParametersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function index()
    {
        $layoutTitle = 'Global Parameters';
        $this->set(compact('layoutTitle'));
        $this->viewBuilder()->layout('Admin/admin');
        
		
		
		$globe=$this->GlobalParameters->find('list', [
											'keyField' => 'key', 
											'valueField' => ['value']
											])->toArray();
											
		$globalparameters = new Entity($globe);
		$this->set(compact('globalparameters'));
       
		
		if ($this->request->is(['patch', 'post', 'put'])) {            
            
				$query = $this->GlobalParameters->query();
				
				foreach($this->request->data as $key=>$value){
					
					echo $query = "UPDATE global_parameters SET value='$value' WHERE key='$key'";
					die;
					$conn = ConnectionManager::get('default');
					$conn->execute($query);
									
				}
				
				$this->Flash->success(__('Global parameter has been updated successfully.'));
                return $this->redirect(['controller' => 'GlobalParameters', 'action' => 'index']);
	
        }
        $this->set('globalparameters', $globalparameters);
		
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

	     'name' => $layoutTitle

	 );

	 $this->set('icon','<i class="fa fa-recycle"></i>');

	 $this->set('breadcrumbs',$breadcrumbs);

	 /* breadcrumbs end */
    }
}