<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Postulaciones</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }
        .logo img {
            width: 150px;
            height: auto;
        }
        .title {
            text-align: right;
            font-size: 18px;
            color: #1a202c;
        }
        h2 {
            margin-top: 20px;
            font-size: 22px;
            color: #1a202c;
        }
        p {
            font-size: 14px;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8fafc;
            font-weight: bold;
            color: #333;
        }
        .status-accepted {
            color: #fff;
            background-color: green;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-rejected {
            color: #fff;
            background-color: red;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending {
            color: #fff;
            background-color: gray;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    {{-- Cabecera con Logo y Nombre Completo --}}
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/logo-upeu-dark-svg.svg') }}" alt="Logo">
        </div>
        <div class="title">
            <p><strong>Reporte de tus Postulaciones</strong></p>
            <p><strong>Generado por:</strong> {{ $nombreCompleto }}</p> <!-- Nombre completo del usuario -->
        </div>
    </div>

    {{-- Título del Reporte con Fecha y Hora --}}
    <h2>Postulaciones desde {{ $fechaInicio }} hasta {{ $fechaFin }}</h2>
    <p><strong>Fecha y hora de generación del reporte:</strong> {{ $fechaActual->format('d-m-Y H:i:s') }}</p> <!-- Fecha y hora actual -->

    {{-- Tabla de postulaciones --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Oferta</th>
                <th>Empresa</th>
                <th>Salario</th>
                <th>Ubicación</th>
                <th>Fecha de Postulación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postulaciones as $postulacion)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $postulacion->oferta->titulo }}</td>
                    <td>{{ $postulacion->oferta->empresa }}</td>
                    <td>{{ $postulacion->oferta->salario }}</td>
                    <td>{{ $postulacion->oferta->ubicacion }}</td>
                    <td>{{ $postulacion->created_at->format('d-m-Y H:i:s') }}</td> <!-- Fecha y hora de postulación -->
                    <td>
                        @if($postulacion->estado == 'aceptado')
                            <span class="status-accepted">Aceptado</span>
                        @elseif($postulacion->estado == 'rechazado')
                            <span class="status-rejected">Rechazado</span>
                        @else
                            <span class="status-pending">En espera</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <p>&copy; {{ date('Y') }} BolsaUPeU. Todos los derechos reservados.</p>
    </div>

</body>
</html>
