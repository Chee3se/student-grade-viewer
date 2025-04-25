<!doctype html>
<html lang="lv">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StudioClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="/css/index.css" />
    <link rel="script" href="/js/index.js" />
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    <title><?= $title ?? 'Studio Class' ?></title>
  </head>
<body class="flex flex-col min-h-screen">
  <?php component('navbar'); ?>
  <main class="flex-1 flex flex-col justify-center items-center">
