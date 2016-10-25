<?php

namespace Interpro\AdminPanelGenerator\Collections;

use Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsCollection as WidgetsCollectionInterface;
use Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsFamiliesCollection as WidgetsFamiliesCollectionInterface;
use Interpro\AdminPanelGenerator\GeneratorException;
use Interpro\Core\Taxonomy\Collections\NamedCollection;

class WidgetsFamiliesCollection extends NamedCollection implements WidgetsFamiliesCollectionInterface
{
    protected function notFoundAction($name)
    {
        throw new GeneratorException('Не найден виджет по имени пакета'.$name.'!');
    }

    /**
     * @param string $name
     *
     * @return \Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsCollection
     */
    public function getWidgets($name)
    {
        return $this->getByName($name);
    }

    /**
     * @return \Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsCollection
     *
     * @return void
     */
    public function addWidgets(WidgetsCollectionInterface $collection)
    {
        $this->addByName($collection);
    }
}
