<!DOCTYPE html>
<html>
<head>
    <title>Reporte PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif; /* Soporte UTF-8 para acentos */
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #2C3E50;
        }

        p {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <h2>Reporte de {{ $tipoReporte === 'postulantes' ? 'Postulantes' : 'Empresas' }}</h2>
    <p>Desde: {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - Hasta: {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                @if($tipoReporte === 'empresas')
                    <th>RUC</th>
                @endif
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipoReporte === 'postulantes' ? $postulantes : $empresas as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    @if($tipoReporte === 'empresas')
                        <td>{{ $item->ruc }}</td>
                    @endif
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
