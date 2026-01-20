<?php
declare(strict_types=1);

namespace STBDigital\Botario\Block;

use Magento\Framework\View\Element\Template;
use STBDigital\Botario\Model\Config;

class Widget extends Template
{
    // Keep comments in English as requested.
    public function __construct(
        Template\Context $context,
        private readonly Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function isEnabled(): bool
    {
        return $this->config->isEnabled((int)$this->_storeManager->getStore()->getId());
    }

    public function getBotId(): string
    {
        return $this->config->getBotId((int)$this->_storeManager->getStore()->getId());
    }

    public function getApiUrl(): string
    {
        return $this->config->getApiUrl((int)$this->_storeManager->getStore()->getId());
    }

    public function getJsModuleUrl(): string
    {
        return $this->config->getJsModuleUrl((int)$this->_storeManager->getStore()->getId());
    }// Keep comments in English as requested.

    public function isDeniedByHandle(): bool
    {
        $storeId = (int)$this->_storeManager->getStore()->getId();
        $deny = $this->config->getDenyHandlesList($storeId);

        if ($deny === []) {
            return false;
        }

        $fullAction = (string)$this->getRequest()->getFullActionName();
        return in_array($fullAction, $deny, true);
    }
}
