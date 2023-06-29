<?php
namespace Hancocks\Book\Controller\Adminhtml\Book;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Hancocks\Book\Model\ResourceModel\Book\CollectionFactory;

class MassDelete extends Action
{
    protected $_collectionFactory;

    protected $_filter;

    protected $_bookFactory;


    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Hancocks\Book\Model\BookFactory $bookFactory
    ) {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_bookFactory = $bookFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $ids = $this->getRequest()->getParam('ids');
            $bookCollection = $this->_collectionFactory->create();
            $bookCollection->addFieldToFilter('book_id', ['in' => $ids]);
            $count = 0;

            foreach ($bookCollection as $book) {
                $book->delete();
                $count++;
            }
            
            $this->messageManager->addSuccess(__('A total of %1 book(s) have been deleted.', $count));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Hancocks_Book::delete');
    }
}