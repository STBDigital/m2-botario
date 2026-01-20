<?php
declare(strict_types=1);

namespace STBDigital\Botario\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_ENABLED = 'botario/general/enabled';
    private const XML_PATH_BOT_ID = 'botario/general/bot_id';
    private const XML_PATH_API_URL = 'botario/general/api_url';
    private const XML_PATH_JS_MODULE_URL = 'botario/general/js_module_url';
    private const XML_PATH_DENY_HANDLES = 'botario/general/deny_handles';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {}

    public function isEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getBotId(?int $storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_BOT_ID, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getApiUrl(?int $storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_API_URL, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getJsModuleUrl(?int $storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_JS_MODULE_URL, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getDenyHandles(?int $storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_DENY_HANDLES, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }
    /**
     * @return string[]
     */
    public function getDenyHandlesList(?int $storeId = null): array
    {
        $raw = $this->getDenyHandles($storeId);

        // Split by newline or comma, trim, remove empties, unique.
        $parts = preg_split('/[\r\n,]+/', $raw) ?: [];
        $parts = array_map('trim', $parts);
        $parts = array_filter($parts, static fn($v) => $v !== '');
        $parts = array_values(array_unique($parts));

        return $parts;
    }

}
