<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
//use Cake\ORM\RulesChecker;
 
class FaqsTable extends Table
{
    public function initialize(array $config)
    {
        
    }
    public function validationDefault(Validator $validator)
    {        
        $validator->notEmpty('question', 'Please enter question.')
        ->add('question', 'minLength', [
            'rule' => ['minLength', 10], 
            'message' => 'Question must be atleast 10 character long.'
        ])
        ->add('question', 'maxLength', [
            'rule' => ['maxLength', 255], 
            'message' => 'Question exceeds maximum 255 character limit.'
        ]);
        
        $validator->notEmpty('answer', 'Please enter answer.')
        ->add('answer', 'minLength', [
            'rule' => ['minLength', 10], 
            'message' => 'Answer must be atleast 10 character long.'
        ])
        ->add('answer', 'maxLength', [
            'rule' => ['maxLength', 1000], 
            'message' => 'Answer exceeds maximum 1000 character limit.'
        ]);       
        
        $validator->notEmpty('status', 'Please select faq status.');
        return $validator;
    }
    
    
}
