<?php component('header') ?>
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow-sm border mb-8">
            <div class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h1 class="text-2xl font-bold">Skolotāja skats</h1>
                    <p class="text-gray-600">Skolotājs: <?= $_SESSION['user']['first_name'] ?? '' ?> <?= $_SESSION['user']['last_name'] ?? '' ?></p>
                </div>
                <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-gray-700">
                    Skolotājs
                </span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <form method="get" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8" id="filterForm">
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Skolēnu filtrs
                    </h2>
                </div>
                <div class="p-4">
                    <input type="text" name="name" value="<?= htmlspecialchars($_GET['name'] ?? '') ?>" placeholder="Meklēt pēc vārda vai uzvārda" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path>
                        </svg>
                        Priekšmetu filtrs
                    </h2>
                </div>
                <div class="p-4">
                    <select name="subject" id="subjectFilter" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                        <option value="">Visi priekšmeti</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>" <?= (($_GET['subject'] ?? '') == $subject['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($subject['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-span-2 flex justify-end gap-4">
                <a href="/users/create" class="inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600">Pievienot skolēnu</a>
                <a href="/grades/create" class="mr-auto inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600">Pievienot atzīmi</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Filtrēt</button>
                <button type="button" id="exportButton" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Eksportēt atzīmes</button>
            </div>
        </form>

        <!-- Tabs -->
        <div class="mb-6">
            <div class="border-b">
                <div class="flex -mb-px">
                    <button type="button" id="gradesTab" class="tab-button active py-2 px-4 text-sm font-medium border-b-2 border-blue-500 text-blue-600">Atzīmes</button>
                    <button type="button" id="averagesTab" class="tab-button py-2 px-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Vidējās atzīmes</button>
                </div>
            </div>
        </div>

        <!-- Grades Tab Content -->
        <div id="gradesContent" class="tab-content">
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-medium">Atzīmes</h2>
                </div>
                <div class="p-4">
                    <div class="rounded-md border overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200" id="gradesTable">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skolēns</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priekšmets</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Atzīme</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Darbības</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            // Prepare filters
                            $nameFilter = strtolower($_GET['name'] ?? '');
                            $subjectFilter = $_GET['subject'] ?? '';
                            $studentMap = [];
                            foreach ($students as $s) {
                                $studentMap[$s['id']] = $s;
                            }
                            $subjectMap = [];
                            foreach ($subjects as $s) {
                                $subjectMap[$s['id']] = $s;
                            }
                            // Filter and render grades
                            $filteredGrades = [];
                            foreach ($grades as $grade) {
                                $student = $studentMap[$grade['user_id']] ?? null;
                                $subject = $subjectMap[$grade['subject_id']] ?? null;
                                if (!$student || !$subject) continue;
                                $studentName = strtolower($student['first_name'] . ' ' . $student['last_name']);
                                if ($nameFilter && strpos($studentName, $nameFilter) === false) continue;
                                if ($subjectFilter && $grade['subject_id'] != $subjectFilter) continue;
                                $filteredGrades[] = [
                                    'id' => $grade['id'],
                                    'student' => $student,
                                    'subject' => $subject,
                                    'grade' => $grade['grade']
                                ];
                            }
                            if (empty($filteredGrades)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Nav atzīmju, kas atbilst atlasītajiem kritērijiem</td>
                                </tr>
                            <?php else:
                                // Optional: sort by student name
                                usort($filteredGrades, function($a, $b) {
                                    return strcmp($a['student']['last_name'], $b['student']['last_name']);
                                });
                                foreach ($filteredGrades as $row): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($row['student']['first_name'] . ' ' . $row['student']['last_name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($row['subject']['name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium"><?= number_format($row['grade'], 2) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            <div class="flex justify-center space-x-2">
                                                <a href="/grades/<?= $row['id'] ?>/edit"
                                                   class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 hover:border-blue-300 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                    Labot
                                                </a>
                                                <form method="POST" action="/grades/<?= $row['id'] ?>" class="inline-block"
                                                      onsubmit="return confirm('Vai tiešām vēlaties dzēst šo atzīmi?')">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 hover:border-red-300 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3,6 5,6 21,6"></polyline>
                                                            <path d="M19,6v14a2,2 0 0,1 -2,2H7a2,2 0 0,1 -2,-2V6m3,0V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                        Dzēst
                                                    </button>
                                                </form>
                                            </div>
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
                <div class="p-4 border-b flex justify-between items-center">
                    <h2 class="text-lg font-medium">Vidējās atzīmes pa priekšmetiem</h2>
                    <a href="/subject/create" class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Pievienot priekšmetu
                    </a>
                </div>
                <div class="p-4">
                    <div class="rounded-md border overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200" id="averagesTable">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priekšmets</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Vidējā atzīme</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Darbības</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            if (empty($subjects)): ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Nav pievienotu priekšmetu</td>
                                </tr>
                            <?php else:
                                foreach ($subjects as $subject):
                                    $subjectGrades = array_filter($grades, function($g) use ($subject) {
                                        return $g['subject_id'] == $subject['id'];
                                    });

                                    // Set default for a subject with no grades - this ensures all subjects appear
                                    $avg = 0;
                                    $gradeCount = count($subjectGrades);

                                    if ($gradeCount > 0) {
                                        $avg = array_sum(array_column($subjectGrades, 'grade')) / $gradeCount;
                                    }
                                    ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($subject['name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">
                                            <?= $gradeCount > 0 ? number_format($avg, 2) : 'Nav atzīmju' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            <div class="flex justify-center space-x-2">
                                                <a href="/subjects/<?= $subject['id'] ?>/edit"
                                                   class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 hover:border-blue-300 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                    Labot
                                                </a>
                                                <form method="POST" action="/subjects/<?= $subject['id'] ?>" class="inline-block"
                                                      onsubmit="return confirm('Vai tiešām vēlaties dzēst šo priekšmetu? Visas ar to saistītās atzīmes tiks dzēstas!')">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 hover:border-red-300 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3,6 5,6 21,6"></polyline>
                                                            <path d="M19,6v14a2,2 0 0,1 -2,2H7a2,2 0 0,1 -2,-2V6m3,0V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                        Dzēst
                                                    </button>
                                                </form>
                                            </div>
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
                csvContent = 'Skolēns,Priekšmets,Atzīme\n';
                document.querySelectorAll('#gradesTable tbody tr').forEach(row => {
                    if (row.children.length === 4) { // Updated to account for actions column
                        const cells = Array.from(row.children).slice(0, 3); // Only export first 3 columns
                        csvContent += cells.map(td => td.textContent.trim()).join(',') + '\n';
                    }
                });
            } else {
                csvContent = 'Priekšmets,Vidējā atzīme\n';
                document.querySelectorAll('#averagesTable tbody tr').forEach(row => {
                    if (row.children.length === 3) { // Updated to account for actions column
                        const cells = Array.from(row.children).slice(0, 2); // Only export first 2 columns
                        csvContent += cells.map(td => td.textContent.trim()).join(',') + '\n';
                    }
                });
            }
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', 'atzimes.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Auto-submit form when subject changes
        document.getElementById('subjectFilter').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Add auto-submit to name filter as well (optional, for consistent behavior)
        document.querySelector('input[name="name"]').addEventListener('input', function() {
            // Use a slight delay to avoid submitting while still typing
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });
    </script>
<?php component('footer') ?>