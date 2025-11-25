<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Bonjour</title>
</head>

<body>
    <h2>👋 Bonjour <?= $user->getName() ?> !</h2>
    <p>Comment ça va aujourd'hui ?</p>
    <p>Nous sommes le <?= htmlspecialchars(date('d/m/Y à H:i')) ?></p>
    <?php if ($user->getIdVisiteur()): ?>
        <p><small>ID Visiteur : <?= $user->getIdVisiteur() ?></small></p>
    <?php endif; ?>
</body>

</html>