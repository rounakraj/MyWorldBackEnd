<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class CategoriesTable extends Table
{    
    
	public function validationCategory(Validator $validator)
    {
        $validator->notEmpty('categoryName', 'Please enter category title.')
        ->add('categoryName', 'minLength', [
            'rule' => ['minLength', 3], 
            'message' => 'category title must be atleast 3 character long.'
        ]);
                 
        return $validator;
    }
	
}