<?php component('header'); ?>
    <section class="max-w-xl mx-auto my-8">
        <div class="bg-white border border-gray-200 rounded shadow p-6 space-y-6">
            <div class="flex items-center gap-4">
                <img
                        src="<?= htmlspecialchars($user['image'] ?? '/images/default.png') ?>"
                        alt="Lietotāja bilde"
                        class="h-16 w-16 rounded-full object-cover border border-orange-500 bg-gray-100 p-1"
                >
                <div>
                    <h1 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h1>
                    <div class="text-sm text-gray-600"><?= ($user['role'] === "teacher") ? "Skolotājs" : ucfirst($user['role']) ?></div>
                </div>
            </div>

            <dl class="divide-y divide-gray-100">
                <div class="flex justify-between py-2">
                    <dt class="text-gray-500 pr-3">E-pasts</dt>
                    <dd class="font-medium text-gray-900"><?= htmlspecialchars($user['email']) ?></dd>
                </div>
            </dl>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold mb-4">Profila attēls</h2>
                <form action="/user/image" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Augšupielādēt attēlu</label>
                        <input type="file" name="image" accept="image/*" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">VAI ievadiet attēla URL</label>
                        <input type="url" name="url" placeholder="https://example.com/image.jpg"
                               class="w-full border rounded p-2">
                    </div>
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                        Saglabāt izmaiņas
                    </button>
                </form>
            </div>


        </div>
    </section>

<?php component('footer'); ?>