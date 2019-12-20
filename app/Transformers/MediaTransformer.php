<?php

namespace App\Transformers;

use Carbon\Carbon;
use Kaltura\Client\Type\MediaEntry;
use League\Fractal\TransformerAbstract;

class MediaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param MediaEntry $mediaEntry
     * @return array
     */
    public function transform(MediaEntry $mediaEntry)
    {
        return [
            'id' => $mediaEntry->id,
            'name' => $mediaEntry->name,
            'description' => $mediaEntry->description,
            'tags' => $mediaEntry->tags,
            'categories' => $mediaEntry->categories,
            'mediaType' => $mediaEntry->mediaType,
            'status' => $mediaEntry->status,
            'created_at' => Carbon::parse($mediaEntry->createdAt)->format('d-m-Y'),
            'updated_at' => Carbon::parse($mediaEntry->updatedAt)->format('d-m-Y'),
            'download_link' => $mediaEntry->downloadUrl,
            'link' => $mediaEntry->dataUrl,
            'thumbnai_link' => $mediaEntry->thumbnailUrl,
        ];
    }
}
