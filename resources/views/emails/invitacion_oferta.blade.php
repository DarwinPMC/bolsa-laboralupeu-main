<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitación a postularte</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <tr>
            <td style="background-color: #004080; padding: 20px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">Invitación a postularte</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; color: #333333;">
                <p>Hola {{ $nombreUsuario }},</p>
                <p>La empresa <strong>{{ auth()->user()->empresa }}</strong> te invita a postularte a la oferta laboral <strong>"{{ $oferta->titulo }}"</strong>.</p>

                <h3 style="color: #004080;">Descripción del puesto</h3>
                <p style="line-height: 1.6;">{{ $oferta->descripcion }}</p>

                <p style="text-align: center; margin-top: 30px;">
                    <a href="{{ $urlOferta }}" style="background-color: #004080; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">Ver oferta y postularme</a>
                </p>

                <p style="margin-top: 30px;">Para más información, por favor visita nuestra plataforma.</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f4f4f4; padding: 20px; text-align: center; color: #888888;">
                <p style="margin: 0;">Atentamente,</p>
                <p style="margin: 5px 0 20px;"><strong>El equipo de {{ config('app.name') }}</strong></p>
                <p style="font-size: 12px;">{{ config('app.name') }} | {{ config('app.url') }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
