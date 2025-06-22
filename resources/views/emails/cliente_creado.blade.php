<h2>Nuevo user Registrado</h2>

<p><strong>Nombre:</strong> {{ $user->name }}</p>
<p><strong>Email:</strong> {{ $user->email }}</p>
@if ($user->telefono)
    <p><strong>Teléfono:</strong> {{ $user->telefono }}</p>
@endif
<p><strong>Fecha de Registro:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
