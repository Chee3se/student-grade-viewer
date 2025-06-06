<?php component('header'); ?>
    <div class="container mx-auto px-4 py-8 max-w-md">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-orange-500 text-white px-6 py-4 relative">
                <h1 class="text-xl font-medium">Pievienot jaunu lietotāju</h1>
                <div class="absolute -bottom-1 left-0 right-0 h-1 bg-orange-300"></div>
            </div>
            <div class="p-6">
                <?= error('form') ?>
                <form method="POST" action="/users" id="userForm">
                    <div class="mb-6">
                        <label for="first_name" class="block mb-2 font-medium text-gray-700">Vārds:</label>
                        <input type="text" id="first_name" name="first_name" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               placeholder="Ievadiet vārdu">
                        <?= error('first_name') ?>
                    </div>
                    <div class="mb-6">
                        <label for="last_name" class="block mb-2 font-medium text-gray-700">Uzvārds:</label>
                        <input type="text" id="last_name" name="last_name" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               placeholder="Ievadiet uzvārdu">
                        <?= error('last_name') ?>
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block mb-2 font-medium text-gray-700">E-pasts:</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               placeholder="Ievadiet e-pasta adresi">
                        <?= error('email') ?>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block mb-2 font-medium text-gray-700">Parole:</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               placeholder="Ievadiet paroli">
                        <?= error('password') ?>
                    </div>
                    <button type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 uppercase tracking-wide">
                        Izveidot
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php component('footer'); ?>