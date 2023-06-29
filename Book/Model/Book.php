<?php

namespace Hancocks\Book\Model;

class Book extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'hancocks_book';

    protected $_cacheTag = 'hancocks_book';

    protected $_eventPrefix = 'hancocks_book';

    protected function _construct()
    {
        $this->_init('Hancocks\Book\Model\ResourceModel\Book');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
