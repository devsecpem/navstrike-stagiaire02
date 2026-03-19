<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>NavStrike - Systeme de Ciblage FREMM</title>
</head>
<body>
    <header>
        <h1>NavStrike</h1>
        <nav>
            <a href="?page=home">CIC</a>
            <a href="?page=targets">Cibles</a>
            <a href="?page=missiles">Missiles</a>
            <a href="?page=radar">Radar</a>
            <a href="?page=missions">Missions</a>
            <a href="?page=crew">Equipage</a>
            <a href="?page=login">Connexion</a>
        </nav>
    </header>
    <main>
        <?php echo $content ?? ''; ?>
    </main>
</body>
</html>
