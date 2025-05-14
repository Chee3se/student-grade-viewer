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
                <h2 class="text-lg font-semibold mb-4">Nomainīt profila attēlu</h2>
                <form action="/user/image" method="POST" enctype="multipart/form-data" class="space-y-4 flex flex-col">
                    <div class="flex gap-4 items-start">
                        <div class="flex-1 mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profila bilde</label>
                            <div class="relative">
                                <input type="file" name="image" accept="image/*" class="hidden" id="imageInput" required
                                       onchange="previewImage(this)">
                                <label for="imageInput"
                                       class="cursor-pointer bg-white px-4 py-2 border rounded flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Izvēlēties attēlu
                                </label>
                            </div>
                            <?= error('image') ?>
                        </div>
                        <div class="w-32 h-32 border rounded-full border-2 border-green-200 bg-gray-100 p-1 overflow-hidden bg-gray-50 flex items-center justify-center">
                            <img id="preview" src="#" alt="Priekšskatījums" class="w-full h-full rounded-full object-cover hidden">
                            <span id="placeholder" class="text-sm text-gray-400">Jaunais attēls</span>
                        </div>
                    </div>
                    <button type="submit"
                            class="bg-gray-200 border-2 border-gray-400 text-gray-500 px-6 py-2 mx-auto rounded-3xl hover:bg-green-300 hover:border-green-500 hover:text-green-600 hover:scale-105 transition duration-200">
                        Saglabāt
                    </button>
                </form>
                <script>
                    function previewImage(input) {
                        const preview = document.getElementById('preview');
                        const placeholder = document.getElementById('placeholder');
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                preview.src = e.target.result;
                                preview.classList.remove('hidden');
                                placeholder.classList.add('hidden');
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold mb-4">Atjaunināt paroli</h2>
                <form action="/user/password" method="POST" enctype="multipart/form-data"
                      class="space-y-4 flex flex-col">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pašreizējā parole</label>
                        <div class="relative">
                            <input type="password" name="password" id="currentPassword"
                                   class="w-full border rounded p-2" required>
                            <button type="button" onclick="togglePassword('currentPassword')"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <?= error('password') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jaunā parole</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="newPassword"
                                   class="w-full border rounded p-2" required>
                            <button type="button" onclick="togglePassword('newPassword')"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <?= error('new_password') ?>
                    </div>
                    <button type="submit"
                            class="bg-gray-200 border-2 border-gray-400 text-gray-500 px-6 py-2 mx-auto rounded-3xl hover:bg-green-300 hover:border-green-500 hover:text-green-600 hover:scale-105 transition duration-200">
                        Saglabāt
                    </button>
                </form>

                <script>
                    function togglePassword(inputId) {
                        const input = document.getElementById(inputId);
                        input.type = input.type === 'password' ? 'text' : 'password';
                    }
                </script>
            </div>

        </div>
    </section>

<?php component('footer'); ?>