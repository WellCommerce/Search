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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Optioned;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractField;

/**
 * Class AbstractOptionedField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractOptionedField extends AbstractField
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'options'
        ]);

        $resolver->setDefined([
            'suffix',
            'prefix',
        ]);

        $resolver->setDefaults([
            'options' => [],
        ]);

        $resolver->setAllowedTypes([
            'options' => 'array',
            'suffix'  => 'string',
            'prefix'  => 'string',
        ]);
    }

    /**
     * Adds new option to select
     *
     * @param $value
     * @param $label
     */
    public function addOptionToSelect($value, $label)
    {
        $this->options['options'][$value] = $label;
    }

    /**
     * Returns options
     *
     * @return array
     */
    protected function getSelectOptions()
    {
        return $this->options['options'];
    }

    /**
     * Formats field options as javascript
     *
     * @return string
     */
    protected function prepareOptions()
    {
        $options = [];
        foreach ($this->getSelectOptions() as $value => $label) {
            $value     = addslashes($value);
            $label     = addslashes($label);
            $options[] = [
                'sValue' => $value,
                'sLabel' => $label
            ];
        }

        return $options;
    }

    public function prepareAttributes()
    {
        return parent::prepareAttributes() + [
            'aoOptions' => $this->prepareOptions()
        ];
    }
}
