<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class PagesTable extends Table
{    
    public function validationDefault(Validator $validator)
    {
        $validator->notEmpty('page_title', 'Please enter page title.')
        ->add('page_title', 'minLength', [
            'rule' => ['minLength', 3], 
            'message' => 'Page title must be atleast 3 character long.'
        ])
        ->add('page_title', 'maxLength', [
            'rule' => ['maxLength', 255], 
            'message' => 'Page title exceeds maximum 255 character limit.'
        ]);
        /*->add('page_title', 'unique',[
            'rule' => 'validateUnique',
            'provider' => 'table',
            'message' => 'Page title already used.'
        ]);*/
        
        $validator->notEmpty('content', 'Please enter page content.')
        ->add('content', 'minLength', [
            'rule' => ['minLength', 10], 
            'message' => 'Page content must be atleast 10 character long.'
        ]);
        
        $validator->notEmpty('status', 'Please select page status.');            
        return $validator;
    }
}