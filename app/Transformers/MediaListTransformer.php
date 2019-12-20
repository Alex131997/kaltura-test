<?php

namespace App\Transformers;

use Carbon\Carbon;
use Kaltura\Client\Type\MediaEntry;
use Kaltura\Client\Type\MediaListResponse;
use League\Fractal\TransformerAbstract;

class MediaListTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'objects',
    ];

    /**
     * A Fractal transformer.
     *
     * @param MediaListResponse $mediaEntry
     * @return array
     */
    public function transform(MediaListResponse $mediaEntry)
    {
        return [
            'totalCount' => $mediaEntry->totalCount,
        ];
    }

    /**
     * @param MediaListResponse $mediaEntry
     * @return \League\Fractal\Resource\Collection
     */
    public function includeObjects(MediaListResponse $mediaEntry)
    {
        return $this->collection($mediaEntry->objects, new MediaTransformer());
    }
}
