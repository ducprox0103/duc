<?php
namespace Hancocks\Book\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Hancocks\Book\Model\BookFactory;
use Hancocks\Book\Model\CustomEmail;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_messageManager;
    protected $_bookFactory;
    protected $_customEmail;
    protected $_helperData;
    protected $_productRepository;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        BookFactory $bookFactory,
        CustomEmail $customEmail,
        \Hancocks\Book\Helper\Data $helperData,
        ProductRepositoryInterface $productRepository,
    ) {
        parent::__construct($context);
        $this->_messageManager = $messageManager;
        $this->_bookFactory = $bookFactory;
        $this->_customEmail = $customEmail;
        $this->_helperData = $helperData;
        $this->_productRepository = $productRepository;
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        try {
            if(isset($post['sku'])){
                $product = $this->loadProduct($post['sku']);
                $productName = $product->getName();
                $post['product_name'] = $productName;
            }
            if (!empty($post)) {
                $this->saveEnquiry($post);
                $this->sendEmail($post);
                $this->displaySuccessMessage();
                return $this->redirectToReferer();
            }
        } catch (\Exception $e) {
            $this->_messageManager->addErrorMessage('An error occurred: ' . $e->getMessage());
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
        }
    }

    protected function saveEnquiry($data)
    {
        $bookData = $this->_bookFactory->create();
        $bookData->setData($data);
        $bookData->save();
    }

    protected function sendEmail($data)
    {
        $email = $this->_helperData->getGeneralConfig('email_recipient');
        $name = "You";
        $templateId = 'email_template';
        $templateVars = $data;
        $this->_customEmail->sendCustomEmail($email, $name, $templateId, $templateVars);
    }

    protected function displaySuccessMessage()
    {
        $this->messageManager->addSuccessMessage('Email Confirmation is successfully sent');
    }

    protected function redirectToReferer()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
    }

    public function loadProduct($sku)
    {
        return $this->_productRepository->get($sku);
    }
}