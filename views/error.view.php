<?php component('header'); ?>
<div class="container mx-auto px-4 py-16 text-center">
    <h1 class="text-6xl font-bold mb-6">
        <?= $code ?? 404 ?> <?= $message ?? 'Lapa nav atrasta' ?>
    </h1>
    
    <p class="text-xl mb-8">
        <?= $description ?? 'Lapa, ko cenšaties meklēt netika atrasta' ?>
    </p>
</div>
<?php component('footer'); ?>