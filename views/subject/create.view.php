<?php component('header'); ?>
    <div class="container mx-auto px-4 py-8 max-w-md">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-green-600 text-white px-6 py-4 relative">
                <h1 class="text-xl font-medium">Pievienot jaunu priekšmetu</h1>
                <div class="absolute -bottom-1 left-0 right-0 h-1 bg-green-400"></div>
            </div>
            <div class="p-6">
                <?= error('form') ?>
                <form method="POST" action="/subjects" id="subjectForm">
                    <div class="mb-6">
                        <label for="name" class="block mb-2 font-medium text-gray-700">Priekšmeta nosaukums:</label>
                        <input type="text" id="name" name="name" required maxlength="50"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               value="<?= old('name') ?>">
                        <?= error('name') ?>
                    </div>
                    <div class="mb-6">
                        <label for="description" class="block mb-2 font-medium text-gray-700">Apraksts:</label>
                        <textarea id="description" name="description" required maxlength="255" rows="4"
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"><?= old('description') ?></textarea>
                        <?= error('description') ?>
                    </div>
                    <div class="mb-6">
                        <label for="user_id" class="block mb-2 font-medium text-gray-700">Skolotājs:</label>
                        <select id="user_id" name="user_id" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Izvēlieties skolotāju...</option>
                            <?php foreach ($teachers as $teacher): ?>
                                <option value="<?= $teacher['id'] ?>" <?= old('user_id') == $teacher['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('user_id') ?>
                    </div>
                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 uppercase tracking-wide">
                        Saglabāt
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php component('footer'); ?>