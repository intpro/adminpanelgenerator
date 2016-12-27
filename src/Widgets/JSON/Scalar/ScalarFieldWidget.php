<?php

namespace Interpro\AdminPanelGenerator\Widgets\JSON\Scalar;

use Interpro\AdminPanelGenerator\Contracts\Widgets\OwnFieldWidget;
use Interpro\Core\Contracts\Taxonomy\Types\CType;

abstract class ScalarFieldWidget implements OwnFieldWidget
{
    private $name;
    private $type;

    /**
     * @param string $name
     * @param \Interpro\Core\Contracts\Taxonomy\Types\CType $type
     *
     * @return void
     */
    public function __construct($name, CType $type)
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
    abstract public function draw($own, array $labels = []);
}
