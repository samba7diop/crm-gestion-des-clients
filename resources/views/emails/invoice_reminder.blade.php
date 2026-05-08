<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relance facture</title>
</head>
<body>
    <p>Bonjour,</p>
    <p>Nous vous rappelons que la facture <strong>#{{ $invoice->numero }}</strong> d'un montant de <strong>{{ number_format($invoice->montant, 2, ',', ' ') }} €</strong> est en attente de paiement.</p>
    <p>Échéance : {{ $invoice->date_echeance->format('d/m/Y') }}</p>
    <p>Merci de nous contacter si vous avez besoin d'informations complémentaires.</p>
    <p>Cordialement,<br>Équipe CRM Gestion Clients</p>
</body>
</html>
