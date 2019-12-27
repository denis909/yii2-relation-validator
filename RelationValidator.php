<?php

namespace denis909\yii;

use Yii;
use yii\validators\Validator;

class RelationValidator extends Validator
{

    public $range = [];

    public $i18nCategory = 'app';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if ($this->message === null)
        {
            $this->message = Yii::t($this->i18nCategory, '"{attribute}" not related with "{value}".');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        foreach($model->{$attribute} as $value)
        {
            if (array_search($value->primaryKey, $this->range) === false)
            {
                $model->addError($attribute, strtr($this->message, [
                    '{attribute}' => $model->getAttributeLabel($attribute),
                    '{value}' => $value->primaryKey
                ]));
            }
        }
    }

}