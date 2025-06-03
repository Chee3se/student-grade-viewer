<?php component('header'); ?>
    <div class="container mx-auto px-4 py-8 max-w-md">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-orange-500 text-white px-6 py-4 relative">
                <h1 class="text-xl font-medium">Labot atzīmi</h1>
                <div class="absolute -bottom-1 left-0 right-0 h-1 bg-orange-300"></div>
            </div>
            <div class="p-6">
                <?= error('form') ?>
                <form method="POST" action="/grades/<?= $grade['id'] ?>" id="gradeForm">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-6">
                        <label for="user_id" class="block mb-2 font-medium text-gray-700">Skolēns:</label>
                        <select id="user_id" name="user_id" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Izvēlieties skolēnu</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= ($grade['user_id'] == $user['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user['last_name'] . ' ' . $user['first_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('user_id') ?>
                    </div>
                    <div class="mb-6">
                        <label for="subject_id" class="block mb-2 font-medium text-gray-700">Priekšmets:</label>
                        <select id="subject_id" name="subject_id" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Izvēlieties priekšmetu</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject['id'] ?>" <?= ($grade['subject_id'] == $subject['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($subject['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('subject_id') ?>
                    </div>
                    <div class="mb-6">
                        <label for="grade" class="block mb-2 font-medium text-gray-700">Atzīme:</label>
                        <input type="number" id="grade" name="grade" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               value="<?= htmlspecialchars($grade['grade']) ?>">
                        <?= error('grade') ?>
                    </div>
                    <button type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 uppercase tracking-wide">
                        Saglabāt izmaiņas
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php component('footer'); ?>