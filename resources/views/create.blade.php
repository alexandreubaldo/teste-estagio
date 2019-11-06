@extends('layouts.main')
@section('titulo')
    <div>
        <h1>Adicionar candidato</h1>
    </div>    
@endsection 

@section('conteudo')
<form action ="{{route('candidatos.store'), }}" method="POST">
        @csrf
        <div>
            <input type="text" name="nome" placeholder="Nome">
            <p></p>
        </div>
        <div>
            <input type="date" name="nascimento" >
            <p>{{$texto1}}</p>
        </div>
        <div>
            <input type="numbers" name="cep" placeholder="CEP">
            <p>{{$texto2}}</p>
        </div>
        <div>        
            <input type="text" name="cidade" placeholder="Cidade">
            <p></p>
        </div>
        <div>    
            <input type="text" name="estado" placeholder="UF">
            <p></p>
        </div>
        <div>
            <input type="submit" name="Salvar">
        </div>    
    </form>
@endsection