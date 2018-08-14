<?php
namespace Autosupplyph\Categories\Block;
class CategoriesCollection extends \Magento\Framework\View\Element\Template
{
	protected $_itemCollectionFactory;
	protected $_request;
	protected $_categoryFactory;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesCollection,
		\Magento\Catalog\Model\CategoryFactory  $categoryFactory,
		\Magento\Framework\App\Request\Http $request,
		array $data = []
	) {
		$this->_itemCollectionFactory = $categoriesCollection;
		$this->_categoryFactory = $categoryFactory;
		$this->_request = $request;
		parent::__construct($context, $data);
	}
	public function getContent()
	{
		return __("Popular Category");
	}
	public function getMainCategories()
	{
		$categoryFactory = $this->_itemCollectionFactory->create()
							->addAttributeToSelect('*');
		return $categoryFactory;
	}

	public function getSubCategoryList($category)
	{
		$collection = $this->_categoryFactory->create()->getCollection()->addAttributeToSelect('*')
			  ->addAttributeToFilter('is_active', 1)
			  ->setOrder('position', 'ASC')
			  ->addIdFilter($category->getChildren());
		return $collection;
	}
}