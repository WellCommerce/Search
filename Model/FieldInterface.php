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

namespace WellCommerce\Component\Search\Model;

/**
 * Interface FieldInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FieldInterface
{
    public function getName(): string;
    
    public function getValue();
    
    public function setValue($value);
    
    public function isIndexable(): bool;
    
    public function getBoost(): float;
    
    public function getFuzziness(): float;
    
    public function getValueExpression(): string;
    
    public function getAdvancedOptions(): array;
}
