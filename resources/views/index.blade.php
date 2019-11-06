@extends('layouts.main')
@section('titulo')
    <div>
        <h1>CANDIDATOS <a href={{route('candidatos.create')}}><button>+Adicionar</button></a></h1>
    </div>    
@endsection 

@section('conteudo')
        @foreach ($cand ?? '' as $b)
                <div class="square">    
                <p>{{$b['nome']}}<br>{{$b['cidade']}}<br>{{$b['idade']}}anos
                </div>
        @endforeach
@endsection

