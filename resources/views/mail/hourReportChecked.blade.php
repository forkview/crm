<table style="width:100%;border:1px solid #231f20;border-collapse:collapse;padding:3px">
<thead style="color:#efd88f">
<tr>
<td colspan="3" style="border:1px solid #231f20;text-align:center;padding:3px;background:#231f20;color:#efd88f">
<font size="6" face="Calibri">Raport Godzinny % Odsłuchanych badania {{$date}} {{$hour}}</font></td>
<td colspan="2" style="border:1px solid #231f20;text-align:left;padding:6px;background:#231f20">
<img src="http://teambox.pl/image/logovc.png" class="CToWUd"></td>
</tr>
    <tr>
        <th style="border:1px solid #231f20;padding:3px;background:#231f20">Oddział</th>
        <th style="border:1px solid #231f20;padding:3px;background:#231f20">Godzina</th>
        <th style="border:1px solid #231f20;padding:3px;background:#231f20">Liczba Zaproszeń</th>
        <th style="border:1px solid #231f20;padding:3px;background:#231f20">Odsłuchane rozmowy</th>
        <th style="border:1px solid #231f20;padding:3px;background:#231f20">% Odsłuchanych</th>
    </tr>
</thead>
    <tbody>

@php
    $total_success = 0;
    $total_dkj_sum = 0;
    $dep_4 = true;
@endphp

@if(isset($reports))
@foreach($reports as $report)
@php $column = true; @endphp
    <tr>
        @if($report->department_info_id == 4)
            <td style="border:1px solid #231f20;text-align:center;padding:3px">Radom Potwierdzenia Wysyłka</td>
        @elseif($report->department_info_id == 13)
            <td style="border:1px solid #231f20;text-align:center;padding:3px">Radom Potwierdzenia Badania</td>
        @else
            <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$report->dep_name . ' ' . $report->dep_name_type}}</td>
        @endif
        <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$hour}}</td>
        <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$report->success}}</td>
           @foreach($dkj as $item)
                  @if($item->department_info_id == $report->department_info_id && ($report->department_info_id != 4 && $report->department_info_id != 13))
                      @php
                          $avg_department = round(($item->liczba_odsluchanych / $report->success) * 100, 2);
                          $total_dkj_sum += $item->liczba_odsluchanych;
                      @endphp
                          <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$item->liczba_odsluchanych}}</td>
                      @php $column = false; @endphp
                  @elseif($item->department_info_id == 4 && $report->department_info_id == 4 && $item->wysylka > 0)
                      @php
                           $avg_department = round(($item->liczba_odsluchanych / $report->success) * 100, 2);
                           $total_dkj_sum += $item->wysylka;
                      @endphp
                          <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$item->wysylka}}</td>
                      @php $column = false;@endphp
                  @elseif($item->department_info_id == 4 && $report->department_info_id == 13 && $item->badania > 0)
                      @php
                           $avg_department = round(($item->liczba_odsluchanych / $report->success) * 100, 2);
                           $total_dkj_sum += $item->badania;
                      @endphp
                          <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$item->badania}}</td>
                      @php $column = false; @endphp
                  @endif
           @endforeach
           @if($column == true)
              <td style="border:1px solid #231f20;text-align:center;padding:3px">0</td>
              <td style="border:1px solid #231f20;text-align:center;padding:3px">0 %</td>
           @else
              <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$avg_department}} %</td>
           @endif
           @php $total_success += $report->success; @endphp
    </tr>

@endforeach
@endif

@if($total_success > 0)
    <td colspan="2" style="border:1px solid #231f20;text-align:center;padding:3px"><b>TOTAL</b></td>
    <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$total_success}}</td>
    <td style="border:1px solid #231f20;text-align:center;padding:3px">{{$total_dkj_sum}}</td>
    @if($total_dkj_sum > 0)
        <td style="border:1px solid #231f20;text-align:center;padding:3px">{{round($total_dkj_sum / $total_success * 100, 2)}}</td>
    @else
        <td style="border:1px solid #231f20;text-align:center;padding:3px">0 %</td>
    @endif
@endif

    </tbody>
</table>
