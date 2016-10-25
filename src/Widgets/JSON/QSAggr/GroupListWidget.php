<?php

namespace Interpro\AdminPanelGenerator\Widgets\JSON\QSAggr;

use Interpro\AdminPanelGenerator\Contracts\WidgetProvider as WidgetProviderInterface;
use Interpro\AdminPanelGenerator\Contracts\Widgets\GroupWidget;
use Interpro\Core\Contracts\Taxonomy\Types\GroupType;

class GroupListWidget implements GroupWidget
{
    private $widgetProvider;
    private $type;
    private $name;

    /**
     * @param string $name
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param \Interpro\AdminPanelGenerator\Contracts\WidgetProvider $widgetProvider
     *
     * @return void
     */
    public function __construct($name, GroupType $type, WidgetProviderInterface $widgetProvider)
    {
        $this->type = $type;
        $this->widgetProvider = $widgetProvider;
        $this->name = $name;
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
     * @param array $labels
     *
     * @return string
     */
    public function draw(array $labels = [])
    {
        $template = '"group_list": {'.PHP_EOL;
        $template .= '"name": "'.$this->name.'",'.PHP_EOL;
        $template .= '"type": "'.$this->type->getName().'",'.PHP_EOL;
        $template .= '},'.PHP_EOL;

        return $template;
    }
}
