<?php
/**
 * Slider list block
 * 
 * @author Activated
 */

class Activated_Slider_Block_Slider extends Mage_Core_Block_Template
{
	/**
	 * Slider id
	 */
	protected $_id = null;
	
	/**
	 * Slide collection
	 */
	protected $_sliderCollection = null;
	
	/**
	 * Banner collection
	 */
	protected $_bannerCollection = null;
	
	/**
	 * Retrieve slide collection
	 */
	protected function _getCollection()
	{
		return Mage::getModel('slider/slider')->getCollection();
	}
	
	protected function _toHtml()
	{
		if (Mage::helper('slider')->isEnabled()) {
			$html = parent::_toHtml();
			$this->setId($this->getSliderId());
			return $html;
		}
	}
	
	/**
	 * Retrieve prepared sliders collection
	 */
	public function getCollection()
	{
		if (is_null($this->_sliderCollection)) {
			$this->_sliderCollection = $this->_getCollection();
		}
		
		return $this->_sliderCollection;
	}
	
	public function _getBanners()
	{
		return Mage::getModel('slider/banner')->getCollection();
	}
	
	/**
	 * Retrieve prepared associated banners
	 */
	public function getBanners()
	{
		$sliderId = $this->getSliderId();
		
		// Check for block tag slider id
		if ($sliderId) {
			$this->setId($sliderId);
		}
		
		if (is_null($this->_bannerCollection)) {
			$this->_bannerCollection = $this->_getBanners();
			$this->_bannerCollection->getSelect()
					->join('activated_reference',
						'main_table.banner_id = activated_reference.banner_id and activated_reference.slider_id = "' . $this->_id . '"'
					)
					->order('position');
		}
		return $this->_bannerCollection;
	}
	
	/**
	 * Return URL for resized slider item image
	 * 
	 * @param Activated_Sliders_Model_Sliders $item
	 * @param integer $width
	 * @retun string|false
	 */
	public function getImageUrl($item, $width)
	{
		return Mage::helper('slider/image')->resize($item, $width);
	}
	
	/**
	 * Set slider id
	 * 
	 * @return int
	 */
	public function setId($id) {
		$this->_id = $id;
		return $this;
	}
	
	/**
	 * Get slider id
	 * 
	 * @return int
	 */
	public function getId() {
		return $this->_id;
	}
}