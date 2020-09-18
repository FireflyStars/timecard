<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timecard;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Support\Collection;
use PDF;
class TimecardController extends Controller
{
    //
    public function __construct()
    {
        
    }

    /**
     * show dashboard
     */
    public function showDashboard()
    {
        // set the start and end day of week based on our work week.
        Carbon::setWeekStartsAt(Carbon::WEDNESDAY); // set start day of week to Wednesday
        Carbon::setWeekEndsAt(Carbon::TUESDAY);     // set end day of week to Tuesday
        $timecardsbyworkweek = Timecard::all()->sortBy('date')->groupBy(function($date) {
            return Carbon::parse($date->date)->startOfWeek()->format('Y-W');
        });
        $last_two_timecards_by_workweek = $timecardsbyworkweek->reverse()->splice(0,2);
        // foreach ($last_two_timecards_by_workweek as $workweek) {
        //     # code...
        //     $workweek = $workweek->sortByDesc('date');
        // }
        // dd($last_two_timecards_by_workweek);
        return view('dashboard')->with(['timecardsbyweek'=> $last_two_timecards_by_workweek]);
    }

    /**
     * show dashboard
     */
    public function showArchivedTimecards()
    {
        // set the start and end day  of week based on our work week.
        Carbon::setWeekStartsAt(Carbon::WEDNESDAY); // set start day of week to Wednesday
        Carbon::setWeekEndsAt(Carbon::TUESDAY);     // set end day of week to Tuesday
        $timecardsbyworkweek = Timecard::all()->sortBy('date')->groupBy(function($date) {
            return Carbon::parse($date->date)->startOfWeek()->format('Y-W');
        });
        $timecards_by_workweek = $timecardsbyworkweek->reverse();
        $collection = (new Collection($timecards_by_workweek))->paginate(1);        
        return view('archived-timecard')->with(['timecardsbyweek'=> $collection]);
    }

    /**
     * show timecard for employee
     * @return projects
     */
    public function showTimecard()
    {
        return view('timecard')->with(['projects'=>Project::all()]);
    }

    /**
     * Store timecard
     * @param \Illuminate\Http\Request $request
     * 
     * @return reponse with succes message 
     */
    public function addTimecard(Request $request){
        // dd($request);
        $timecard = new Timecard;
        $timecard->user_id = Auth::id();
        $timecard->project_id = $request->project_id;
        $timecard->date = new Carbon($request->date);
        $time_in = explode(":", $request->time_in);
        $time_out = explode(":", $request->time_out);
        if(intval($time_in[0]) > 12){
            $timecard->time_in = strval($time_in[0] - 12).":".$time_in[1]." PM";
        }else if(intval($time_in[0]) == 12){
            $timecard->time_in = "12:".$time_in[1]." PM";
        }else{
            $timecard->time_in = $request->time_in." AM";
        }

        if(intval($time_out[0]) >= 12){
            $timecard->time_out = strval($time_out[0] - 12).":".$time_out[1]." PM";
        }else if(intval($time_out[0]) == 12){
            $timecard->time_out = "12:".$time_out[1]." PM";
        }else{
            $timecard->time_out = $request->time_out." AM";
        }
        $timecard->regulartime = floatval($request->regulartime);
        $timecard->nighttime = floatval($request->nighttime);
        $timecard->overtime = floatval($request->overtime);
        $timecard->total_hours = floatval($request->total_hours);
        $timecard->save();
        $request->session()->flash('added', true);
        return redirect()->back();
    }

    /**
     * show add timecard form by admin
     */
    public function showAddTimecardForm(){
        return view('add-timecard')->with([ 'projects'=>Project::all(), 'employees'=> User::where('role', '!=', 'Admin')->get()]);
    }

    /**
     * show add timecard form by admin
     */
    public function showEditTimecardForm($timecard_id){
        $timecard = Timecard::find($timecard_id);
        return view('edit-timecard')->with([ 'timecard'=>$timecard, 'projects'=>Project::all(), 'employees'=> User::where('role', '!=', 'Admin')->get()]);
    }

