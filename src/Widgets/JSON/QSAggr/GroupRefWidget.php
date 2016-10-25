<?php

namespace Interpro\AdminPanelGenerator\Widgets\JSON\QSAggr;

use Interpro\AdminPanelGenerator\GeneratorException;
use Interpro\Core\Contracts\Taxonomy\Types\GroupType;
use Interpro\AdminPanelGenerator\Contracts\Widgets\GroupRefWidget as GroupRefWidgetInterface;

class GroupRefWidget implements GroupRefWidgetInterface
{
    private $type;
    private $name;

    /**
     * @param string $name
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     *
     * @return void
     */
    public function __construct($name, GroupType $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\Type $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Interpro\Core\Taxonomy\Fields\RefField $ref
     * @param array $labels
     *
     * @return string
     */
    public function draw($ref, array $labels = [])
    {
        $owner_type_name = $ref->getOwnerType()->getName();
        $field_type_name = $ref->getFieldType()->getName();
        $field_name = $ref->getName();

        if($this->getType()->getName() !== $field_type_name)
        {
            throw new GeneratorException('Попытка нарисовать виджет без соответствия типа ('.$this->getType()->getName().'=>'.$field_type_name.')!');
        }

        return '(field-ref, owner='.$owner_type_name.', type='.$field_type_name.', name='.$field_name.')';
    }
}
