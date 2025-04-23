<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta lang="en" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/index.css" type="text/css" />
    <title><?= $title ?? 'Studio Class' ?></title>
</head>
<body class="flex flex-col min-h-screen">
<header class="bg-white shadow">
    <?php component('navbar'); ?>
</header>
<main>