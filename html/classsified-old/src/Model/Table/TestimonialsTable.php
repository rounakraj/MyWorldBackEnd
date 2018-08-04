<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
//use Cake\ORM\RulesChecker;
 
class TestimonialsTable extends Table
{
    public function initialize(array $config)
    {
        
    }
    public function validationDefault(Validator $validator)
    {        
        $validator->notEmpty('title', 'Please enter title.')
        ->add('question', 'minLength', [
            'rule' => ['minLength', 10], 
            'message' => 'Title must be atleast 10 character long.'
        ])
        ->add('title', 'maxLength', [
            'rule' => ['maxLength', 255], 
            'message' => 'Title exceeds maximum 255 character limit.'
        ]);
        
        $validator->notEmpty('message', 'Please enter message.')
        ->add('message', 'minLength', [
            'rule' => ['minLength', 10], 
            'message' => 'Message must be atleast 10 character long.'
        ])
        ->add('message', 'maxLength', [
            'rule' => ['maxLength', 1000], 
            'message' => 'Message exceeds maximum 1000 character limit.'
        ]);       
        
        $validator->notEmpty('status', 'Please select testimonial status.');
        return $validator;
    }
    
    
}
