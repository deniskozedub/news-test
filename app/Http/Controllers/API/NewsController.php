<?php

namespace App\Http\Controllers\API;

use App\Filters\Tags;
use App\Http\Controllers\Controller;
use App\Http\Requests\News\NewsRequest;
use App\Http\Requests\News\NewsUpdateRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Pipeline\Pipeline;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index() : \Illuminate\Http\Response
    {
        $news = News::withFiltersOrNot();
        return response([
            'ok'        => true,
            'message'   => 'News get successfully',
            'data'      => NewsResource::collection($news)
        ],200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     */
    public function store(NewsRequest $request) : \Illuminate\Http\Response
    {
        $news = News::create($request->all());
        $news->tagService($request->get('tags'));
        return response([
            'ok'        => true,
            'message'   => 'News create successfully',
            'data'      => NewsResource::make($news)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     */
    public function show(News $news) :  \Illuminate\Http\Response
    {
        $news->newsCounter();
        return response([
            'ok'        => true,
            'message'   => 'News get successfully',
            'data'      => NewsResource::make($news)
        ],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param NewsUpdateRequest $request
     * @param News $news
     */
    public function update(NewsUpdateRequest $request, News $news): \Illuminate\Http\Response
    {
        $news->update($request->all());
        $news->tagService($request->get('tags') ?? '');
        return response([
            'ok'        => true,
            'message'   => 'News update successfully',
            'data'      => NewsResource::make($news->fresh())
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @throws \Exception
     */
    public function destroy(News $news) : \Illuminate\Http\Response
    {
        $news->delete();
        return response(null,204);
    }
}
