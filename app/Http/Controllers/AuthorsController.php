<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\authorlogin;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Authorregister;
   /**
     * @SWG\Get(
     *   path="/api/testing/{mytest}",
     *   summary="Get Testing",
     *   operationId="testing",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="mytest",
     *          in="path",
     *          required=true, 
     *          type="string" 
     *      ),
     * )
     *
     */
class AuthorsController extends Controller
{
  
    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(StoreAuthorRequest $request)
    {
       return Authorregister::create($request->all());
    }

    public function show(Authorregister $author)
    {
        return $author->all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(authorlogin $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAuthorRequest  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAuthorRequest $request, $id)
    {
        $authors= Authorregister::find($id);
        $authors->update($request->all());
        return $authors;
    }

    /**
     * Remove the specified resource from storage.
     *+++++++++++++++++++++++++
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(authorlogin $author)
    {
        //
    }
}
