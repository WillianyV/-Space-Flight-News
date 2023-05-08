<?php

namespace App\Http\Controllers;

use App\Models\Article;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $article;

    public function __construct(Article $article) {
        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->article->with(['launches','events'])->paginate(15);
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->article->rules());

        $data = $request->all();

        $image = $request->file('imageUrl');
        $imageUrl = $image->store('image/articles', 'public');
        $data['imageUrl'] = $imageUrl;

        $article = $this->article->create($data);

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = $this->article->with(['launches','events'])->find($id);
        if($article === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        }

        return response()->json($article, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = $this->article->find($id);

        if($article === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        $request->validate($article->rules());
        $data = $request->all();

        //remove a imagem antiga caso uma nova imagem tenha sido enviado no request
        if($request->file('imageUrl')) {
            Storage::disk('public')->delete($article->imageUrl);
        }

        $image = $request->file('imageUrl');
        $imageUrl = $image->store('image/articles', 'public');
        $data['imageUrl'] = $imageUrl;

        $article->update($data);

        return response()->json($article, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = $this->article->find($id);

        if($article === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        $article->delete();
        return response()->json(['msg' => 'O artigo foi removido com sucesso!'], 200);
    }
}
