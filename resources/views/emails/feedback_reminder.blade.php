<!DOCTYPE html>
<html>
<head>
    <title>Rappel : Votre avis compte pour nous !</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #2b6cb0;">Comment s'est passée votre intervention ?</h2>
        
        <p>Bonjour <strong>{{ $userName }}</strong>,</p>
        
        <p>L'intervention de babysitting du <strong>{{ $dateIntervention }}</strong> est maintenant terminée.</p>
        
        <p>Pour garantir la qualité de service sur Helpora, il est important de laisser un avis sur votre expérience avec <strong>{{ $targetName }}</strong>.</p>
        
        <p>Cela ne prendra que quelques instants !</p>
        
        <p style="margin-top: 30px; text-align: center;">
            <a href="{{ $feedbackUrl }}" style="background-color: #38a169; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">Donner mon avis</a>
        </p>
        
        <p style="margin-top: 20px;">
            Si le lien ne fonctionne pas, copiez-collez l'adresse suivante dans votre navigateur :<br>
            <span style="color: #718096; font-size: 12px;">{{ $feedbackUrl }}</span>
        </p>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #718096;">Ceci est un message automatique. Merci de ne pas y répondre directement.</p>
    </div>
</body>
</html>
