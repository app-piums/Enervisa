<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hemos recibido tu mensaje</title>
</head>
<body style="margin:0; padding:24px; background:#f8fafc; font-family:Arial, sans-serif; color:#0f172a;">
    <div style="max-width:680px; margin:0 auto; background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
        <div style="background:#1b3a5c; color:#ffffff; padding:16px 20px; font-weight:700;">
            Enervisa
        </div>
        <div style="padding:20px; line-height:1.6;">
            <p style="margin-top:0;">Hola {{ $contactMessage->name }},</p>
            <p>Hemos recibido tu correo y nos estaremos comunicando brevemente.</p>
            <p>Gracias por escribirnos y confiar en Enervisa.</p>
            <p style="margin-bottom:0;">Saludos,<br>Equipo Enervisa</p>
        </div>
    </div>
</body>
</html>
