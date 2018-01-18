<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DatabaseURLController extends Controller
{

    // nowe zgody raport tygodniowy (przygotowanie danych)
    private function NewBaseWeekData(){
        $json =  file_get_contents('http://baza.teambox.pl/baza/getRaportNewBaseWeek');
        $obj = json_decode($json);
        $agree_count = 0;
        $bisnode_count = 0;
        $event_count = 0;
        $exito_count = 0;
        $rest_count = 0;
        $this::count_date($obj,$agree_count,$bisnode_count,$event_count,$exito_count,$rest_count);
        $data['bisnode'] = $bisnode_count;
        $data['aggree'] = $agree_count;
        $data['event'] = $event_count;
        $data['exito'] = $exito_count;
        $data['rest'] = $rest_count;
        return $data;
    }
    // wyświetlenie strony z nowymi zgodami tygodniowy
    public function pageWeekRaportNewBaseWeek()
    {
        $data = $this->NewBaseWeekData();
        return view('reportpage.WeekReportNewBase')
            ->with('bisnode',$data['bisnode'])
            ->with('aggree',$data['aggree'] )
            ->with('event',$data['event'])
            ->with('exito', $data['exito'])
            ->with('rest',$data['rest']);
    }
    // wysłanie maila wyświetlenie strony z nowymi zgodami tygodniowy
    public function MailWeekRaportNewBaseWeek(){
        $date_start = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
        $date_stop = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
        $data = $this->NewBaseWeekData();
        $title = 'Raport Tygodniowy Nowych Zgód '.$date_start.' - '.$date_stop;
        $this->sendMailByVerona('weekReportNewBase', $data, $title);
    }

    //  nowe zgody raport miesieczny (przygotowanie danych)
    private function NewBaseMonthData()
    {
        $json =  file_get_contents('http://baza.teambox.pl/baza/getRaportNewBaseMonth');
        $obj = json_decode($json);
        $agree_count = 0;
        $bisnode_count = 0;
        $event_count = 0;
        $exito_count = 0;
        $rest_count = 0;
        $this::count_date($obj,$agree_count,$bisnode_count,$event_count,$exito_count,$rest_count);
        $data['bisnode'] = $bisnode_count;
        $data['aggree'] = $agree_count;
        $data['event'] = $event_count;
        $data['exito'] = $exito_count;
        $data['rest'] = $rest_count;
        $month = date('m') -1;
        $month_name = $this::monthReverseName($month);
        $data['month'] = $month_name;
        return $data;
    }
    //Strona nowe zgody raport miesieczny
    public function pageMonthRaportNewBaseWeek()
    {
       $data = $this->NewBaseMonthData();
        return view('reportpage.MonthReportNewBase')
            ->with('bisnode',$data['bisnode'])
            ->with('aggree',$data['aggree'] )
            ->with('event',$data['event'])
            ->with('exito', $data['exito'])
            ->with('rest',$data['rest'])
            ->with('month',$data['month']);
    }
    //Wysłanie maila z nowe zgody raport miesieczny (przygotowanie danych)
    public function MailMonthRaportNewBaseWeek(){
        $data = $this->NewBaseMonthData();
        $title = 'Raport Miesięczny Nowych Zgód: '.$data['month'];
        $this->sendMailByVerona('monthReportNewBase', $data, $title);
    }


    // przygotowanie danych pobranych rekordów z bazy (type -> 1 dzienny, 2 tygodniowy, 3 miesieczny)
    private function DatabaseUseData($type)
    {
        $json =  file_get_contents('http://baza.teambox.pl/baza/getRaportDayAPI/'.$type);
        $obj = json_decode($json);
        $data['overall_result'] = $obj->overall_result;
        $data['departments_statistic'] =  $obj->departments_statistic;
        $data['employee_statistic'] =  $obj->employee_statistic;
        return $data;
    }

    //Raport Dzienny
    public function MailDayRaportDatabaseUse(){
        $data = $this->DatabaseUseData(1);
        $title = 'Raport dzienny wykorzystania bazy: '.date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
        $this->sendMailByVerona('dayReportDatabaseUse', $data, $title);
    }

    public function pageDayRaportDatabaseUse(){
        $data = $this->DatabaseUseData(1);
        return view('reportpage.DayReportDatabaseUse')
            ->with('overall_result',$data['overall_result'])
            ->with('departments_statistic',$data['departments_statistic'] )
            ->with('employee_statistic',$data['employee_statistic']);
    }
    //Tygodniowy
    public function MailWeekRaportDatabaseUse(){
        $data = $this->DatabaseUseData(2);
        $date_start = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
        $date_stop = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
        $title = 'Raport tygodniowy wykorzystania bazy: '.$date_start.' - '.$date_stop;
        $this->sendMailByVerona('weekReportDatabaseUse', $data, $title);
    }
    public function pageWeekRaportDatabaseUse(){
        $data = $this->DatabaseUseData(2);
        return view('reportpage.WeekReportDatabaseUse')
            ->with('overall_result',$data['overall_result'])
            ->with('departments_statistic',$data['departments_statistic'] )
            ->with('employee_statistic',$data['employee_statistic']);
    }
    //Miesięczny
    public function MailMonthRaportDatabaseUse(){
        $data = $this->DatabaseUseData(3);
        $month = date('m') -1;
        $month_name = $this::monthReverseName($month);
        $title = 'Raport miesięczny wykorzystania bazy: '.$month_name;
        $data['month'] = $month_name;
        $this->sendMailByVerona('monthReportDatabaseUse', $data, $title);
    }
    public function pageMonthRaportDatabaseUse(){
        $data = $this->DatabaseUseData(3);
        $month = date('m') -1;
        $month_name = $this::monthReverseName($month);
        return view('reportpage.MonthReportDatabaseUse')
            ->with('overall_result',$data['overall_result'])
            ->with('departments_statistic',$data['departments_statistic'] )
            ->with('employee_statistic',$data['employee_statistic'])
            ->with('month',$month_name);
    }












    /*
     * FUNKCJE PRYWATNE
     */

    //zwracanie nazwy miesiąca którego dotyczy statystyka
    private function monthReverseName($month) {
        $month_names = array( 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień' );
        $month -= 1;
        $month = ($month < 0) ? 11 : $month ;
        return $month_names[$month];
    }

     // zliczanie danych
    private function count_date($obj,&$agree_count,&$bisnode_count,&$event_count,&$exito_count,&$rest_count)
    {
        foreach ($obj as $item)
        {
            $id_base =  $item->old_base;
            $count_record = $item->count_record;
            if($id_base == 8)
            {
                $bisnode_count += $count_record;
            }else if($id_base == 6)
            {
                $event_count += $count_record;
            }else if($id_base == 5 || $id_base == 9 || $id_base == 17)
            {
                $agree_count += $count_record;
            }else if($id_base == 19)
            {
                $exito_count += $count_record;
            }else{
                $rest_count += $count_record;
            }
        }
    }

    /******** Główna funkcja do wysyłania emaili*************/
    /*
    * $mail_type - jaki mail ma być wysłany - typ to nazwa ścieżki z web.php
    * $data - $dane przekazane z metody
    *
    */

    private function sendMailByVerona($mail_type, $data, $mail_title) {
        $email = [];
        $mail_type2 = ucfirst($mail_type);
        $mail_type2 = 'page' . $mail_type2;

    $accepted_users = [
        'cytawa.verona@gmail.com',
        'jarzyna.verona@gmail.com',
//        'pawel.zielinski@veronaconsulting.pl',
//        'kamil.kostecki@veronaconsulting.pl'
    ];

     Mail::send('mail.' . $mail_type, $data, function($message) use ($accepted_users, $mail_title)
     {
        $message->from('noreply.verona@gmail.com', 'Verona Consulting');
        foreach ($accepted_users as $key => $user) {
          if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
              $message->to($user)->subject($mail_title);
          }
        }
     });

    }

}