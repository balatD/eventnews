<?php

defined('TYPO3') or die();

// Add new controller/action
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->month']
    = 'Month view';

/***********
 * Hooks
 */

// Hide not needed fields in FormEngine
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\GeorgRinger\Eventnews\Backend\FormDataProvider\EventNewsEditRow::class] = [
    'depends' => [
        \TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseEditRow::class,
    ]
];

// Extending plugin preview in Web->Page module
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news'][\GeorgRinger\News\Hooks\PluginPreviewRenderer::class]['extensionSummary']['eventnews']
    = \GeorgRinger\Eventnews\Hooks\PluginPreviewRenderer::class . '->extensionSummary';

// Extend the query
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded']['eventnews']
    = \GeorgRinger\Eventnews\Hooks\AbstractDemandedRepository::class . '->modify';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\GeorgRinger\Eventnews\Backend\FormDataProvider\EventNewsRowInitializeNew::class] = [
    'depends' => [
        \TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew::class,
    ]
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['eventnews'] =
    \GeorgRinger\Eventnews\Hooks\Backend\EventNewsDataHandlerHook::class;

/***********
 * Extend EXT:news
 */
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Domain/Model/News'][] = 'eventnews';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Controller/NewsController'][] = 'eventnews';

// override language files of news
$overrideModuleLabel = (bool)\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('eventnews', 'overrideAdministrationModuleLabel');
if ($overrideModuleLabel) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['default']['EXT:news/Resources/Private/Language/locallang_modadministration.xlf'][] = 'EXT:eventnews/Resources/Private/Language/Overrides/locallang_modadministration.xlf';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['de']['EXT:news/Resources/Private/Language/locallang_modadministration.xlf'][] = 'EXT:eventnews/Resources/Private/Language/Overrides/de.locallang_modadministration.xlf';
}

if (TYPO3 === 'BE') {
    $icons = [
        'ext-news-type-event' => 'news_domain_model_news_event.svg',
    ];
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($icons as $identifier => $path) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:eventnews/Resources/Public/Icons/' . $path]
        );
    }
}
