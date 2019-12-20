<?php

namespace App\Services;

use App\Exceptions\ApiException;
use Kaltura\Client\Configuration as KalturaConfiguration;
use Kaltura\Client\Client as KalturaClient;
use Kaltura\Client\Enum\SessionType as KalturaSessionType;
use Kaltura\Client\Type\FilterPager;
use Kaltura\Client\Type\MediaEntryFilter;
use Kaltura\Client\Type\MediaListResponse;

class Kaltura
{
    const MEDIA_PER_PAGE = 10;

    protected $config;
    protected $client;

    public function __construct()
    {
        $this->config = new KalturaConfiguration();
        $this->client = new KalturaClient($this->config);
    }

    /**
     * @return KalturaClient
     */
    protected function startSession()
    {
        if (is_null($this->client->getKs())) {
            $ks = $this->client->session->start(
                env('KALTURA_ADMIN_SECRET'),
                env('KALTURA_UNIQUE_USER_ID'),
                KalturaSessionType::ADMIN,
                env('KALTURA_PARTNER_ID'));
            $this->client->setKS($ks);
        }

        return $this->client;
    }

    /**
     * @param null $filter
     * @param null $pager
     * @return MediaListResponse
     * @throws ApiException
     */
    public function getMediaObjects($filter = null, $pager = null)
    {
        $client = $this->startSession();

        try {
            $mediaObjects = $client->getMediaService()->listAction($filter, $pager);
        } catch (\Exception $exception) {
            throw new ApiException($exception->getMessage(), 400);
        }

        return $mediaObjects;
    }

    public function makeFilterObject($orderBy = null, $search = null)
    {
        switch ($orderBy) {
            case 'createdAtUp':
                $orderBy = '-createdAt';
                break;
            case 'createdAtDown':
                $orderBy = '+createdAt';
                break;
            default:
                $orderBy = null;
        }

        $mediaFilter = new MediaEntryFilter();

        if (!is_null($orderBy)) {
            $mediaFilter->orderBy = $orderBy;
        }
        if (!is_null($search)) {
            $mediaFilter->freeText = $search;
        }

        return $mediaFilter;
    }

    /**
     * @param int $page
     * @return FilterPager
     */
    public function makePagerObject(int $page)
    {
        $filterPager = new FilterPager();
        $filterPager->pageIndex = $page;
        $filterPager->pageSize = self::MEDIA_PER_PAGE;

        return $filterPager;
    }

    /**
     * @param $id
     * @return void
     * @throws ApiException
     */
    public function deleteMediaObject($id)
    {
        $client = $this->startSession();

        try {
            $mediaObjects = $client->getMediaService()->delete($id);
        } catch (\Exception $exception) {
            throw new ApiException($exception->getMessage(), 400);
        }
    }

    public function getCountMediaObjects()
    {
        $client = $this->startSession();

        try {
            $count = $client->getMediaService()->count();
        } catch (\Exception $exception) {
            throw new ApiException($exception->getMessage(), 400);
        }

        return $count;
    }
}
