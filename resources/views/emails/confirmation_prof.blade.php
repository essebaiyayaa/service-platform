<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f7; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background-color: #1E40AF; padding: 20px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .status-box { text-align: center; padding: 15px; border-radius: 6px; margin-bottom: 25px; }
        .success { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .error { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table td { padding: 12px 0; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; color: #555; width: 40%; }
        .value { color: #000; font-weight: 500; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #888; }
        .contact-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; margin-top: 20px; }
        .tips-box { background-color: #fef3c7; border: 1px solid #fcd34d; padding: 15px; border-radius: 6px; margin-top: 20px; }
        .tips-box ul { margin: 10px 0; padding-left: 20px; }
        .tips-box li { margin: 5px 0; color: #78350f; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Helpora</h1>
        </div>
        
        <div class="content">
            <p>Bonjour <strong>{{ $data['prof_nom'] }}</strong>,</p>

            @if($data['statut'] === 'validée')
                <div class="status-box success">
                    <strong>Bonne nouvelle !</strong><br>
                    Vous avez accepté une nouvelle mission. Voici votre feuille de route :
                </div>

                <table class="details-table">
                    <tr>
                        <td class="label">Matière</td>
                        <td class="value">{{ $data['matiere'] }} ({{ $data['niveau'] }})</td>
                    </tr>
                    <tr>
                        <td class="label">Date & Heure</td>
                        <td class="value">{{ $data['date'] }} de {{ $data['heure_debut'] }} à {{ $data['heure_fin'] }}</td>
                    </tr>
                    <tr>
                        <td class="label">Lieu</td>
                        <td class="value">
                            @if($data['type_service'] === 'enligne')
                                Cours en ligne (Visioconférence)
                            @else
                                {{ $data['client_adresse'] }}, {{ $data['client_ville'] }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Revenu Net</td>
                        <td class="value"><strong>{{ $data['prix'] }} DH</strong></td>
                    </tr>
                </table>

                <div class="contact-box">
                    <strong>📋 Coordonnées de votre élève :</strong><br><br>
                    <strong>{{ $data['client_nom'] }}</strong><br>
                    @if($data['type_service'] === 'domicile')
                        Adresse : {{ $data['client_adresse'] }}, {{ $data['client_ville'] }}<br>
                    @endif
                    Téléphone : <a href="tel:{{ $data['client_tel'] }}">{{ $data['client_tel'] }}</a><br>
                    Email : <a href="mailto:{{ $data['client_email'] }}">{{ $data['client_email'] }}</a>
                </div>

                <p style="margin-top: 20px; font-size: 14px; color: #666;">
                    Le professeur prendra contact avec vous rapidement pour finaliser les détails.
                </p>

            @else
                <div class="status-box error">
                    <strong>Demande refusée</strong><br>
                    Vous avez refusé la demande de cours suivante.
                </div>

                <table class="details-table">
                    <tr>
                        <td class="label">Matière</td>
                        <td class="value">{{ $data['matiere'] }} ({{ $data['niveau'] }})</td>
                    </tr>
                    <tr>
                        <td class="label">Date & Heure</td>
                        <td class="value">{{ $data['date'] }} de {{ $data['heure_debut'] }} à {{ $data['heure_fin'] }}</td>
                    </tr>
                    <tr>
                        <td class="label">Montant</td>
                        <td class="value">{{ $data['prix'] }} DH</td>
                    </tr>
                </table>

                <p style="font-size: 14px; color: #666;">
                    Cette demande a bien été enregistrée comme refusée dans votre historique.
                </p>
            @endif

        </div>

        <div class="footer">
            © {{ date('Y') }} Helpora Inc. Tous droits réservés.<br>
            Ceci est un email automatique, merci de ne pas y répondre.
        </div>
    </div>
</body>
</html>