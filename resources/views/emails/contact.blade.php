<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Consulta</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; padding: 20px; background-color: #f9fafb;">
<div style="max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 4px; overflow: hidden; background-color: #ffffff;">
    <div style="background-color: #0d9488; color: white; padding: 15px 20px;">
        <h2 style="margin: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Nueva Consulta desde el Sitio Web</h2>
    </div>

    <div style="padding: 20px;">
        <p style="margin-top: 0; font-size: 13px;">Se ha registrado una nueva consulta a través del formulario de contacto:</p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px;">
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280; width: 35%;"><strong>Apoderado:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; color: #1f2937;">{{ $contact->nombre }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280;"><strong>Teléfono:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; color: #1f2937;">{{ $contact->telefono }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280;"><strong>Correo:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; color: #1f2937;">{{ $contact->correo }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280;"><strong>Nivel de Interés:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; color: #1f2937;">{{ $contact->nivel }}</td>
            </tr>
        </table>

        <h3 style="font-size: 13px; margin-bottom: 8px; color: #1f2937; text-transform: uppercase;">Mensaje o Consulta:</h3>
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 4px; border: 1px solid #e5e7eb; font-size: 13px; color: #4b5563; white-space: pre-wrap;">{{ $contact->mensaje }}</div>
    </div>

    <div style="background-color: #f9fafb; padding: 12px 20px; text-align: center; font-size: 11px; color: #9ca3af; border-top: 1px solid #e5e7eb;">
        Este es un correo automático generado por el sistema de la I.E.I. N° 31756 Ricardo Palma.
    </div>
</div>
</body>
</html>
