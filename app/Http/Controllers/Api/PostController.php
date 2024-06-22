<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API de Posts",
 *     version="1.0.0",
 *     description="API para gerenciar posts"
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Listar todos os posts",
     *     tags={"Posts"}, 
     *     @OA\Response(
     *         response=200,
     *         description="Lista de posts"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Post::all());
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{post}",
     *     summary="Obter um post específico",
     *     tags={"Posts"}, 
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do post"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post não encontrado"
     *     )
     * )
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Criar um novo post",
     *     tags={"Posts"}, 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Título do post"),
     *             @OA\Property(property="content", type="string", example="Conteúdo do post")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post criado"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::create($validatedData);
        return response()->json($post, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{post}",
     *     summary="Atualizar um post",
     *     tags={"Posts"}, 
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Título atualizado"),
     *             @OA\Property(property="content", type="string", example="Conteúdo atualizado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post atualizado"
     *     )
     * )
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($validatedData);
        return response()->json($post);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{post}",
     *     summary="Excluir um post",
     *     tags={"Posts"}, 
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post excluído"
     *     )
     * )
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
