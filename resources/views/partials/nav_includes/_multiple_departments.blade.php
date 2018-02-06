@if($multiple_departments->count() != 0)
<li>
    <label for="select_town"></label>
</li>
<li>
    <select id="change_department" class="form-control">
      @foreach($multiple_departments as $department)
          <option @if(Auth::user()->department_info_id == $department->department_info_id) selected @endif value="{{$department->department_info_id}}">{{$department->department_info->departments->name . ' ' . $department->department_info->department_type->name}}</option>
      @endforeach
    </select>
</li>
@endif
