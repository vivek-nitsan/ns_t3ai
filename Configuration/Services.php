<?php

declare(strict_types=1);

use NITSAN\NsT3Ai\Backend\PageLayoutHeaderV12;
use NITSAN\NsT3Ai\Controller\T3AiController;
use NITSAN\NsT3Ai\Domain\Repository\PageRepository;
use NITSAN\NsT3Ai\Factory\CustomLanguageFactory;
use NITSAN\NsT3Ai\Helper\NsExtensionConfiguration;
use NITSAN\NsT3Ai\Service\Ai\T3AiCompletionGateway;
use NITSAN\NsT3Ai\Service\NsT3AiContentService;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();

    $services->load('NITSAN\\NsT3Ai\\', __DIR__ . '/../Classes/')
        ->exclude([
            __DIR__ . '/../Classes/Domain/Model',
        ]);

    $services->set('ExtConf.nsT3ai', 'array')
        ->factory([new ReferenceConfigurator(ExtensionConfiguration::class), 'get'])
        ->args(['ns_t3ai']);

    $services->set('CustomLanguageArray', 'array')
        ->factory([new ReferenceConfigurator(CustomLanguageFactory::class), 'getCustomLanguages']);

    $containerBuilder->register('Logger', LoggerInterface::class);
    $services->set('PsrLogInterface', 'Logger')
        ->factory([
            new ReferenceConfigurator(LogManager::class), 'getLogger',
        ]);

    $services->set(T3AiCompletionGateway::class)
        ->autowire()
        ->public();

    $services->set(NsT3AiContentService::class)
        ->arg('$languages', new ReferenceConfigurator('CustomLanguageArray'))
        ->arg('$extConf', new ReferenceConfigurator('ExtConf.nsT3ai'))
        ->arg('$uriBuilder', new ReferenceConfigurator(UriBuilder::class))
        ->arg('$completionGateway', new ReferenceConfigurator(T3AiCompletionGateway::class));

    $services->set(T3AiController::class)
        ->arg('$contentService', new ReferenceConfigurator(NsT3AiContentService::class))
        ->arg('$logger', new ReferenceConfigurator('PsrLogInterface'))
        ->arg('$pageRepository', new ReferenceConfigurator(PageRepository::class))
        ->public();

    $services->set(NsExtensionConfiguration::class)
        ->public();

    $services->set(PageLayoutHeaderV12::class)
        ->arg('$extensionConfiguration', new ReferenceConfigurator(NsExtensionConfiguration::class))
        ->arg('$pageRepository', new ReferenceConfigurator(PageRepository::class))
        ->arg('$pageRenderer', new ReferenceConfigurator(PageRenderer::class))
        ->public();
};