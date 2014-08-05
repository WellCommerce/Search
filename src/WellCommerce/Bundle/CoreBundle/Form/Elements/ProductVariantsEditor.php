<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

/**
 * Class ProductVariantsEditor
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductVariantsEditor extends Field implements ElementInterface
{
    protected $_jsGetAttributeSetsForCategories;
    protected $_jsGetAttributesForSet;
    protected $_jsgetValuesForAttribute;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        if (!isset($this->attributes['allow_generate'])) {
            $this->attributes['allow_generate'] = 1;
        }
        $this->attributes['category_field']           = $this->attributes['category']->getName();
        $this->attributes['price_field']              = $this->attributes['price']->getName();
        $this->attributes['vat_field_name']           = $this->attributes['vat_field']->getName();
        $this->attributes['vat_values']               = App::getModel('vat/vat')->getVATValuesAll();
        $this->attributes['suffixes']                 = App::getModel('suffix/suffix')->getSuffixTypes();
        $this->_jsGetAttributeSetsForCategories        = 'GetAttributeSetsForCategories_' . $this->_id;
        $this->_jsGetAttributesForSet                  = 'GetAttributesForSet_' . $this->_id;
        $this->_jsgetValuesForAttribute                = 'getValuesForAttribute_' . $this->_id;
        $this->_jsGetCartesian                         = 'GetCartesian_' . $this->_id;
        $this->_jsAddAttribute                         = 'AddAttribute_' . $this->_id;
        $this->_jsAddValue                             = 'AddValue_' . $this->_id;
        $this->attributes['get_sets_for_categories']  = 'xajax_' . $this->_jsGetAttributeSetsForCategories;
        $this->attributes['getattributes_for_set']   = 'xajax_' . $this->_jsGetAttributesForSet;
        $this->attributes['get_values_for_attribute'] = 'xajax_' . $this->_jsgetValuesForAttribute;
        $this->attributes['get_cartesian']            = 'xajax_' . $this->_jsGetCartesian;
        $this->attributes['add_attribute']            = 'xajax_' . $this->_jsAddAttribute;
        $this->attributes['add_value']                = 'xajax_' . $this->_jsAddValue;
        App::getRegistry()->xajaxInterface->registerFunction(array(
            $this->_jsGetAttributeSetsForCategories,
            $this,
            'getAttributeSetsForCategories'
        ));
        App::getRegistry()->xajaxInterface->registerFunction(array(
            $this->_jsGetAttributesForSet,
            $this,
            'getAttributesForSet'
        ));
        App::getRegistry()->xajaxInterface->registerFunction(array(
            $this->_jsgetValuesForAttribute,
            $this,
            'getValuesForAttribute'
        ));
        App::getRegistry()->xajaxInterface->registerFunction(array(
            $this->_jsGetCartesian,
            $this,
            'getCartesian'
        ));
        App::getRegistry()->xajaxInterface->registerFunction(array(
            $this->_jsAddAttribute,
            $this,
            'addAttribute'
        ));
        App::getRegistry()->xajaxInterface->registerFunction(array(
            $this->_jsAddValue,
            $this,
            'addValue'
        ));
    }

    public function addAttribute($request)
    {
        $attributeId = App::getModel('attributeproduct/attributeproduct')->addAttributeGroupName($request['attribute']);
        App::getModel('attributegroup/attributegroup')->addAttributeToGroup($request['set'], $attributeId);
    }

    public function addValue($request)
    {
        App::getModel('attributeproduct/attributeproduct')->addAttributeGroupValues(Array(
            $request['value']
        ), $request['attribute']);
    }

    public function getAttributeSetsForCategories($request)
    {
        return Array(
            'sets' => App::getModel('attributegroup/attributegroup')->getGroupsForCategory($request['id'])
        );
    }

    public function getAttributesForSet($request)
    {
        return Array(
            'attributes' => App::getModel('attributegroup/attributegroup')->getAttributesForGroup($request['id'])
        );
    }

    public function getCartesian($request)
    {
        return Array(
            'variants' => App::getModel('product')->doAJAXCreateCartesianVariants($request)
        );
    }

    public function getValuesForAttribute($request)
    {
        return Array(
            'values' => App::getModel('attributeproduct/attributeproduct')->getAttributeProductValuesByAttributeGroupId($request['id'])
        );
    }

    public function prepareAttributesJs()
    {
        $attributes = Array(
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('get_sets_for_categories', 'fGetSetsForCategories', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('getattributes_for_set', 'fGetAttributesForSet', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('get_values_for_attribute', 'fgetValuesForAttribute', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('get_cartesian', 'fGetCartesian', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('add_attribute', 'fAddAttribute', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('add_value', 'fAddValue', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('category_field', 'sCategoryField'),
            $this->formatAttributeJs('price_field', 'sPriceField'),
            $this->formatAttributeJs('allow_generate', 'bAllowGenerate'),
            $this->formatAttributeJs('vat_field_name', 'sVatField'),
            $this->formatAttributeJs('vat_values', 'aoVatValues', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('currency', 'sCurrency'),
            $this->formatAttributeJs('photos', 'aoPhotos', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('availablity', 'aoAvailablity', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('suffixes', 'aoSuffixes', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('set', 'sSet'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        );

        return $attributes;
    }
}