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
            $solução = '';
            switch ($operacao) {
                case 'sum':
                    $exercicio = "$numero1 + $numero2 =";
                    $solução = $numero1 + $numero2;
                    break;
                case 'subtraction':
                    $exercicio = "$numero1 - $numero2 =";
                    $solução = $numero1 - $numero2;
                    break;
                case 'multiplication':
                    $exercicio = "$numero1 x $numero2 =";
                    $solução = $numero1 * $numero2;
                    break;
                case 'division':

                    // avoid division by zero
                    if($numero2 == 0){
                        $numero2 = 1;
                    }

                    $exercicio = "$numero1 : $numero2 =";
                    $solução = $numero1 / $numero2;
                    break;
            }
            $exercicios[] = [
                'numero_exercicio' => $i,
                'exercicio' => $exercicio,
                'solucao' => "$exercicio $solução"
            ];
        }

       return view('operacoes', ['exercicios' => $exercicios]);
    }

    public function listarExercicios()
    {
        echo 'listarExercicios';
    }

    public function exportarExercicios()
    {
        echo 'exportar';
    }
}
