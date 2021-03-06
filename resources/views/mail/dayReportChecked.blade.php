<table style="width:100%;border:1px solid #231f20;border-collapse:collapse;padding:3px">
<thead style="color:#efd88f">
<tr>
<td colspan="2" style="border:1px solid #231f20;text-align:center;padding:3px;background:#231f20;color:#efd88f">
<font size="6" face="Calibri">RAPORT ODSŁUCHANYCH ROZMÓW {{$today}} </font></td>
<td colspan="2" style="border:1px solid #231f20;text-align:left;padding:6px;background:#231f20">
<img src="http://teambox.pl/image/logovc.png" class="CToWUd"></td>
</tr>
<tr>
<th style="border:1px solid #231f20;padding:3px;background:#231f20">Oddział</th>
<th style="border:1px solid #231f20;padding:3px;background:#231f20">Liczba zgód</th>
<th style="border:1px solid #231f20;padding:3px;background:#231f20">Liczba odsłuchanych</th>
<th style="border:1px solid #231f20;padding:3px;background:#231f20">% Odsłuchanych</th>
</tr>
</thead>
  <tbody>
@php
    $total_success = 0;
    $total_dkj_sum = 0;
    $add_research = true;
@endphp

    @foreach($hour_reports as $report)
    @php
        $column = true;
    @endphp
        <tr>
            @if($report->department_info_id == 4)
                <td style="border:1px solid #231f20;text-align:center;padding:3px">Radom Potwierdzanie Wysyłka</td>
            @elseif($report->department_info_id == 13)
                <td style="border:1px solid #231f20;text-align:center;padding:3px">Radom Potwierdzanie Badania</td>
            @else
                <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$report->dep_name . ' ' . $report->dep_name_type}}</td>
            @endif

            <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$report->success}}</td>
            @foreach($dkj as $item)
                @if($item->department_info_id == $report->department_info_id && ($report->department_info_id != 4))
                    @php
                        $avg_department = round(($item->dkj_sum / $report->success) * 100, 2);
                        $total_dkj_sum += $item->dkj_sum;
                    @endphp
                    <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$item->dkj_sum}}</td>
                    @php
                        $column = false;
                    @endphp

                @elseif($item->department_info_id == $report->department_info_id && $report->department_info_id == 4 && $item->dating_type == 1)
                    @php
                        $avg_department = round(($item->dkj_sum / $report->success) * 100, 2);
                        $total_dkj_sum += $item->dkj_sum;
                    @endphp
                    <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$item->dkj_sum}}</td>
                    @php
                        $column = false;
                    @endphp

                    @elseif($report->department_info_id == 13 && $item->department_info_id == 4 && $item->dating_type == 0 && $add_research == true)
                    @php
                        $avg_department = round(($item->dkj_sum / $report->success) * 100, 2);
                        $total_dkj_sum += $item->dkj_sum;
                    @endphp
                        <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$item->dkj_sum}}</td>
                    @php
                        $column = false;
                        $add_research = false;
                    @endphp

                    @endif
            @endforeach
            @if($column == true)
               <td style="border:1px solid #231f20;text-align:center;padding:3px">0</td>
               <td style="border:1px solid #231f20;text-align:center;padding:3px">0 %</td>
            @else
               <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$avg_department}} %</td>
            @endif
            @php
                $total_success += $report->success;
            @endphp
        </tr>
    @endforeach


@if($total_success > 0)
    <td colspan="1" style="border:1px solid #231f20;text-align:center;padding:3px"><b>TOTAL</b></td>
    <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$total_success}}</td>
    <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$total_dkj_sum}}</td>
    @if($total_dkj_sum > 0)
        <td style="border:1px solid #231f20;text-align:center;padding:3px">{{round($total_dkj_sum / $total_success * 100, 2)}} %</td>
    @else
        <td style="border:1px solid #231f20;text-align:center;padding:3px">0 %</td>
    @endif
@endif
  </tbody>
</table>
