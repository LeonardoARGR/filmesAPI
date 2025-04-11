<?php

namespace App\Http\Controllers;

use App\Models\FilmeApi;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FilmeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buscando todos os filmes
        $registros = FilmeApi::All();

        // Contador de filmes
        $contador = $registros->count();

        // Verificando se há filmes cadastrados
        if($contador > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Filmes encontrados com sucesso!',
                'data' => $registros,
                'total' => $contador
            ], 200); // Retorna HTTP 200 (OK) com os dados e a contagem
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum filme encontrado'
            ], 400);  // Retorna HTTP 404 (Not Found) se não houver registros
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica se o usuário colocou cada registro da forma correta
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'genero' => 'required',
            'ano_lancamento' => 'required'
        ]);

        // Caso contrário, retorna um erro
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400); 
        }

        // Cadastra o registro na tabela
        $registros = FilmeApi::create($request->all());

        // Verifica se a criação foi um sucesso
        if($registros) {
            return response()->json([
                'success' => true,
                'message' => 'Filme cadastrado com sucesso!',
                'data' => $registros
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar o filme'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Procura um filme de acordo com o ID informado pelo usuário
        $registros = FilmeApi::find($id);

        if($registros) {
            return response()->json([
                'success' => true,
                'message' => 'Filme localizado com sucesso!',
                'data' => $registros
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum filme encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        // Verifica se o usuário colocou cada registro da forma correta
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'genero' => 'required',
            'ano_lancamento' => 'required'
        ]);

        // Caso contrário, retorna um erro
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400); 
        }

        // Procura o filme com o ID informado
        $registros = FilmeApi::find($id);

        // Caso não seja encontrado, retorna um erro
        if(!$registros) {
            return response()->json([
                'success' => false,
                'message' => 'Filme não encontrado'
            ], 404);
        }

        // Faz a alteração dos registros
        $registros->nome = $request->nome;
        $registros->genero = $request->genero;
        $registros->ano_lancamento = $request->ano_lancamento;

        // Tenta atualizar o banco com os novos registros e caso não consiga, retorna um erro
        if($registros->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Filme atualizado com sucesso',
                'data' => $registros
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o filme'
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {

        // Procura o filme com o ID informado
        $registros = FilmeApi::find($id);

        // Caso não seja encontrado, retorna um erro
        if(!$registros) {
            return response()->json([
                'success' => false,
                'message' => 'Filme não encontrado'
            ], 404);
        }

        // Tenta deletar o registro e caso não consiga, retorna um erro
        if($registros->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Filme deletado com sucesso'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar o filme'
            ], 500);
        }

    }
}
