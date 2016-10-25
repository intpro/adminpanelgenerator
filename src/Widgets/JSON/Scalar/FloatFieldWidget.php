<?php

namespace Interpro\AdminPanelGenerator\Widgets\JSON\Scalar;

use Interpro\AdminPanelGenerator\GeneratorException;

class FloatFieldWidget extends ScalarFieldWidget
{
    /**
     * @param \Interpro\Core\Taxonomy\Fields\OwnField $own
     * @param array $labels
     *
     * @return string
     */
    public function draw($own, array $labels = [])
    {
        $owner_type_name = $own->getOwnerType()->getName();
        $field_type_name = $own->getFieldType()->getName();
        $field_name = $own->getName();

        if($this->getType()->getName() !== $field_type_name)
        {
            throw new GeneratorException('Попытка нарисовать виджет без соответствия типа ('.$this->getType()->getName().'=>'.$field_type_name.')!');
        }

        return '(field-own, owner='.$owner_type_name.', type='.$field_type_name.', name='.$field_name.')';
    }
}
