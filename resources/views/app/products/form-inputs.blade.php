@php $editing = isset($product) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $product->name : '')) }}"
            maxlength="10"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
