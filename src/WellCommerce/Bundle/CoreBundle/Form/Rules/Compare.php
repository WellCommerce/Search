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

namespace WellCommerce\Bundle\CoreBundle\Form\Rules;

use WellCommerce\Bundle\CoreBundle\Form\Elements\Field;
use WellCommerce\Bundle\CoreBundle\Form\Rule;

/**
 * Class Compare
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Rules
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Compare extends Rule implements RuleInterface
{
    protected $_compareWith;

    public function __construct($errorMsg, Field $compareWith)
    {
        parent::__construct($errorMsg);
        $this->_compareWith = $compareWith;
    }

    public function checkValue($value)
    {
        return ($value == $this->_compareWith->getValue());
    }

    public function render()
    {
        $errorMsg = addslashes($this->_errorMsg);
        $field    = addslashes($this->_compareWith->getName());

        return "{sType: '{$this->getType()}', sErrorMessage: '{$errorMsg}', sFieldToCompare: '{$field}'}";
    }

}
