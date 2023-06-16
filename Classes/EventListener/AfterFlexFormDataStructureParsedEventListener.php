<?php

namespace GeorgRinger\Eventnews\EventListener;

/**
 * This file is part of the "eventnews" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AfterFlexFormDataStructureParsedEventListener
{
    public function __invoke(AfterFlexFormDataStructureParsedEvent $event): void
    {
        $identifier = $event->getIdentifier();

        if (
            $identifier['type'] === 'tca' &&
            $identifier['tableName'] === 'tt_content' &&
            $identifier['dataStructureKey'] === '*,news_pi1'
        ) {
            $file = ExtensionManagementUtility::extPath('eventnews') .
                'Configuration/Flexforms/flexform_eventnews.xml';

            $content = file_get_contents($file);
            $flexform = GeneralUtility::xml2array($content);

            $event->setDataStructure(array_merge_recursive($event->getDataStructure(), $flexform));
        }
    }
}
