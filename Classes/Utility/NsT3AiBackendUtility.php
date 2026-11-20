<?php

declare(strict_types=1);

namespace NITSAN\NsT3Ai\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Free backend helpers. AI credentials live in ns_t3af — not here.
 */
class NsT3AiBackendUtility
{
    public static function isAiFoundationAvailable(): bool
    {
        return ExtensionManagementUtility::isLoaded('ns_t3af');
    }

    /**
     * @deprecated since 15.0.0 — OpenAI key removed; use isAiFoundationAvailable()
     */
    public static function isApiKeySet(): bool
    {
        return self::isAiFoundationAvailable();
    }

    /**
     * @deprecated since 15.0.0 — always empty; providers are in AI Foundation
     */
    public static function getApiKey(): string
    {
        return '';
    }
}
