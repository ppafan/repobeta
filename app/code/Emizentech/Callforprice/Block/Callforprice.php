<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Emizentech\Callforprice\Block;

/**
 * Product price block
 */
class Callforprice extends \Magento\Catalog\Pricing\Render\FinalPriceBox 
{
  
     /**
     * Wrap with standard required container
     *
     * @param string $html
     * @return string
     */
    public function wrapResult($html)
    {
   		if($this->getSaleableItem()->getCallforpriceText()==''):
          return '<div class="price-box ' . $this->getData('css_classes') . '" ' .
            'data-role="priceBox" ' .
            'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
            '>' . $html . '</div>';
       else :
       	//return '<div class="price-box "><span>'.$this->getSaleableItem()->getCallforpriceText().'</span></div>';
		$button =  '<div class="price-box ' . $this->getData('css_classes') . '" ' .
            'data-role="priceBox" ' .
            'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
            '>' . $html . '</div>';

          // if($this->getSaleableItem()->getCallforpriceText()== "Inquire"){
            // $button2 =   '<div class="product-inquire"><a class="link-inquire-car" href="/inquiry?id=' . $this->getSaleableItem()->getId() . '">'.$this->getSaleableItem()->getCallforpriceText().'</a></div>';
          // }else if($this->getSaleableItem()->getCallforpriceText()== "BOOK A CAR"){
            // $button2 = '<div class="product-inquire"><a class="link-inquire-car" href="/inquiry/index/rentals?id=' . $this->getSaleableItem()->getId() . '">'.$this->getSaleableItem()->getCallforpriceText().'</a></div>';
          // }
			
       
      //return $button.$button2;
	  return $button;
       endif;

    }
    
}
