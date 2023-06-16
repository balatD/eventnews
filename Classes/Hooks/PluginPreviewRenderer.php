<?php

namespace GeorgRinger\Eventnews\Hooks;

use TYPO3\CMS\Core\Localization\LanguageService;

/**
 * This file is part of the "eventnews" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Class PluginPreviewRenderer
 *
 */
class PluginPreviewRenderer
{
    protected const LLPATH = 'LLL:EXT:eventnews/Resources/Private/Language/locallang.xlf:';

    /**
     * Provide an extension summary for the month selection
     *
     * @param array $params
     * @param \GeorgRinger\News\Hooks\PluginPreviewRenderer $pluginPreview
     */
    public function extensionSummary(array $params, \GeorgRinger\News\Hooks\PluginPreviewRenderer $pluginPreview)
    {
        // @todo hook from EXT:news doesn't provide enough params to work with here
        if ($params['action'] === 'news_month') {
            $pluginPreview->getStartingPoint();
            $pluginPreview->getTimeRestrictionSetting();
            $pluginPreview->getTopNewsRestrictionSetting();
            $pluginPreview->getOrderSettings();
            $pluginPreview->getCategorySettings();
            $pluginPreview->getArchiveSettings();
            $pluginPreview->getOffsetLimitSettings();
            $pluginPreview->getDetailPidSetting();
            $pluginPreview->getListPidSetting();
            $pluginPreview->getTagRestrictionSetting();
            $this->getEventRestrictionSetting($pluginPreview);
        }
    }

    /**
     * Show the event restriction
     *
     * @param \GeorgRinger\News\Hooks\PluginPreviewRenderer $pluginPreview
     * @return void
     */
    protected function getEventRestrictionSetting(\GeorgRinger\News\Hooks\PluginPreviewRenderer $pluginPreview)
    {
        $eventRestriction = (int)$pluginPreview->getFieldFromFlexform('settings.eventRestriction');

        if ($eventRestriction > 0) {
            $pluginPreview->tableData[] = [
                $this->initializeLanguageService()->sL(
                    self::LLPATH .
                    'flexforms_general.eventRestriction'
                ),

                $this->initializeLanguageService()->sL(
                    self::LLPATH .
                    'flexforms_general.eventRestriction.' .
                    $eventRestriction
                )
            ];
        }
    }

    protected function initializeLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
