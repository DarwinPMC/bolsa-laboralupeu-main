<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Aprobada - BolsaUpeu</title>
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
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0056b3;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
        }
         .highlight {
            color: #28a745; /* Cambiado a verde */
            font-weight: bold;
        }
        .cta-button {
            display: block;
            background-color: #0056b3;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            text-align: center;
        }
        .cta-button:hover {
            background-color: #004494;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
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
        <h1>¡Bienvenido a BolsaUpeu, {{ $nombreUsuario }}!</h1>

        <p>Nos complace enormemente informarte que tu cuenta ha sido <span class="highlight">aprobada con éxito</span>. A partir de este momento, tendrás acceso completo a todas las funcionalidades y herramientas que nuestra plataforma <strong>BolsaUpeu</strong> ha desarrollado para apoyarte en el logro de tus metas profesionales.</p>

        <p>En <strong>BolsaUpeu</strong>, valoramos tu tiempo y esfuerzo, por lo que hemos diseñado una experiencia intuitiva, accesible y centrada en el usuario. Nuestra plataforma te permitirá no solo gestionar tus proyectos de manera eficiente, sino también descubrir nuevas oportunidades y conectarte con una amplia red de profesionales y empresas líderes en su sector.</p>

        <p>Te invitamos a <strong>personalizar tu perfil</strong> y explorar todas las funciones disponibles que hemos creado pensando en ti. Desde herramientas de seguimiento de proyectos hasta opciones avanzadas de búsqueda de oportunidades, estamos seguros de que encontrarás todo lo necesario para avanzar en tu carrera profesional.</p>

        <p>Agradecemos sinceramente tu confianza en nuestra plataforma y estamos entusiasmados de que formes parte de nuestra comunidad. Esperamos que esta nueva etapa marque el inicio de una colaboración exitosa y duradera.</p>

        <!-- Botón de llamada a la acción para comenzar a usar la plataforma -->
        <a href="http://localhost:8000" class="cta-button">Comienza a Usar BolsaUpeu</a>

        <div class="footer">
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</body>
</html>
