<?php component('header'); ?>
<div class="container mx-auto px-4 py-16 text-center">
    <h1 class="text-6xl font-bold mb-6">
        <?= $code ?? 404 ?> <?= $message ?? 'Page not found' ?>
    </h1>
    
    <p class="text-xl mb-8">
        <?= $description ?? 'The page you are looking for does not exist.' ?>
    </p>
</div>
<?php component('footer'); ?>