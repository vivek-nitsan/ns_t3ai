<?php

declare(strict_types=1);

namespace NITSAN\NsT3Ai\Service\Ai;

use NITSAN\NsT3AF\Api\AiOptions;
use NITSAN\NsT3AF\Api\AiServiceInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

/**
 * Slim Free façade over {@see AiServiceInterface}.
 *
 * Providers and API keys live in AI Foundation — not in Free extension settings.
 */
final class T3AiCompletionGateway
{
    private const EXTENSION_KEY = 'ns_t3ai';

    public function __construct(
        private readonly AiServiceInterface $aiService,
        private readonly ExtensionConfiguration $extensionConfiguration,
    ) {}

    public function completeUserPrompt(
        string $userPrompt,
        string $featureKey,
        string $requestSource = 'backend_module',
        ?string $featureLabel = null,
    ): string {
        $options = new AiOptions(
            providerIdentifier: $this->resolveProviderIdentifier($featureKey),
            extensionKey: self::EXTENSION_KEY,
            featureKey: $featureKey,
            featureLabel: $featureLabel,
            requestSource: $requestSource,
            extra: [
                'messages' => [
                    ['role' => 'user', 'content' => $userPrompt],
                ],
            ],
        );

        $content = trim($this->aiService->complete($userPrompt, $options)->content);
        if ($content === '') {
            throw new \RuntimeException(
                'AI Foundation returned an empty response. Configure and test a provider in AI Foundation.',
                1737050005,
            );
        }

        return $content;
    }

    private function resolveProviderIdentifier(string $featureKey): ?string
    {
        $area = T3AiFeatureArea::fromFeatureKey($featureKey);
        if ($area === null) {
            return null;
        }

        try {
            $extConf = $this->extensionConfiguration->get(self::EXTENSION_KEY);
        } catch (\Throwable) {
            return null;
        }

        if (!is_array($extConf)) {
            return null;
        }

        $value = trim((string) ($extConf[$area->extConfFieldName()] ?? 'default'));
        if ($value === '' || strtolower($value) === 'default') {
            return null;
        }

        return $value;
    }
}
