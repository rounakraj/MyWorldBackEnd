<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
//use Cake\ORM\RulesChecker;
 
class BannersTable extends Table
{
    public function initialize(array $config)
    {
        
    }
    public function validationDefault(Validator $validator)
    {        
        $validator->notEmpty('title', 'Please enter banner title.')
        ->add('title', 'minLength', [
            'rule' => ['minLength', 4], 
            'message' => 'Banner title must be atleast 4 character long.'
        ])
        ->add('title', 'maxLength', [
            'rule' => ['maxLength', 255], 
            'message' => 'Banner title exceeds maximum 255 character limit.'
        ]);
        
        $validator->add('smallDescription', 'minLength', [
            'rule' => ['minLength', 10], 
            'message' => 'Small Description be atleast 10 character long.'
        ])
        ->add('smallDescription', 'maxLength', [
            'rule' => ['maxLength', 255], 
            'message' => 'Small Description exceeds maximum 1000 character limit.'
        ])->allowEmpty('smallDescription');       
        
        $validator->notEmpty('image', 'Please select banner.')
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
        
        $validator->notEmpty('status', 'Please select faq status.');
        
        return $validator;
    }
    
    
}
