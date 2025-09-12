@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Calculadora de Indemnización</h1>

<form method="POST" action="{{ route('calculate') }}" class="space-y-6">
    @csrf

    <div>
        <label class="block font-medium">Nombre del trabajador</label>
        <input name="name" value="{{ old('name') }}"
               class="w-full mt-1 rounded-lg border-gray-300" required>
        @error('name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block font-medium">Fecha de ingreso</label>
            <input type="date" name="start_date" value="{{ old('start_date') }}"
                   class="w-full mt-1 rounded-lg border-gray-300" required>
            @error('start_date')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block font-medium">Fecha de baja</label>
            <input type="date" name="end_date" value="{{ old('end_date') }}"
                   class="w-full mt-1 rounded-lg border-gray-300" required>
            @error('end_date')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block font-medium">Salario diario (SD)</label>
            <input type="number" step="0.01" name="daily_salary" value="{{ old('daily_salary') }}"
                   class="w-full mt-1 rounded-lg border-gray-300" required>
            @error('daily_salary')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block font-medium">Salario diario integrado (SDI) <span class="text-sm text-gray-500">(opcional)</span></label>
            <input type="number" step="0.01" name="sdi" value="{{ old('sdi') }}"
                   class="w-full mt-1 rounded-lg border-gray-300">
            @error('sdi')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="block font-medium">Zona salarial</label>
        <select name="zone" class="w-full mt-1 rounded-lg border-gray-300" required>
            <option value="general">General</option>
            <option value="frontera">Frontera Norte</option>
        </select>
        @error('zone')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>

    <button type="submit"
            class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow">
        Calcular
    </button>
</form>
@endsection
