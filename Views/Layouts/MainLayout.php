<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? 'Mini Web' ?>
    </title>

    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <header>
        <nav>
            <a href="/">Home</a>
            <a href="/invoice">Invoices</a>
            <a href="/users/create">email

            </a>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <p>&copy;
            <?= date('Y') ?> Mini Web
        </p>
    </footer>

</body>

</html>