<?php

namespace Interpro\AdminPanelGenerator\Page;

use Interpro\AdminPanelGenerator\Collections\WidgetsCollection;
use Interpro\AdminPanelGenerator\Contracts\Page\Page;
use Interpro\AdminPanelGenerator\Contracts\Widgets\Widget;

class JSONPage implements Page
{
    private $layout = '';
    private $name;
    private $widgets;
    private $options = [];

    /**
     * @param string $name
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->widgets = new WidgetsCollection($name);
    }

    /**
     * @param string $layout_name
     *
     * @return void
     */
    public function setLayout($layout_name)
    {
        $this->layout = $layout_name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function draw()
    {
        $template = '{'.PHP_EOL;

        $template .= '"layout": "'.$this->layout.'",'.PHP_EOL;

        $template .= '"widgets": {'.PHP_EOL;

        //Рисование виджетов верхнего уровня:
        foreach($this->widgets as $widget)
        {
            $wname = $widget->getName();

            $template .= '"'.$wname.'": {'.PHP_EOL;

            $json = $widget->draw($this->options[$wname]);
            $template .= $json;

            $template .= '},'.PHP_EOL;
        }

        $template = substr_replace($template, '', -2, 1);

        $template .= '}'.PHP_EOL;
        $template .= '}'.PHP_EOL;

        return $template;
    }

    public function addWidget(Widget $widget, array $labels = [])
    {
        $this->widgets->addWidget($widget);
        $this->options[$widget->getName()] = $labels;
    }
}
