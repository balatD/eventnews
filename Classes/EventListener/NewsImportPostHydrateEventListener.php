<?php

namespace GeorgRinger\Eventnews\EventListener;

/**
 * This file is part of the "eventnews" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use GeorgRinger\News\Event\NewsImportPostHydrateEvent;

class NewsImportPostHydrateEventListener
{
    public function __invoke(NewsImportPostHydrateEvent $event): void
    {
        /** @var \GeorgRinger\Eventnews\Domain\Model\News $news */
        if (is_array($event->getImportItem()['_dynamicData'])) {
            if (isset($event->getImportItem()['_dynamicData']['location'])) {
                $event->getNews()->setLocationSimple(trim($event->getImportItem()['_dynamicData']['location']));
            }
            if (!empty($event->getImportItem()['_dynamicData']['datetime_end'])) {
                $date = new \DateTime();
                $date->setTimestamp($event->getImportItem()['_dynamicData']['datetime_end']);
                $event->getNews()->setEventEnd($date);
            }
        }
    }
}
