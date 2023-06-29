<?php
namespace Hancocks\Book\Model\ResourceModel\Book;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'book_id';
	protected $_eventPrefix = 'hancocks_book_collection';
	protected $_eventObject = 'book_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Hancocks\Book\Model\Book', 'Hancocks\Book\Model\ResourceModel\Book');
	}

}