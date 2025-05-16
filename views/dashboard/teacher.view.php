<?php component('header') ?>
<div class="container mx-auto py-8 px-4">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border mb-8">
        <div class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h1 class="text-2xl font-bold">Skolotāja skats</h1>
                        <p class="text-gray-600" id="teacherName">Skolotājs: <?= $_SESSION['user']['first_name'] ?? '' ?> <?= $_SESSION['user']['last_name'] ?? '' ?></p>
            </div>
            <div class="mt-4 sm:mt-0">
        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-gray-700">
          Skolotājs
        </span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Student Filter -->
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
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <input type="text" id="nameFilter" placeholder="Meklēt pēc vārda vai uzvārda" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button id="sortButton" class="inline-flex items-center justify-center rounded-md border border-gray-300 p-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500" title="Kārtot">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m7 15 5 5 5-5"></path>
                                <path d="m7 9 5-5 5 5"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subject Filter -->
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
                <div class="relative">
                    <select id="subjectFilter" class="w-full appearance-none rounded-md border border-gray-300 px-3 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">Visi priekšmeti</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Button -->
    <div class="flex justify-end mb-4 gap-4">
        <a href="/users/create" class="inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-400">
            Pievienot skolēnu
        </a>
        <a href="/grades/create" class="mr-auto inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-400">
            Pievienot atzīmi
        </a>
        <button id="exportButton" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Eksportēt atzīmes
        </button>
    </div>




    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b">
            <div class="flex -mb-px">
                <button id="gradesTab" class="tab-button active py-2 px-4 text-sm font-medium border-b-2 border-blue-500 text-blue-600">Atzīmes</button>
                <button id="averagesTab" class="tab-button py-2 px-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Vidējās atzīmes</button>
            </div>
        </div>
    </div>

    <!-- Grades Tab Content -->
    <div id="gradesContent" class="tab-content">
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b">
                <h2 class="text-lg font-medium" id="gradesTitle">Visu priekšmetu atzīmes</h2>
            </div>
            <div class="p-4">
                <div class="rounded-md border overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skolēns</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priekšmets</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Atzīme</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="gradesTableBody">
                        <!-- JS will fill this -->
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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priekšmets</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Vidējā atzīme</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="averagesTableBody">
                        <!-- JS will fill this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // DEMO DATA
    const teacher = <?= json_encode($_SESSION['user']) ?>;
    
    // Sanitize and prepare data to ensure consistent types
    let students = <?= json_encode($students) ?>;
    let subjects = <?= json_encode($subjects) ?>;
    let grades = <?= json_encode($grades) ?>;
    
    // Convert IDs to strings for consistent comparison
    students = Array.isArray(students) ? students.map(s => ({
        ...s,
        id: String(s.id)
    })) : [];
    
    subjects = Array.isArray(subjects) ? subjects.map(s => ({
        ...s,
        id: String(s.id)
    })) : [];
    
    grades = Array.isArray(grades) ? grades.map(g => ({
        ...g,
        user_id: String(g.user_id),
        subject_id: String(g.subject_id),
        grade: parseFloat(g.grade) // Ensure grade is numeric
    })) : [];
    
    // Debug data
    console.log('Processed students:', students);
    console.log('Processed subjects:', subjects);
    console.log('Processed grades:', grades);

    // Fill teacher name
    document.getElementById('teacherName').textContent = `Skolotājs: ${teacher.first_name} ${teacher.last_name}`;

    // Fill subject filter
    const subjectFilter = document.getElementById('subjectFilter');
    subjects.forEach(subj => {
        const opt = document.createElement('option');
        opt.value = subj.id;
        opt.textContent = subj.name;
        subjectFilter.appendChild(opt);
    });

    // Fill grades table
    function renderGrades() {
        const tbody = document.getElementById('gradesTableBody');
        tbody.innerHTML = '';
        
        // For debugging
        console.log('Students:', students);
        console.log('Subjects:', subjects);
        console.log('Grades:', grades);
        
        // Check for type mismatches
        const processedGrades = grades.map(grade => {
            return {
                ...grade,
                user_id: String(grade.user_id),
                subject_id: String(grade.subject_id),
                grade: parseFloat(grade.grade)
            };
        });
        
        processedGrades.forEach(grade => {
            // Compare as strings to avoid type mismatches
            const student = students.find(s => String(s.id) === grade.user_id);
            const subject = subjects.find(s => String(s.id) === grade.subject_id);
            
            if (!student || !subject) {
                console.warn('Missing data for grade:', grade, 'Student found:', !!student, 'Subject found:', !!subject);
                return;
            }
            
            const tr = document.createElement('tr');
            tr.className = 'grade-row';
            tr.setAttribute('data-student', grade.user_id);
            tr.setAttribute('data-subject', grade.subject_id);
            tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${student.first_name} ${student.last_name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${subject.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">${isNaN(grade.grade) ? '0.00' : grade.grade.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
        });
        
        // Add no data message if needed
        if (tbody.children.length === 0) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Nav atzīmju, kas atbilst atlasītajiem kritērijiem</td>
            `;
            tbody.appendChild(tr);
        }
    }

    // Fill averages table
    function renderAverages() {
        const tbody = document.getElementById('averagesTableBody');
        tbody.innerHTML = '';
        subjects.forEach(subject => {
            const subjectGrades = grades.filter(g => g.subject_id === subject.id);
            if (subjectGrades.length === 0) return;
            const avg = subjectGrades.reduce((sum, g) => sum + g.grade, 0) / subjectGrades.length;
            const tr = document.createElement('tr');
            tr.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${subject.name}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">${avg.toFixed(2)}</td>
      `;
            tbody.appendChild(tr);
        });
    }

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


    const nameFilter = document.getElementById('nameFilter');
    const sortButton = document.getElementById('sortButton');
    const gradesTitle = document.getElementById('gradesTitle');
    let sortOrder = 'asc';

    function filterGrades() {
        const nameValue = nameFilter.value.toLowerCase();
        const subjectValue = subjectFilter.value;
        document.querySelectorAll('.grade-row').forEach(row => {
            const studentName = row.querySelector('td:first-child').textContent.toLowerCase();
            const subjectId = row.getAttribute('data-subject');
            const nameMatch = studentName.includes(nameValue);
            const subjectMatch = subjectValue === 'all' || subjectId === subjectValue;
            row.style.display = (nameMatch && subjectMatch) ? '' : 'none';
        });
        if (subjectValue !== 'all') {
            const subjectName = subjectFilter.options[subjectFilter.selectedIndex].text;
            gradesTitle.textContent = `${subjectName} atzīmes`;
        } else {
            gradesTitle.textContent = 'Visu priekšmetu atzīmes';
        }
    }

    function sortGrades() {
        const rows = Array.from(document.querySelectorAll('.grade-row'));
        const tbody = document.getElementById('gradesTableBody');
        rows.sort((a, b) => {
            const nameA = a.querySelector('td:first-child').textContent.toLowerCase();
            const nameB = b.querySelector('td:first-child').textContent.toLowerCase();
            return sortOrder === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
        });
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    }

    sortButton.addEventListener('click', () => {
        sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
        sortGrades();
    });
    nameFilter.addEventListener('input', filterGrades);
    subjectFilter.addEventListener('change', filterGrades);


    document.getElementById('exportButton').addEventListener('click', () => {
        let csvContent;
        if (document.getElementById('gradesContent').classList.contains('hidden')) {
            csvContent = 'Priekšmets,Vidējā atzīme\n';
            document.querySelectorAll('#averagesContent tbody tr').forEach(row => {
                const subject = row.querySelector('td:first-child').textContent.trim();
                const average = row.querySelector('td:last-child').textContent.trim();
                csvContent += `${subject},${average}\n`;
            });
        } else {
            csvContent = 'Skolēns,Priekšmets,Atzīme\n';
            document.querySelectorAll('.grade-row').forEach(row => {
                if (row.style.display !== 'none') {
                    const student = row.querySelector('td:nth-child(1)').textContent.trim();
                    const subject = row.querySelector('td:nth-child(2)').textContent.trim();
                    const grade = row.querySelector('td:nth-child(3)').textContent.trim();
                    csvContent += `${student},${subject},${grade}\n`;
                }
            });
        }
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'atzimes.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });


    renderGrades();
    renderAverages();
    filterGrades();
    sortGrades();
</script>

<?php component('footer') ?>