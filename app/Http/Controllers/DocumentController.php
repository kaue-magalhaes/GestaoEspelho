<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'nome'     => 'required',
            'data'     => 'required|date',
            'conteudo' => 'required',
        ]);

        // Criação do PDF
        $pdf = Pdf::loadView('pdf.document', [
            'nome'     => $request->nome,
            'data'     => $request->data,
            'conteudo' => $request->conteudo,
        ]);

        // Armazenamento do PDF
        $nomeArquivo = 'documento_' . time() . '.pdf';
        Storage::put('public/pdfs/' . $nomeArquivo, $pdf->output());

        // Retorno da resposta
        return response()->json([
            'message'  => 'Documento criado com sucesso',
            'filename' => $nomeArquivo,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
