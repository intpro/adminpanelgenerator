<?php

namespace Interpro\AdminPanelGenerator\Collections;

use Interpro\AdminPanelGenerator\Contracts\Widgets\Widget;
use Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsCollection as WidgetsCollectionInterface;
use Interpro\AdminPanelGenerator\GeneratorException;
use Interpro\Core\Contracts\Named;
use Interpro\Core\Taxonomy\Collections\NamedCollection;

class WidgetsCollection extends NamedCollection implements WidgetsCollectionInterface, Named
{
    private $name;

    /**
     * @param string $name
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    protected function notFoundAction($name)
    {
        throw new GeneratorException('Не найден виджет по имени '.$name.'!');
    }

    /**
     * @param string $name
     *
     * @return \Interpro\AdminPanelGenerator\Contracts\Widgets\Widget
     */
    public function getWidget($name)
    {
        return $this->getByName($name);
    }

    /**
     * @param \Interpro\AdminPanelGenerator\Contracts\Widgets\Widget
     */
    public function addWidget(Widget $widget)
    {
        $this->addByName($widget);
    }
}
