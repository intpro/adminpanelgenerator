<?php

namespace Interpro\AdminPanelGenerator\Widgets\JSON\QSAggr;

use Interpro\AdminPanelGenerator\Contracts\WidgetProvider as WidgetProviderInterface;
use Interpro\AdminPanelGenerator\Contracts\Widgets\GroupWidget;
use Interpro\Core\Contracts\Taxonomy\Types\GroupType;
use Interpro\Core\Taxonomy\Enum\TypeMode;
use Interpro\Core\Taxonomy\Enum\TypeRank;

class GroupItemWidget implements GroupWidget
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
        $template = '';

        $fields = $this->type->getFields();

        foreach($fields as $field)
        {
            $field_type        = $field->getFieldType();

            if($field_type->getRank() === TypeRank::BLOCK)
            {
                continue;
            }

            $field_name        = $field->getName();
            $field_type_name   = $field_type->getName();
            $field_type_family = $field_type->getFamily();

            if($field_type->getMode() === TypeMode::MODE_A)
            {
                $field_type_prefix = 'group_ref';
            }
            else
            {
                $field_type_prefix = 'own_field';
            }

            $widget = $this->widgetProvider->getWidget($field_type_family.'.'.$field_type_prefix.'.'.$field_type_name);

            $template .= '"'.$field_name.'": {'.PHP_EOL;

            if(array_key_exists($field_name, $labels))
            {
                $label = $labels[$field_name];
            }
            else
            {
                $label = '';
            }

            $template .= '"label": "'.$label.'",'.PHP_EOL;

            $template .= '"field": "'.$widget->draw($field).'"'.PHP_EOL;

            $template .= '},'.PHP_EOL;
        }

        $template = substr_replace($template, '', -2, 1);

        return $template;
    }
}
