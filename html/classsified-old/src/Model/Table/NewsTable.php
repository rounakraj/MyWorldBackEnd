<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
//use Cake\ORM\RulesChecker;
 
class NewsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Categories', [
           'className' => 'Categories',
           'foreignKey' => 'categoriesId',
		   'filed' => 'id,name'
           
       ]);
    }
    public function validationDefault(Validator $validator)
    {        
        $validator->notEmpty('title', 'Please enter news title.')
        ->add('title', 'minLength', [
            'rule' => ['minLength', 5], 
            'message' => 'News title must be atleast 5 character long.'
        ])
        ->add('title', 'maxLength', [
            'rule' => ['maxLength', 255], 
            'message' => 'News title exceeds maximum 255 character limit.'
        ]);
        
        $validator->notEmpty('addedBy', 'Please enter addedby.')
        ->add('addedBy', 'minLength', [
            'rule' => ['minLength', 3], 
            'message' => 'AddedBy must be atleast 3 character long.'
        ])
        ->add('addedBy', 'maxLength', [
            'rule' => ['maxLength', 255], 
            'message' => 'AddedBy exceeds maximum 255 character limit.'
        ]);
        
        $validator->notEmpty('description', 'Please enter description.')
        ->add('description', 'minLength', [
            'rule' => ['minLength', 3], 
            'message' => 'Description must be atleast 3 character long.'
        ])
        ->add('description', 'maxLength', [
            'rule' => ['maxLength', 100000], 
            'message' => 'Description exceeds maximum 100000 character limit.'
        ]);
        
        $validator->notEmpty('date', 'Please choose date.');
        
        $validator->notEmpty('image', 'Please select image.')
            ->add('image', [      
                    'image' => [                    
                        'rule'=>  function($value){
                            $ext = explode(".", $value);
                            $extension = strtolower(end($ext));
                            
                            if (in_array(trim($extension), array('jpg', 'jpeg', 'png', 'gif'))) {							
                                return true;
                            }
                            return false;
                        },
                    'message'=>'Please select jpg, jpeg, gif and png only.',
                ]
            ]);
            
        $validator->notEmpty('categoriesId', 'Please select category name.');
        return $validator;
    }
    
    
}
