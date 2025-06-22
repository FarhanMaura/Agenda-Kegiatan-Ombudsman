<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::all()->groupBy(function($item) {
            return $item->day . '|' . $item->date;
        });

        return view('admin.agenda.index', compact('agendas'));
    }


    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        Agenda::create($request->all());
        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->update($request->all());
        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diupdate.');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
