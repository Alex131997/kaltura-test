<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class SuccessTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param bool $success
     *
     * @return array
     */
    public function transform(bool $success)
    {
        return [
            'success' => $success
        ];
    }
}
