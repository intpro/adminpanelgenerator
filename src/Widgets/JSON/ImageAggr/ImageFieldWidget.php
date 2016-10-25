<?php

namespace Interpro\AdminPanelGenerator\Widgets\JSON\ImageAggr;

use Interpro\AdminPanelGenerator\Contracts\Widgets\OwnFieldWidget;
use Interpro\AdminPanelGenerator\GeneratorException;
use Interpro\Core\Contracts\Taxonomy\Types\BType;

class ImageFieldWidget implements OwnFieldWidget
{
    private $name;
    private $type;

    /**
     * @param string $name
     * @param \Interpro\Core\Contracts\Taxonomy\Types\BType $type
     *
     * @return void
     */
    public function __construct($name, BType $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\Type $type
     */
    public function getType()
    {
        return $this->type;
    }

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
