<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\TagsRequest;
use App\Http\Requests\Tags\TagsUpdateRequest;
use App\Http\Resources\TagsResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index() : \Illuminate\Http\Response
    {
        $news = Tag::latest('name')->get();
        return response([
            'ok'        => true,
            'message'   => 'Tags get successfully',
            'data'      => TagsResource::collection($news)
        ],200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagsRequest $request
     */
    public function store(TagsRequest $request) : \Illuminate\Http\Response
    {
        $tags = Tag::create($request->all());
        return response([
            'ok'        => true,
            'message'   => 'Tags get successfully',
            'data'      => TagsResource::make($tags)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param Tag $tag
     */
    public function show(Tag $tag): \Illuminate\Http\Response
    {
        return response([
            'ok'        => true,
            'message'   => 'Tags get successfully',
            'data'      => TagsResource::make($tag)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagsUpdateRequest $request
     * @param Tag $tag
     */
    public function update(TagsUpdateRequest $request, Tag $tag): \Illuminate\Http\Response
    {
        $tag->update($request->all());
        return response([
            'ok'        => true,
            'message'   => 'Tags update successfully',
            'data'      => TagsResource::make($tag->fresh())
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @throws \Exception
     */
    public function destroy(Tag $tag): \Illuminate\Http\Response
    {
        $tag->delete();
        return response(null,204);
    }
}
