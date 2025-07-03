<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function geradorExercicios(Request $request)
    {
         $request->validate([
            'check_sum' => 'required_without_all:check_subtraction,check_multiplication,check_division',
            'check_subtraction' => 'required_without_all:check_sum,check_multiplication,check_division',
            'check_multiplication' => 'required_without_all:check_sum,check_subtraction,check_division',
            'check_division' => 'required_without_all:check_sum,check_subtraction,check_multiplication',
            'number_one' => 'required|integer|min:0|max:999|lt:number_two',
            'number_two' => 'required|integer|min:0|max:999',
            'number_exercises' => 'required|integer|min:5|max:50',
        ]);

        $operacoes = [];

        if($request->check_sum) { $operacoes[] = 'sum'; } 
        if($request->check_subtraction) { $operacoes[] = 'subtraction'; } 
        if($request->check_multiplication) { $operacoes[] = 'multiplication'; } 
        if($request->check_division) { $operacoes[] = 'division'; } 

        $min = $request->number_one;
        $max = $request->number_two;

        $numeroTotalExercicios = $request->number_exercises;

        // generate exercises
        $exercicios = [];

        for($i = 1; $i <= $numeroTotalExercicios; $i++){
            $operacao = $operacoes[array_rand($operacoes)];
            $numero1  = rand($min, $max);
            $numero2 = rand($min, $max);

            $exercicio = '';
            $solucao = '';
            switch ($operacao) {
                case 'sum':
                    $exercicio = "$numero1 + $numero2 =";
                    $solucao = $numero1 + $numero2;
                    break;
                case 'subtraction':
                    $exercicio = "$numero1 - $numero2 =";
                    $solucao = $numero1 - $numero2;
                    break;
                case 'multiplication':
                    $exercicio = "$numero1 x $numero2 =";
                    $solucao = $numero1 * $numero2;
                    break;
                case 'division':

                    // avoid division by zero
                    if($numero2 == 0){
                        $numero2 = 1;
                    }

                    $exercicio = "$numero1 : $numero2 =";
                    $solucao = $numero1 / $numero2;
                    $solucao = number_format($solucao, 2, ',', ''); 
                    break;
            }
            $exercicios[] = [
                'numero_exercicio' => $i,
                'exercicio' => $exercicio,
                'solucao' => "$exercicio $solucao"
            ];
        }

        session(['exercicios' => $exercicios]);

       return view('operacoes', ['exercicios' => $exercicios]);
    }

    public function listarExercicios()
    {
        if(!session()->has('exercicios')){
            return redirect()->route('principal');
        }
        
        $exercicios = session('exercicios');
        echo '<h1>Exercicios:</h1>';
        foreach($exercicios as $exercicio){
            echo '<h2><small>'.$exercicio['exercicio'].'</small></h2>';
        }
        echo '<hr>';
        echo '<h1>solucao:</h1>';
        foreach($exercicios as $exercicio){
            echo '<h2><small>'.str_pad($exercicio['solucao'], 2,"0",STR_PAD_LEFT).'</small></h2>';
        }
    }

    public function exportarExercicios()
    {
        
        if(!session()->has('exercicios')){
            return redirect()->route('principal');
        }
        $nomeArquivo = 'gerador'.date('YmdHis').'.txt';
        $conteudo = '';
        $exercicios = session('exercicios');
        $conteudo .= "Exercicios:\n";
        foreach($exercicios as $exercicio){
            $conteudo .= $exercicio['exercicio'] . "\n";
        }

        $conteudo .= "----------------------------\n";
        $conteudo .= "Solucoes:\n";
        foreach($exercicios as $exercicio){
            $conteudo .= $exercicio['solucao'] . "\n";
        }

        return response($conteudo)
                ->header('Content-Type', 'text/plain' )
                ->header('Content-Disposition', 'attachment; filename="'.$nomeArquivo.'"' );
    }
    
}
