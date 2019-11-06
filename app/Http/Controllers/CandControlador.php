<?php

namespace App\Http\Controllers;

use App\Candidatos;
use Illuminate\Http\Request;

class CandControlador extends Controller
{
    public function __construct(){
        $candidatosbd = Candidatos::all();        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candid = Candidatos::all();
        $cand =array(); 
         
        for($i=0;$i<count($candid);$i++)
        {
            $data = $candid[$i]['nascimento'];
            // separando yyyy, mm, ddd
            list($ano, $mes, $dia) = explode('-', $data);            
            // data atual
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            // Descobre a unix timestamp da data de nascimento do fulano
            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
            // cálculo
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

            $cand[$i]['nome'] = $candid[$i]["nome"];
            $cand[$i]['cidade'] = $candid[$i]["cidade"];;
            $cand[$i]['idade'] = $idade;                
        }
        return view('index', compact(['cand']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $texto = '';
        return view('create')
            ->with('texto1', $texto)
            ->with('texto2', $texto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $dados = $request->all();              
        $texto1="";
        $texto2="";
        if($dados['nome'] != "" && $dados['nascimento'] != "" &&  $dados['cep'] != "")
        {               
            $data = $dados['nascimento'];
            // separando yyyy, mm, ddd
            list($ano, $mes, $dia) = explode('-', $data);            
            // data atual
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            // Descobre a unix timestamp da data de nascimento do fulano
            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
            // cálculo
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);  

            //FAZER IF TRATANDO ERRO
            //Como nao foi possivel instalar a extensão que leva ao viacep, fiz essa gambiarra que retorna tudo que o site manda e salvei as partes que eram necessarias
            $cep = $dados['cep'];
            $url = file_get_contents("https://viacep.com.br/ws/$cep/json/");
            $ocorre = substr_count( $url , "localidade");
            if($ocorre == 1)
            {
                $peca1 = explode('"uf": "', $url);
                $peca2 = explode('",', $peca1[1]);
                $oo = $peca2[0];
                $uf = $oo;

                $peca1 = explode('"localidade": "', $url);
                $peca2 = explode('",', $peca1[1]);
                $oo = $peca2[0];
                $cidade = $oo;

                if(($uf == "SP" || $uf == "MG") && ($idade > 14 && $idade < 19))
                {            
                    $cadcandidatos = new Candidatos();
                    $cadcandidatos->nome = $dados['nome'];
                    $cadcandidatos->nascimento = $dados['nascimento'];
                    $cadcandidatos->cep = $dados['cep'];
                    $cadcandidatos->cidade = $cidade;
                    $cadcandidatos->estado = $uf;
                    $cadcandidatos->save();

                    return redirect()->route('candidatos.index');            
                }   
                else
                {
                    if($idade <15 || $idade >19 )
                    {    
                        $texto1 = "Candidato fora da faixa etaria";      
                    }
                    elseif(($uf != "SP" && $uf != "MG"))
                    {   
                        $texto2 = "Candidato em UF não suportado";                
                    }
                    return view('create')
                    ->with('texto1', $texto1)
                    ->with('texto2', $texto2);
                }
            }
            else
            {
                $texto1 = "CEP invalido"; 
                return view('create')
                ->with('texto1', $texto1)
                ->with('texto1', $texto1);
            }
        }
        else
        {            
            return view('create')
            ->with('texto1', $texto1)
            ->with('texto2', $texto2);
        }
    }   
    /*
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
