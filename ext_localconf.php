<?php

declare(strict_types=1);

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['nst3ai'] =
    'EXT:ns_t3ai/Configuration/RTE/Pluginv12.yaml';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ns_t3af']['licenseDependentExtensions'] ??= [];
if (!in_array('ns_t3ai', $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ns_t3af']['licenseDependentExtensions'], true)) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ns_t3af']['licenseDependentExtensions'][] = 'ns_t3ai';
}
