<?php

namespace Interpro\AdminPanelGenerator;

use Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsFamiliesCollection;
use Interpro\AdminPanelGenerator\Contracts\WidgetProvider as WidgetProviderInterface;

class WidgetProvider implements WidgetProviderInterface
{
    private $familyCollection;

    /**
     * @return void
     */
    public function __construct(WidgetsFamiliesCollection $familyCollection)
    {
        $this->familyCollection = $familyCollection;
    }

    /**
     * @param string $widget_path
     *
     * @return \Interpro\AdminPanelGenerator\Contracts\Widgets\Widget
     */
    public function getWidget($widget_path)
    {
        $family = $this->takeFamily($widget_path);
        //$widget = $this->takeWidget($widget_path);
        //$type_name = $this->takeTypeName($widget_path);

        return $this->familyCollection->getWidgets($family)->getWidget($widget_path);
    }

    private function takeFamily($widget_path)
    {
        $path = explode('.', $widget_path);

        if(count($path) !== 3)
        {
            throw new GeneratorException('Неправильно задан путь к виджету '.$widget_path.'!');
        }

        return $path[0];
    }

    private function takeWidget($widget_path)
    {
        $path = explode('.', $widget_path);

        if(count($path) !== 3)
        {
            throw new GeneratorException('Неправильно задан путь к виджету '.$widget_path.'!');
        }

        return $path[1];
    }

    private function takeTypeName($widget_path)
    {
        $path = explode('.', $widget_path);

        if(count($path) !== 3)
        {
            throw new GeneratorException('Неправильно задан путь к виджету '.$widget_path.'!');
        }

        return $path[2];
    }

    /**
     * @param string $family
     *
     * @return \Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsCollection
     */
    public function getFamily($family)
    {
        $this->familyCollection->getWidgets($family);
    }
}
