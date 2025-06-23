<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0fdf4;
            color: #1f2937;
            padding: 30px;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border: 1px solid #d1fae5;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .header {
            background-color: #bbf7d0;
            padding: 20px;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            color: #065f46;
        }

        .content {
            padding: 20px 30px;
        }

        .content p {
            font-size: 15px;
            margin-bottom: 12px;
        }

        .label {
            font-weight: bold;
            color: #065f46;
        }

        .footer {
            background-color: #f0fdf4;
            text-align: center;
            padding: 12px;
            font-size: 13px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>🌿 Nuevo usuario Registrado</h2>
        </div>
        <div class="content">
            <p><span class="label">Nombre:</span> {{ $user->name }}</p>
            <p><span class="label">Email:</span> {{ $user->email }}</p>
            @if ($user->telefono)
                <p><span class="label">Teléfono:</span> {{ $user->telefono }}</p>
            @endif
            <p><span class="label">Fecha de Registro:</span> {{ $user->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="footer">
            Plantas Editha - Vivero
        </div>
    </div>
</body>
</html>
