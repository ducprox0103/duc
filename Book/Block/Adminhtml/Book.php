<?php
namespace Hancocks\Book\Block\Adminhtml;

class Book extends \Magento\Backend\Block\Widget\Grid\Container
{

	protected function _construct()
	{
		$this->_controller = 'adminhtml_book';
		$this->_blockGroup = 'Hancocks_Book';
		$this->_headerText = __('Books');
		$this->_addButtonLabel = __('Create New Book');
		parent::_construct();   
	}

	protected function _addNewButton()
    {
        
    }
}