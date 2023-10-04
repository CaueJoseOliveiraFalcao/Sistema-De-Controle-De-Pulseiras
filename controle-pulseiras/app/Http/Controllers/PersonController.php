<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pessoa = Person::where("cpf", $request->cpf)->get();

        if ($pessoa->isNotEmpty()){
            $ingress_quantity = $pessoa[0]->quantidade_de_ingressos;

            if ($ingress_quantity === 0) {
                $pessoa[0]->quantidade_de_ingressos = 1;
                $pessoa[0]->save();
                return view('form')->with('message', $pessoa[0]->nome . ' Adicionado mais 1 pessoa no cpf!');
            }
            if ($ingress_quantity === 1) {
                return back()->withErrors('CPF ' . $request->cpf . ' já cadastrado em dois ingressos no nome de ' . $pessoa[0]->nome);
            }
        }
        
        else {
            $ingress_quantity = $request->input('quantity', 0);
            $request->validate([
                'cpf' => 'required|string',
                'nome' => 'required|string',
            ]);
        
            $pessoa = new Person();
            $pessoa->cpf = $request->input('cpf');
            $pessoa->nome = $request->input('nome');
            $pessoa->quantidade_de_ingressos = $request->input('quantity', 0); 
            $pessoa->save();
        }
        return view('form')->with('message', $pessoa->nome . ' cadastrado com sucesso!');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        //
    }
s
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        //
    }
}
