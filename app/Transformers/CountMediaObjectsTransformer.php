<?php

namespace App\Transformers;

use Carbon\Carbon;
use Kaltura\Client\Type\MediaEntry;
use League\Fractal\TransformerAbstract;

class CountMediaObjectsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param int $count
     * @return array
     */
    public function transform(int $count)
    {
        return [
            'count' => $count,
        ];
    }
}
