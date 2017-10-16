<?php

namespace App\Http\Controllers;

use App\Work_Hour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkHoursController extends Controller
{

    public function __construct()
    {
        $this->actuall_date = date("Y-m-d");
        $this->actuall_hour = date("H:i:s");
    }

    public function acceptHour()
    {
        return view('workhours.acceptHour');
    }



    public function datatableAcceptHour(Request $request)
    {
        if($request->ajax()) {

            $start_date = $request->start_date;
            $stop_date = $request->stop_date;
            $query = DB::table('work_hours')
                ->join('users', 'work_hours.id_user', '=', 'users.id')
                ->select(DB::raw(
                    'work_hours.id as id,
                    users.first_name,
                    users.last_name,
                    work_hours.click_start,
                    work_hours.click_stop,
                    work_hours.register_start,
                    work_hours.register_stop,
                    work_hours.date,
                    SEC_TO_TIME(TIME_TO_SEC(register_stop) - TIME_TO_SEC(register_start) ) as time'))
                ->where('work_hours.status', '=', 2)
                ->whereBetween('date',[$start_date,$stop_date]);
            return datatables($query)->make(true);

        }
    }



    public function registerHour(Request $request)
    {
        if($request->ajax())
        {
            $time_register_start = $request->register_start;
            $time_register_stop = $request->register_stop;
            Work_Hour::where('id_user', Auth::id())
                ->where('date',$this->actuall_date)
                ->update(['register_start' => $time_register_start,'register_stop' => $time_register_stop]);

            $request->session()->flash('message', 'New customer added successfully.');
            $request->session()->flash('message-type', 'success');
            return response()->json(['status'=>'Hooray']);
        }
    }
    public function addHour()
    {
        return view('workhours.addHour');
    }
}
