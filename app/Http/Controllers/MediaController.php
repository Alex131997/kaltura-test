<?php

namespace App\Http\Controllers;

use App\Facades\Kaltura;
use App\Http\Requests\DeleteMediaRequest;
use App\Http\Requests\MediaListRequest;
use App\Transformers\CountMediaObjectsTransformer;
use App\Transformers\MediaListTransformer;
use App\Transformers\SuccessTransformer;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        return view('media');
    }

    public function list(MediaListRequest $request)
    {
        $mediaFilter = Kaltura::makeFilterObject($request->orderBy, $request->search);
        $pagerFilter = Kaltura::makePagerObject($request->page);

        $mediaListResponse = Kaltura::getMediaObjects($mediaFilter, $pagerFilter);

        return fractal($mediaListResponse, MediaListTransformer::class);
    }

    public function delete(DeleteMediaRequest $request, $id)
    {
        Kaltura::deleteMediaObject($id);

        return fractal(true, SuccessTransformer::class);
    }

    public function count()
    {
        $count = Kaltura::getCountMediaObjects();

        return fractal($count, CountMediaObjectsTransformer::class);
    }
}
