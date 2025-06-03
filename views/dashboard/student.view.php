<?php component('header') ?>
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow-sm border mb-8">
            <div class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h1 class="text-2xl font-bold">Skolēna skats</h1>
                    <p class="text-gray-600">Skolēns: <?= $_SESSION['user']['first_name'] ?? '' ?> <?= $_SESSION['user']['last_name'] ?? '' ?></p>
                </div>
                <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-gray-700">
                    Skolēns
                </span>
                </div>
            </div>
        </div>

        <!-- Recent Grades Section -->
        <div class="bg-white rounded-lg shadow-sm border mb-8">
            <div class="p-4 border-b">
                <h2 class="text-lg font-medium flex items-center">
                    Jaunākās atzīmes
                </h2>
            </div>
            <div class="p-4">
                <?php if (empty($newestGrades)): ?>
                    <p class="text-gray-500 text-center py-8">Nav atzīmju</p>
                <?php else: ?>
                    <div class="grid gap-4">
                        <?php foreach ($newestGrades as $grade): ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <div class="font-medium"><?= htmlspecialchars($grade['subject_name']) ?></div>
                                    <div class="text-sm text-gray-500">Skolotājs: <?= htmlspecialchars($grade['teacher_name']) ?></div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        Pievienots: <?= $grade['created_at'] ? date('d.m.Y H:i', strtotime($grade['created_at'])) : 'Nav norādīts' ?>
                                        <?php if ($grade['updated_at'] && $grade['updated_at'] !== $grade['created_at']): ?>
                                            <br>Atjaunots: <?= date('d.m.Y H:i', strtotime($grade['updated_at'])) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-2xl font-bold text-blue-600">
                                    <?= number_format($grade['grade'], 2) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Filters -->
        <form method="get" class="bg-white rounded-lg shadow-sm border mb-8" id="filterForm">
            <div class="p-4 border-b">
                <h2 class="text-lg font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22,3 2,3 10,12.46 10,19 14,21 14,12.46 22,3"></polygon>
                    </svg>
                    Filtri
                </h2>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priekšmets</label>
                        <select name="subject" id="subjectFilter" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                            <option value="">Visi priekšmeti</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject['id'] ?>" <?= (($_GET['subject'] ?? '') == $subject['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($subject['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex items-end gap-4">
                        <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Filtrēt</button>
                        <button type="button" id="exportButton" class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">Eksportēt atzīmes</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tabs -->
        <div class="mb-6">
            <div class="border-b">
                <div class="flex -mb-px">
                    <button type="button" id="gradesTab" class="tab-button active py-2 px-4 text-sm font-medium border-b-2 border-blue-500 text-blue-600">Visas atzīmes</button>
                    <button type="button" id="averagesTab" class="tab-button py-2 px-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Vidējās atzīmes</button>
                </div>
            </div>
        </div>

        <!-- All Grades Tab Content -->
        <div id="gradesContent" class="tab-content">
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-medium">Visas atzīmes</h2>
                </div>
                <div class="p-4">
                    <div class="rounded-md border overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200" id="gradesTable">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priekšmets</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skolotājs</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Atzīme</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pievienots</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Atjaunots</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            // Apply subject filter
                            $subjectFilter = $_GET['subject'] ?? '';
                            $filteredGrades = [];

                            foreach ($allGrades as $grade) {
                                if ($subjectFilter && $grade['subject_id'] != $subjectFilter) continue;
                                $filteredGrades[] = $grade;
                            }

                            if (empty($filteredGrades)): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Nav atzīmju, kas atbilst atlasītajiem kritērijiem</td>
                                </tr>
                            <?php else:
                                foreach ($filteredGrades as $grade): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($grade['subject_name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($grade['teacher_name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium"><?= number_format($grade['grade'], 2) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            <?= $grade['created_at'] ? date('d.m.Y H:i', strtotime($grade['created_at'])) : 'Nav norādīts' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            <?= $grade['updated_at'] ? date('d.m.Y H:i', strtotime($grade['updated_at'])) : 'Nav norādīts' ?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Averages Tab Content -->
        <div id="averagesContent" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-medium">Vidējās atzīmes pa priekšmetiem</h2>
                </div>
                <div class="p-4">
                    <div class="rounded-md border overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200" id="averagesTable">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priekšmets</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Atzīmju skaits</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Vidējā atzīme</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($subjectAverages)): ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Nav atzīmju</td>
                                </tr>
                            <?php else:
                                foreach ($subjectAverages as $subjectAvg): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($subjectAvg['subject_name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500"><?= $subjectAvg['count'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium"><?= number_format($subjectAvg['average'], 2) ?></td>
                                    </tr>
                                <?php endforeach;
                            endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                button.classList.add('active', 'border-blue-500', 'text-blue-600');
                button.classList.remove('border-transparent', 'text-gray-500');
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                const contentId = button.id.replace('Tab', 'Content');
                document.getElementById(contentId).classList.remove('hidden');
            });
        });

        // Export CSV
        document.getElementById('exportButton').addEventListener('click', () => {
            let csvContent = '';
            if (!document.getElementById('gradesContent').classList.contains('hidden')) {
                csvContent = 'Priekšmets,Skolotājs,Atzīme,Pievienots,Atjaunots\n';
                document.querySelectorAll('#gradesTable tbody tr').forEach(row => {
                    if (row.children.length === 5) {
                        const cells = Array.from(row.children);
                        csvContent += cells.map(td => td.textContent.trim()).join(',') + '\n';
                    }
                });
            } else {
                csvContent = 'Priekšmets,Atzīmju skaits,Vidējā atzīme\n';
                document.querySelectorAll('#averagesTable tbody tr').forEach(row => {
                    if (row.children.length === 3) {
                        const cells = Array.from(row.children);
                        csvContent += cells.map(td => td.textContent.trim()).join(',') + '\n';
                    }
                });
            }
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', 'manas_atzimes.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Auto-submit form when subject changes
        document.getElementById('subjectFilter').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    </script>
<?php component('footer') ?>