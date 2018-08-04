<?php
namespace App\Model\Table;

use App\Model\Entity\Tag;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tags Model
 *
 */
class GlobalParametersTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('minimumSweetCompatibility', 'Please enter minimum level of sweet compatibility percentage.')
            ->add('minimumSweetCompatibility','numeric',[
                'rule'=>  function($value){
                    if (is_numeric($value) && ($value > 0 && $value <=100)) {
                            return true;
                    }
                    return false;
                },
                'message'=>'Minimum level of sweet compatibility percentage must be greater than zero and less than hundred.',
        ]);
        $validator
            ->notEmpty('minimumSourCompatibility', 'Please enter minimum level of sour compatibility percentage.')
            ->add('minimumSourCompatibility','numeric',[
                'rule'=>  function($value){
                    if (is_numeric($value) && ($value > 0 && $value <=100)) {
                            return true;
                    }
                    return false;
                },
                'message'=>'Minimum level of sour compatibility percentage must be greater than zero and less than hundred.',
        ]);
        return $validator;
    }
}
