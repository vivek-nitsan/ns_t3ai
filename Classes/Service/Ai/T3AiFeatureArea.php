<?php

declare(strict_types=1);

namespace NITSAN\NsT3Ai\Service\Ai;

enum T3AiFeatureArea: string
{
    case Seo = 'seo';
    case Content = 'content';

    public function extConfFieldName(): string
    {
        return match ($this) {
            self::Seo => 'defaultProviderForSeo',
            self::Content => 'defaultProviderForContent',
        };
    }

    public static function fromFeatureKey(string $featureKey): ?self
    {
        if (str_starts_with($featureKey, 'seo.')) {
            return self::Seo;
        }
        if (
            str_starts_with($featureKey, 'rte.')
            || str_starts_with($featureKey, 'content.')
            || $featureKey === 'content_generate'
        ) {
            return self::Content;
        }

        return null;
    }
}
