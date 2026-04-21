<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body style="margin:0; padding:24px; background:#f8fafc; font-family:Arial, sans-serif; color:#0f172a;">
    <div style="max-width:680px; margin:0 auto; background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
        <div style="background:#0f2540; color:#ffffff; padding:16px 20px; font-weight:700;">
            Nuevo mensaje desde el formulario de contacto
        </div>
        <div style="padding:20px; line-height:1.55;">
            <p style="margin-top:0;"><strong>Nombre:</strong> {{ $contactMessage->name }}</p>
            <p><strong>Correo:</strong> {{ $contactMessage->email }}</p>
            <p><strong>Telefono:</strong> {{ $contactMessage->phone ?: 'No proporcionado' }}</p>
            <p><strong>Asunto:</strong> {{ $contactMessage->subject ?: 'Sin asunto' }}</p>
            <p><strong>Fecha:</strong> {{ $contactMessage->created_at->format('d/m/Y H:i') }}</p>
            <hr style="border:none; border-top:1px solid #e2e8f0; margin:16px 0;">
            <p style="margin-bottom:6px;"><strong>Mensaje:</strong></p>
            <p style="margin:0; white-space:pre-line;">{{ $contactMessage->message }}</p>
        </div>
    </div>
</body>
</html>
