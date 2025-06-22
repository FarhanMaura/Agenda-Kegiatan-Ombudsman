<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class FrontAgendaController extends Controller
{
    private function getAgendaByDivision($division, $title)
    {
        $agendas = Agenda::where('division', $division)
                        ->where('is_archived', false)
                        ->orderBy('date', 'asc')
                        ->orderBy('start_time', 'asc')
                        ->get();

        return view('agenda.division', [
            'agendas' => $agendas,
            'division' => $title,
            'division_slug' => $division
        ]);
    }

    public function pvl()
    {
        return $this->getAgendaByDivision('pvl', 'PVL');
    }

    public function pl()
    {
        return $this->getAgendaByDivision('pl', 'PL');
    }

    public function kaper()
    {
        return $this->getAgendaByDivision('kaper', 'Kaper');
    }

    public function pc()
    {
        return $this->getAgendaByDivision('pc', 'PC');
    }

    public function sekretariat()
    {
        return $this->getAgendaByDivision('sekretariat', 'Sekretariat');
    }

    public function index()
    {
        $agendas = Agenda::where('is_archived', false)
                        ->orderBy('date', 'asc')
                        ->orderBy('start_time', 'asc')
                        ->get()
                        ->groupBy('division');

        return view('agenda.index', [
            'groupedAgendas' => $agendas,
            'divisions' => [
                'pvl' => 'PVL',
                'pl' => 'PL',
                'kaper' => 'Kaper',
                'pc' => 'PC',
                'sekretariat' => 'Sekretariat'
            ]
        ]);
    }
}
