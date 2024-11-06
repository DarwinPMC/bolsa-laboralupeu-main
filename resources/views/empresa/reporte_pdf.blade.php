<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Postulantes</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f2f2f2;
            padding-bottom: 10px;
        }
        .header .logo img {
            width: 150px;
            /* Asegúrate de que la imagen no se altere */
            filter: none;
            -webkit-filter: none;
            opacity: 1;
            color: inherit; /* Evita cambios de color en SVG o elementos embebidos */
        }
        .header .title {
            text-align: right;
        }
        .header .title h1 {
            font-size: 18px;
            color: #1a202c;
            margin: 0;
        }
        .header .title h1 span {
            color: blue; /* Cambia el color del nombre a azul */
        }
        .header .title p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }
        h2 {
            font-size: 16px;
            margin-top: 20px;
            color: #1a202c;
        }
        .offer-details {
            margin-bottom: 20px;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8fafc;
            font-weight: bold;
            color: #333;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #718096;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">

        {{-- Header con Logo y Título --}}
        <div class="header">
            <div class="logo">
                <img src="{{ public_path('images/logo-upeu-dark-svg.svg') }}" alt="Logo UPEU">
            </div>
            <div class="title">
                <h1>Reporte de <span>tus Postulantes</span></h1>
                <p>Fecha y hora: {{ now()->format('d-m-Y H:i:s') }}</p> <!-- Muestra la fecha y hora -->
            </div>
        </div>

        {{-- Información de la Oferta --}}
        <div class="offer-details">
            <h2>Oferta: {{ $oferta->titulo }}</h2>
            <p><strong>Empresa:</strong> {{ $oferta->empresa }}</p>
            <p><strong>Ubicación:</strong> {{ $oferta->ubicacion }}</p>
        </div>

        {{-- Tabla de Postulantes --}}
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha de Postulación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($postulaciones as $index => $postulacion)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $postulacion->user->name }}</td>
                    <td>{{ $postulacion->user->email }}</td>
                    <td>{{ $postulacion->created_at->format('d-m-Y H:i:s') }}</td> <!-- Mostrar fecha y hora de postulación -->
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Footer --}}
        <div class="footer">
            <p>&copy; {{ date('Y') }} BolsaUPeU. Todos los derechos reservados.</p>
        </div>

    </div>
</body>
</html>
