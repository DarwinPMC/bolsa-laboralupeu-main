<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postulación Aceptada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            max-width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0056b3;
            font-size: 24px;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }
        .offer-title {
            font-weight: bold;
            color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #0056b3;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Felicidades, {{ $nombre }}!</h1>
        <p>Nos complace informarte que tu postulación para la oferta <span class="offer-title">{{ $oferta }}</span> ha sido <strong>aceptada</strong>.</p>
        <p>En breve, uno de nuestros representantes se pondrá en contacto contigo para proporcionarte más detalles sobre los próximos pasos a seguir.</p>
        <p>Agradecemos tu interés en ser parte de nuestro equipo y esperamos colaborar contigo pronto.</p>
        <p>Si tienes alguna duda o necesitas más información, no dudes en contactarnos.</p>
        <p>Atentamente,<br>El equipo de Reclutamiento</p>
    </div>
    <img src="{{ url('/correos/' . $correo->id . '/leido') }}" alt="tracker" style="display:none;" width="1" height="1">

    <div class="footer">
        <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        <p>Si necesitas asistencia, puedes visitar nuestro <a href="https://www.tuempresa.com/soporte">Centro de Soporte</a>.</p>
    </div>
</body>
</html>
