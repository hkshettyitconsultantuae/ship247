<select @if($required ?? false) required @endif id="{{ $name }}" name="{{ $name }}"
        class="form-input small-input mt-2 w-full block location-Select2">
    @if(isset($selected_option_value, $selected_option_text))
    <option value="{{ $selected_option_value }}" selected>{{$selected_option_text}}</option>
    @endif
</select>
