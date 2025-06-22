<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\AgendaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    // Main Agenda Methods
    public function index(Request $request)
    {
        $isArchived = $request->has('archived') && $request->archived == 1;
        $agendas = Agenda::where('is_archived', $isArchived)
                        ->orderBy('date', 'asc')
                        ->orderBy('start_time', 'asc')
                        ->get();

        return view('admin.agenda.index', [
            'agendas' => $agendas,
            'isArchived' => $isArchived,
        ]);
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'activities' => 'required|array|min:1|max:8',
            'activities.*' => 'required|string',
            'institution' => 'required|string',
            'division' => 'required|in:pvl,pl,pc,kaper,sekretariat',
            'person_in_charge' => 'required|string',
            'other_pic' => 'nullable|string|required_if:person_in_charge,Lainnya',
            'other_activities' => 'nullable|array',
        ]);

        $activities = [];
        foreach ($request->activities as $index => $activity) {
            if ($activity === 'Lainnya' && isset($request->other_activities[$index])) {
                $activities[] = $request->other_activities[$index];
            } else {
                $activities[] = $activity;
            }
        }

        $personInCharge = ($request->person_in_charge === 'Lainnya' && $request->filled('other_pic'))
            ? $request->other_pic
            : $request->person_in_charge;

        $agenda = Agenda::create([
            'day' => $request->day,
            'date' => $request->date,
            'time' => $request->start_time . ' - ' . $request->end_time,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity' => json_encode($activities),
            'institution' => $request->institution,
            'division' => $request->division,
            'person_in_charge' => $personInCharge,
            'is_archived' => false,
        ]);

        return redirect()->route('admin.agenda.index')
                       ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $activities = json_decode($agenda->activity, true) ?? [];

        return view('admin.agenda.edit', [
            'agenda' => $agenda,
            'activities' => $activities
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'day' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'activities' => 'required|array|min:1',
            'activities.*' => 'required|string',
            'institution' => 'required|string',
            'division' => 'required|in:pvl,pl,pc,kaper,sekretariat',
            'person_in_charge' => 'required|string',
            'other_pic' => 'nullable|string|required_if:person_in_charge,Lainnya',
        ]);

        $finalActivities = [];
        foreach ($request->activities as $index => $activity) {
            if ($activity === 'Lainnya' && isset($request->other_activities[$index])) {
                $finalActivities[] = $request->other_activities[$index];
            } else {
                $finalActivities[] = $activity;
            }
        }

        $personInCharge = ($request->person_in_charge === 'Lainnya')
            ? $request->other_pic
            : $request->person_in_charge;

        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'day' => $validated['day'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'time' => $validated['start_time'] . ' - ' . $validated['end_time'],
            'activity' => json_encode($finalActivities),
            'institution' => $validated['institution'],
            'division' => $validated['division'],
            'person_in_charge' => $personInCharge,
        ]);

        return redirect()->route('admin.agenda.index')
                       ->with('success', 'Agenda berhasil diupdate!');
    }

    public function archiveWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        Agenda::where('is_archived', false)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->update(['is_archived' => true]);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda minggu ini berhasil diarsipkan.');
    }

    public function archived()
    {
        $agendas = Agenda::where('is_archived', true)
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $groupedAgendas = $agendas->groupBy(function ($item) {
            return Carbon::parse($item->date)->format('Y-m-d');
        });

        return view('admin.agenda.archived', [
            'agendas' => $agendas,
            'groupedAgendas' => $groupedAgendas,
            'isArchived' => true,
        ]);
    }

    public function archive($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->is_archived = true;
        $agenda->save();

        return redirect()->back()->with('success', 'Agenda berhasil diarsipkan.');
    }

    public function destroy(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $agenda->delete();

        if ($request->has('archived') && $request->archived == 1) {
            return redirect()->route('admin.agenda.index', ['archived' => 1])
                           ->with('success', 'Agenda berhasil dihapus.');
        }

        return redirect()->route('admin.agenda.index')
                       ->with('success', 'Agenda berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $isArchived = $request->has('archived') && $request->archived == 1;
        $filename = $isArchived ? 'agenda_arsip.xlsx' : 'agenda_aktif.xlsx';

        return Excel::download(new AgendaExport($isArchived), $filename);
    }
}
