<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ExceptionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param \Exception $exception
     *
     * @return array
     */
    public function transform(\Exception $exception)
    {
        return [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];
    }
}
