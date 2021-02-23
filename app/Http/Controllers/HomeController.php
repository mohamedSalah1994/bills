<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

//=================احصائية نسبة تنفيذ الحالات======================



      $count_all =Bill::count();
      $count_bills1 = Bill::where('Value_Status', 1)->count();
      $count_bills2 = Bill::where('Value_Status', 2)->count();
      $count_bills3 = Bill::where('Value_Status', 3)->count();

      if($count_bills2 == 0){
          $nspabills2=0;
      }
      else{
          $nspabills2 = $count_bills2/ $count_all*100;
      }

        if($count_bills1 == 0){
            $nspabills1=0;
        }
        else{
            $nspabills1 = $count_bills1/ $count_all*100;
        }

        if($count_bills3 == 0){
            $nspabills3=0;
        }
        else{
            $nspabills3 = $count_bills3/ $count_all*100;
        }


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels([' الغير المدفوعة', ' المدفوعة',' المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$nspabills2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$nspabills1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$nspabills3]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$nspabills2, $nspabills1,$nspabills3]
                ]
            ])
            ->options([]);

        return view('home', compact('chartjs','chartjs_2'));

    }
}
