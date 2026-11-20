<?php

$EM_CONF['ns_t3ai'] = [
    'title' => 'T3AI Free – TYPO3 AI (AI Foundation)',
    'description' => 'Free T3AI: SEO page-title suggestions and RTE AI generate/rewrite via AI Foundation (ns_t3af). Configure providers in AF, then use page title + RTE. Upgrade to Pro for the full product. Live demo & docs: https://t3planet.com/t3ai-typo3-extension',
    'category' => 'be',
    'author' => 'Team T3Planet',
    'author_email' => 'info@t3planet.de',
    'author_company' => 'T3Planet',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '15.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.9.99',
            'ns_t3af' => '2.0.0-2.99.99',
            'ns_license' => '14.5.0-14.9.99',
            'rte_ckeditor' => '13.4.0-14.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
