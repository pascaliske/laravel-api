<?php

namespace App\Api\Controllers;

use App\Api\Models\Page;
use App\Api\Traits\Restriction;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use Helpers, Restriction;

    public function __construct()
    {
        $this->restrict('can:read-page', ['fetch', 'fetchAll']);
        $this->restrict('can:create-page', ['create']);
        $this->restrict('can:update-page', ['update']);
        $this->restrict('can:delete-page', ['delete']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        return Page::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchAll()
    {
        return Page::all();
    }

    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Page::create([
            'title' => $request->title,
            'description' => $request->description,
            'path' => $request->path,
            'fields' => $request->fields,
            'author' => $request->author,
            'published' => $request->published ? true : false,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->updateModel(Page::findOrFail($id), [
            'title' => $request->title,
            'description' => $request->description,
            'path' => $request->path,
            'fields' => $request->fields,
            'author' => $request->author,
            'published' => $request->published ? true : false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Page::findOrFail($id)->delete();
    }
}
