@extends($layout)

@section('title', $role ? 'Editar Rol' : 'Crear Rol')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
        {{ $role ? 'Editar Rol' : 'Crear Nuevo Rol' }}
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $role
        ? route('roles.update', ['role' => $role->id, 'source' => $source])
        : route('roles.store', ['source' => $source]) }}"
        method="POST"
    >
        @csrf
        @if($role)
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Nombre del Rol:</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $role->name ?? '') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-300"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Permisos:</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permissions as $permission)
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                {{ (isset($role) && $role->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}
                                class="form-checkbox text-indigo-600">
                            <span class="ml-2">{{ $permission->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-start">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                {{ $role ? 'Actualizar Rol' : 'Crear Rol' }}
            </button>
            <a href="{{ route('roles.index', ['source' => $source]) }}"
               class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
