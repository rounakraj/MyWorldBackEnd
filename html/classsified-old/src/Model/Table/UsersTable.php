<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
//use Cake\ORM\RulesChecker;
 
class UsersTable extends Table
{
    public function initialize(array $config)
    {


      
    }
    public function validationUser(Validator $validator)
    {
	 
        $validator
        ->notEmpty('email', 'Please enter email address.')
        ->add('email', 'validFormat', [
            'rule' => 'email',
            'message' => 'Please enter valid email'])
         ->add('email', 'unique',[
            'rule' => 'validateUnique',
            'provider' => 'table',
            'message' => 'Email already registered.'
        ]);
         
        $validator->notEmpty('fullName', 'Please enter your first name.')
        ->add('fullName', 'minLength', [
            'rule' => ['minLength', 3], 
            'message' => 'First name must be atleast 3 character long.'
        ])
        ->add('fullName', 'maxLength', [
            'rule' => ['maxLength', 255], 
            'message' => 'First name exceeds maximum 255 character limit.'
        ]);
        
        $validator->notEmpty('lname', 'Please enter your last name.')
        ->add('lname', 'minLength', [
            'rule' => ['minLength', 2], 
            'message' => 'Last name must be atleast 2 character long.'
        ])
        ->add('lname', 'maxLength', [
            'rule' => ['maxLength', 100], 
            'message' => 'Last name exceeds maximum 100 character limit.'
        ]); 
        
        
        $validator->notEmpty('password', 'Please enter password.')
        ->add('password', 'minLength', [
            'rule' => ['minLength', 6], 
            'message' => 'Password must be atleast 6 character long.'
        ])
        ->add('password', 'maxLength', [
            'rule' => ['maxLength', 25], 
            'message' => 'Password exceeds maximum 25 character limit.'
        ]); 
            
            
        $validator->notEmpty('confpassword', 'Please confirm password.')
            ->add('confpassword', 'minLength', [
            'rule' => ['minLength', 6], 
            'message' => 'Confirm password must be atleast 6 character long.'
            ])
            ->add('confpassword', 'maxLength', [
            'rule' => ['maxLength', 25], 
            'message' => 'Confirm password exceeds maximum 25 character limit.'
            ])
            ->add('confpassword',[			
            'match'=>[
                'rule'=> ['compareWith','password'],
                'last' => true,
                'message'=>'Confirm password do not match with password.', 				
            ]
        ]); 

              
        return $validator;
    }
    
    
    public function validationPassword(Validator $validator )
    {
    
        $validator
            ->add('old_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'The old password is not correct!',
            ])
            ->notEmpty('old_password');
    
        $validator
            ->add('password1', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'Password should be minimum six character',
                ]
            ])
            ->add('password1',[
                'match'=>[
                    'rule'=> ['compareWith','password2'],
                    'message'=>'Password not match from confirm password',
                ]
            ])
            ->notEmpty('password1');
        $validator
            ->add('password2', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'Password should be minimum six character',
                ]
            ])
            ->add('password2',[
                'match'=>[
                    'rule'=> ['compareWith','password1'],
                    'message'=>'Confirm password not match from password',
                ]
            ])
            ->notEmpty('password2');
  
        return $validator;
    }
    
    
    public function validationEdit(Validator $validator )
    {
    
        $validator
            ->notEmpty('firstname', 'First name can not empty')
            ->add('firstname', 'minLength', [
				'rule' => ['minLength', 3], 
				'message' => 'Admin first name must be atleast three character long.'
			])
			->add('firstname', 'maxLength', [
				'rule' => ['maxLength', 50], 
				'message' => 'Admin first name exceeds maximum fifty character limit.'
			]); 
    
        $validator
            ->notEmpty('lastname', 'Last name can not empty')
            ->add('lastname', 'minLength', [
				'rule' => ['minLength', 3], 
				'message' => 'Admin last name must be atleast three character long.'
			])
			->add('lastname', 'maxLength', [
				'rule' => ['maxLength', 50], 
				'message' => 'Admin last name exceeds maximum fifty character limit.'
			]); 
        
        
        $validator
           ->add('email', [
                'notBlank' => [
                    'rule' => 'notBlank',
                    'message' => 'Not blank email address'
                ],
                'email' => [
                    'rule' => ['email'],
                    'message' => 'Please enter valid email address'
                ],
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => 'Email already exist'
                ]
            ]);
           
           $validator->add('profilePicture', [      
				'profilePicture' => [                    
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
		])->allowEmpty('profilePicture'); 
        return $validator;
    }
    
   
	
	
	
	
	
}
