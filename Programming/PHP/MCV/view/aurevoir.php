<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Au revoir</title>
</head>

<body>
    <h2>👋 Au revoir<?= $user->getName() ?> !</h2>
    <p><?= htmlspecialchars($message) ?></p>
    <p>À bientôt !</p>
    <?php if ($user->getIdVisiteur()): ?>
        <p><small>ID Visiteur : <?= $user->getIdVisiteur() ?></small></p>
    <?php endif; ?>

</body>

</html>