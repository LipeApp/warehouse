@php $editing = isset($warehouse) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="material_id" label="Material" required>
            @php $selected = old('material_id', ($editing ? $warehouse->material_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Material</option>
            @foreach($materials as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="reminder"
            label="Reminder"
            value="{{ old('reminder', ($editing ? $warehouse->reminder : '')) }}"
            max="255"
            step="0.01"
            placeholder="Reminder"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