    /**
     * Store timecard by admin
     * @param \Illuminate\Http\Request $request
     * 
     * @return reponse with succes message 
     */
    public function addTimecardByAdmin(Request $request){
        // dd($request);
        $timecard = new Timecard;
        $timecard->user_id = $request->user_id;
        $timecard->project_id = $request->project_id;
        $timecard->date = new Carbon($request->date);
        $time_in = explode(":", $request->time_in);
        $time_out = explode(":", $request->time_out);
        if(intval($time_in[0]) > 12){
            $timecard->time_in = strval($time_in[0] - 12).":".$time_in[1]." PM";
        }else if(intval($time_in[0]) == 12){
            $timecard->time_in = "12:".$time_in[1]." PM";
        }else{
            $timecard->time_in = $request->time_in." AM";
        }

        if(intval($time_out[0]) >= 12){
            $timecard->time_out = strval($time_out[0] - 12).":".$time_out[1]." PM";
        }else if(intval($time_out[0]) == 12){
            $timecard->time_out = "12:".$time_out[1]." PM";
        }else{
            $timecard->time_out = $request->time_out." AM";
        }
        $timecard->regulartime = floatval($request->regulartime);
        $timecard->nighttime = floatval($request->nighttime);
        $timecard->overtime = floatval($request->overtime);
        $timecard->total_hours = floatval($request->total_hours);
        $timecard->save();
        $request->session()->flash('added', true);
        return redirect()->route('dashboard');
    }

    /**
     * Update timecard
     * @param timecardID 
     * 
     * @return reponse with succes message 
     */
    public function updateTimecardByAdmin(Request $request, $id){
        $timecard = Timecard::find($id);
        $timecard->user_id = $request->user_id;
        $timecard->project_id = $request->project_id;
        $timecard->date = new Carbon($request->date);
        $time_in = explode(":", $request->time_in);
        $time_out = explode(":", $request->time_out);
        if(intval($time_in[0]) > 12){
            $timecard->time_in = strval($time_in[0] - 12).":".$time_in[1]." PM";
        }else if(intval($time_in[0]) == 12){
            $timecard->time_in = "12:".$time_in[1]." PM";
        }else{
            $timecard->time_in = $request->time_in." AM";
        }

        if(intval($time_out[0]) > 12){
            $timecard->time_out = strval($time_out[0] - 12).":".$time_out[1]." PM";
        }else if(intval($time_out[0]) == 12){
            $timecard->time_out = "12:".$time_out[1]." PM";
        }else{
            $timecard->time_out = $request->time_out." AM";
        }
        $timecard->regulartime = floatval($request->regulartime);
        $timecard->nighttime = floatval($request->nighttime);
        $timecard->overtime = floatval($request->overtime);
        $timecard->total_hours = floatval($request->total_hours);
        $timecard->save();
        $request->session()->flash('updated', true);
        return redirect()->route('dashboard');
    }

    /**
     * Delete timecard
     * 
     * @param timecar_id
     * 
     * @return
     */

     public function deleteTimecard(Request $request, $id){
         Timecard::find($id)->delete();
         $request->session()->flash('deleted', true);
         return redirect()->route('dashboard');         
     }
    /**
     * print work week informantion
     * 
     * @param work_week_number and year
     * 
     * @return PDF generated by mPDF
     */
    public function printWeekWork($key){
        Carbon::setWeekStartsAt(Carbon::WEDNESDAY); // set start day of week to Wednesday
        Carbon::setWeekEndsAt(Carbon::TUESDAY);     // set end day of week to Tuesday
        $timecardsbyworkweek = Timecard::all()->groupBy(function($date) {
            return Carbon::parse($date->date)->startOfWeek()->format('Y-W');
        });
        $date = Carbon::now();
        $date->setISODate(explode("-", $key)[0],explode("-", $key)[1]+1);
        $weekending = $date->endOfWeek()->format('M d, Y');
        $weekstart = $date->startOfWeek()->format('Y-m-d');
        $workweek = $timecardsbyworkweek[$key]->groupBy('user_id');
        $data = collect();
        $i = 0;
        foreach ($workweek as $key => $employee) {
            $tmpDate = new Carbon($weekstart);
            $regulartime = $employee->sum('regulartime');
            $overtime = $employee->sum('overtime');
            $tmp = $employee->groupBy('date');
            for ($dayInc= 0; $dayInc < 7;  $dayInc++) {
                # code...
                $tmpDate->addDay($dayInc);
                if(!array_key_exists($tmpDate->format('Y-m-d'), $tmp->toArray())){
                    $tmp[$tmpDate->format('Y-m-d')] = collect();    
                }
                $tmpDate->subDay($dayInc);
            }
            $tmp = $tmp->sortKeys();
            // dd($tmp);
            # code...
            $data->push( 
                [
                    $key=>$tmp, 
                    'regulartime'=> $regulartime,
                    'overtime'=> $overtime,
                    'fullname'=>$employee[0]->employee->fullname,
                    'week_ending'=> $weekending,
                    'key'=>$key
                ]
            );
            $i++;
        }
        $pdf = PDF::loadView('pdf', ['data'=> $data], [], [
            'title' => 'Work history',
            'margin_left' => 5,
            'margin_right' => 5,
            'format' => [216, 280]
          ]);
        return $pdf->stream($weekending.'.pdf');
        // return view('pdf', ['data'=>$data]);
    }
}
