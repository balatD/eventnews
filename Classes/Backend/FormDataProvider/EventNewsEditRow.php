<?php

declare(strict_types=1);

namespace GeorgRinger\Eventnews\Backend\FormDataProvider;

/**
 * This file is part of the "eventnews" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Remove rendered field from output if it is no event
 */
class EventNewsEditRow implements FormDataProviderInterface
{

    protected const FIELDS = 'full_day,event_end,organizer,organizer_simple,location,location_simple';

    /**
     * @param array $result
     * @return array
     */
    public function addData(array $result): array
    {
        if ($result['command'] !== 'edit' ||
            $result['tableName'] !== 'tx_news_domain_model_news' ||
            $result['databaseRow']['is_event'] === 1
        ) {
            return $result;
        }

        if ($result['databaseRow']['is_event'] === 0) {
            foreach ($result['databaseRow'] as &$field) {
                if (GeneralUtility::inList(self::FIELDS, $field)) {
                    $field = '';
                }
            }
        }

        return $result;
    }
}
