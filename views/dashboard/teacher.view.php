<?php component('header'); ?>
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
          <option value="<?= $s['ID'] ?>"><?= htmlspecialchars($s['first_name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <form action="/grades" method="POST" class="bg-white p-6 rounded shadow space-y-6">
      <input type="hidden" name="student_id" id="grade_student_id">
      
      <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Pievienot atzīmi</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block mb-1">Priekšmets</label>
            <select name="grade_subject" class="w-full border px-2 py-1 rounded">
              <?php foreach ($subjects as $sub): ?>
                <option value="<?= $sub['ID'] ?>"><?= $sub['name'] ?></option>
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

      <div class="text-right pt-4">
        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Saglabāt atzīmi</button>
      </div>
    </form>
  </div>

<?php component('footer'); ?>