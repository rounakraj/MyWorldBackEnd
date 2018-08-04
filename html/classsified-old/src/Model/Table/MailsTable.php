<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

 
class MailsTable extends Table
{
    public function initialize(array $config)
    {
        
    }
       
    public function validationMail(Validator $validator)
    {
	 
       
        $validator->notEmpty('title', 'Please enter title.');
        
       
	
	$validator->notEmpty('subject', 'Please enter subject.');
	
	$validator->notEmpty('body', 'Please enter body.');
	
	
        return $validator;
    }
}
