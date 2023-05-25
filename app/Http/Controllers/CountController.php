<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\InventoryItems;
use App\Models\Patient;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CountController extends Controller
{
    // Count the number of patient
    public function getTotalPatients()
    {
        $totalPatients = Patient::count();

        return $totalPatients;
    }

    public function getTotalDoctors()
    {
        $totalDoctors = Doctor::count();

        return $totalDoctors;
    }

    public function getTotalPharmacists()
    {
        $data = Pharmacist::count();

        return $data;
    }

    public function getTotalUsers()
    {
        $data = User::count();

        return $data;
    }

    public function getTotalAppointments()
    {
        $data = Appointment::count();

        return $data;
    }

    public function getTotalInventoryItems()
    {
        $data = InventoryItems::count();

        return $data;
    }


    public function getTotalIndividualAppointments($id) //$id indicates id of doctor
    {
        $today = date('Y-m-d H:i');
        $appointments = Appointment::where('doctor_id', $id)
            ->where('validation_status', 'approved')
            ->where('visit_date_and_time', '>=', $today)
            ->orderBy('visit_date_and_time', 'asc')
            ->count();
        return response()->json($appointments);
    }

    public function countChronicDiseases()
    {
        $diseaseCounts = Patient::select('chronic_disease', DB::raw('COUNT(*) as count'))
            ->whereNotNull('chronic_disease')
            ->groupBy('chronic_disease')
            ->get();

        return $diseaseCounts;
    }

    public function getAppointmentCountByWeek()
    {
        $appointments = Appointment::selectRaw('WEEK(visit_date_and_time) as week, COUNT(*) as count')
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->map(function ($appointment) {
                $weekNumber = $appointment->week;
                $weekName = 'Week ' . $weekNumber;
                $appointment->week = $weekName;
                return $appointment;
            });

        return response()->json($appointments);
    }


    public function getPatientCountByWeeks()
    {
        $patientData = Patient::selectRaw('WEEK(created_at) as week, COUNT(*) as count')
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        return response()->json($patientData);
    }

    public function countByItemType()
    {
        $itemCounts = InventoryItems::select('item_type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('item_type')
            ->get();

        return response()->json($itemCounts);
    }
}
