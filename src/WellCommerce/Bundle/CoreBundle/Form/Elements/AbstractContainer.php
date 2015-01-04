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

use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;

/**
 * Class AbstractContainer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractContainer extends AbstractNode
{
    /**
     * @var ElementCollection
     */
    protected $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ElementCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(ElementInterface $element)
    {
        $this->children->add($element);

        return $element;
    }

    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->children->forAll(function (ElementInterface $element) use ($filter) {
            $element->addFilter($filter);
        });
    }

    public function setValue($data)
    {

    }

    public function getValue()
    {
        $values = [];

        $this->getChildren()->forAll(function (ElementInterface $child) use (&$values) {
            $values[$child->getName()] = $child->getValue();
        });

        return $values;
    }
}