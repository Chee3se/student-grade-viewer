<?php component('header'); ?>
<?php
  $students = $students ?? []; 
  $subjects = ['Matemātika', 'Latviešu valoda', 'Vēsture', 'Bioloģija'];  //SHITAS IR PAGAIDAM BUS DB
?>

<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8">
  <title>Skolotāja panelis</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-sm">

  <div class="max-w-5xl mx-auto my-6 space-y-8 px-4">

    <div class="bg-orange-500 text-white py-3 px-4 rounded shadow">
      <h1 class="text-xl font-semibold">Skolotāja panelis — Atzīmju un stundu pievienošana</h1>
    </div>

    <!-- Skolēna pievienošana -->
    <div class="bg-white p-6 rounded shadow space-y-4">
      <h2 class="text-lg font-semibold text-gray-800">Pievienot jaunu skolēnu</h2>
      <form method="POST" onsubmit="preventSubmit(event)" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 font-medium">Vārds un uzvārds</label>
          <input type="text" name="student_name" required class="w-full border px-3 py-2 rounded" placeholder="Piem. Jānis Bērziņš">
        </div>
        <div class="flex items-end">
          <button type="submit" class="bg-orange-500 text-white px-5 py-2 rounded hover:bg-orange-600">
            Pievienot skolēnu
          </button>
        </div>
      </form>
    </div>

    <script>
      function preventSubmit(event) {
        event.preventDefault(); 
      }
    </script>

    <!-- Skolēna izvēle -->
    <div class="bg-white p-6 rounded shadow">
      <label for="student_select" class="block mb-1 font-medium">Izvēlies skolēnu:</label>
      <select id="student_select" class="w-full border px-3 py-2 rounded">
        <?php foreach ($students as $s): ?>
          <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <!-- Atzīmju pievienošana - ATSEVIŠĶA FORMA -->
    <form action="submit_grades.php" method="POST" class="bg-white p-6 rounded shadow space-y-6">
      <input type="hidden" name="student_id" id="grade_student_id">
      
      <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Pievienot atzīmi</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block mb-1">Priekšmets</label>
            <select name="grade_subject" class="w-full border px-2 py-1 rounded">
              <?php foreach ($subjects as $sub): ?>
                <option value="<?= $sub ?>"><?= $sub ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block mb-1">Veids</label>
            <input type="text" name="grade_type" class="w-full border px-2 py-1 rounded" placeholder="Kontroldarbs">
          </div>
          <div>
            <label class="block mb-1">Datums</label>
            <input type="date" name="grade_date" class="w-full border px-2 py-1 rounded">
          </div>
          <div>
            <label class="block mb-1">Atzīme</label>
            <input type="text" name="grade_value" class="w-full border px-2 py-1 rounded" placeholder="10">
          </div>
        </div>
      </div>

      <!-- Iesniegt atzīmi -->
      <div class="text-right pt-4">
        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Saglabāt atzīmi</button>
      </div>
    </form>

    <!-- Stundu pievienošana - ATSEVIŠĶA FORMA -->
    <form action="submit_lessons.php" method="POST" class="bg-white p-6 rounded shadow space-y-6">
      <input type="hidden" name="student_id" id="lesson_student_id">
      
      <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Pievienot stundu</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block mb-1">Stundas Nr.</label>
            <input type="number" name="lesson_number" class="w-full border px-2 py-1 rounded" required>
          </div>
          <div>
            <label class="block mb-1">Priekšmets</label>
            <select name="lesson_subject" class="w-full border px-2 py-1 rounded" required>
              <?php foreach ($subjects as $sub): ?>
                <option value="<?= $sub ?>"><?= $sub ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block mb-1">Tēma</label>
            <input type="text" name="lesson_topic" class="w-full border px-2 py-1 rounded" placeholder="Jaunā tēma" required>
          </div>
          <div>
            <label class="block mb-1">Telpa</label>
            <input type="text" name="lesson_room" class="w-full border px-2 py-1 rounded" placeholder="208. kab." required>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="block mb-1">Mājasdarbs</label>
            <input type="text" name="lesson_homework" class="w-full border px-2 py-1 rounded">
          </div>
        </div>
      </div>

      <!-- Iesniegt stundu -->
      <div class="text-right pt-4">
        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Saglabāt stundu</button>
      </div>
    </form>
  </div>

  <script>
    // Sinhronizē izvēlēto skolēnu starp formām
    document.getElementById('student_select').addEventListener('change', function() {
      document.getElementById('grade_student_id').value = this.value;
      document.getElementById('lesson_student_id').value = this.value;
    });
    
    // Iestatīt sākotnējo vērtību
    window.addEventListener('DOMContentLoaded', function() {
      const studentSelect = document.getElementById('student_select');
      if (studentSelect.options.length > 0) {
        const selectedValue = studentSelect.options[0].value;
        document.getElementById('grade_student_id').value = selectedValue;
        document.getElementById('lesson_student_id').value = selectedValue;
      }
    });
  </script>
</body>
<?php component('footer'); ?>
</html>