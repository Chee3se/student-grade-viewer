<?php
  
  $info       = $info       ?? [];
  $classTimes = $classTimes ?? [];
  $grades     = $grades     ?? [];
  $schedule   = $schedule   ?? [];


  setlocale(LC_ALL, 'lv_LV.UTF-8');  

 
  $dayFormatter = new IntlDateFormatter(
      'lv_LV',                        
      IntlDateFormatter::FULL,        
      IntlDateFormatter::NONE         
  );  
?>
<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Izglītības Informācijas Sistēma</title>
  <?php component('header'); ?>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: {
          orange: { 500:'#ff5a1f' },
          gray:   {
            100:'#f5f5f5',200:'#e5e5e5',300:'#d4d4d4',
            400:'#a3a3a3',500:'#737373',600:'#525252',
            700:'#404040',800:'#262626'
          }
        }
      }}
    };
  </script>
  <style> body { font-family: Arial, sans-serif; } </style>
</head>
<body class="bg-gray-100">

  <div class="container mx-auto px-4 py-4 grid grid-cols-1 lg:grid-cols-4 gap-4">

    <!-- Sidebar -->
    <aside class="lg:col-span-1 bg-white border border-gray-200">
      <div class="bg-orange-500 px-4 py-2">
        <h2 class="text-white font-bold">Informācija</h2>
      </div>
      <div class="p-4 space-y-4">
        <div class="space-y-2 text-sm text-gray-700">
          <div class="flex justify-between">
            <span>Mācību gads:</span>
            <span class="font-medium"><?= htmlspecialchars($info['academicYear'] ?? '—') ?></span>
          </div>
          <div class="flex justify-between">
            <span>Klase:</span>
            <span class="font-medium"><?= htmlspecialchars($info['className'] ?? '—') ?></span>
          </div>
          <div class="flex justify-between">
            <span>Klases audzinātājs:</span>
            <span class="font-medium"><?= htmlspecialchars($info['classTeacher'] ?? '—') ?></span>
          </div>
          <div class="flex justify-between">
            <span>Semestris:</span>
            <span class="font-medium"><?= htmlspecialchars($info['semester'] ?? '—') ?></span>
          </div>
        </div>

        <div class="pt-4 border-t border-gray-200">
          <h3 class="text-sm font-bold text-gray-700 mb-2">Stundu laiki</h3>
          <?php if (!empty($classTimes)): ?>
            <div class="space-y-1 text-xs text-gray-600">
              <?php foreach ($classTimes as $ct): ?>
                <div class="flex justify-between">
                  <span><?= htmlspecialchars($ct['label'] ?? '') ?></span>
                  <span><?= htmlspecialchars(($ct['from'] ?? '') . ' - ' . ($ct['to'] ?? '')) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-xs text-gray-500">Stundu laiki nav iestatīti.</p>
          <?php endif; ?>
        </div>
      </div>
    </aside>

    
    <main class="lg:col-span-3 space-y-4">

    
      <section class="bg-white border border-gray-200">
        <div class="bg-orange-500 px-4 py-2">
          <h2 class="text-white font-bold">Jaunākās atzīmes</h2>
        </div>
        <div class="p-4">
          <?php if (!empty($grades)): ?>
            <table class="w-full border-collapse text-sm">
              <thead>
                <tr class="border-b border-gray-200 text-gray-700">
                  <th class="py-2 text-left">Priekšmets</th>
                  <th class="py-2 text-left">Vērtējuma veids</th>
                  <th class="py-2 text-left">Datums</th>
                  <th class="py-2 text-center">Atzīme</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($grades as $g): ?>
                  <tr class="border-b border-gray-200">
                    <td class="py-2"><?= htmlspecialchars($g['subject']   ?? '') ?></td>
                    <td class="py-2"><?= htmlspecialchars($g['gradeType'] ?? '') ?></td>
                    <td class="py-2"><?= htmlspecialchars($g['date']      ?? '') ?></td>
                    <td class="py-2 text-center font-bold"><?= htmlspecialchars($g['value'] ?? '') ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <p class="text-center text-sm text-gray-500">
              Nav pieejamu atzīmju. Atzīmes parādīsies, kad tās tiks ievadītas sistēmā.
            </p>
          <?php endif; ?>
        </div>
      </section>

      
      <section class="bg-white border border-gray-200">
        <div class="bg-orange-500 px-4 py-2 flex justify-between items-center">
          <h2 class="text-white font-bold">Aktuālās stundas un mājasdarbi</h2>
          <div class="text-white text-sm">
            <?= date('d.m.Y') ?>, <?= ucfirst($dayFormatter->format(new DateTime())) ?>
            
          </div>
        </div>
        <div class="p-4">
          <?php if (!empty($schedule)): ?>
            <table class="w-full border-collapse text-sm">
              <thead>
                <tr class="border-b border-gray-200 text-gray-700">
                  <th class="py-2 text-left">Priekšmets un telpa</th>
                  <th class="py-2 text-left">Tēma</th>
                  <th class="py-2 text-left">Uzdots</th>
                  <th class="py-2 text-left">Atzīme</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($schedule as $lesson): ?>
                  <tr class="border-b border-gray-200">
                    <td class="py-2">
                      <div class="font-medium">
                        <?= htmlspecialchars(($lesson['number'] ?? '') . '. ' . ($lesson['subject'] ?? '')) ?>
                      </div>
                      <div class="text-xs text-gray-500">
                        Telpa: <?= htmlspecialchars($lesson['room'] ?? '') ?>
                      </div>
                      <?php if (!empty($lesson['weekOnly'])): ?>
                        <div class="text-xs text-orange-600 mt-1">Tikai šajā nedēļā</div>
                      <?php endif; ?>
                    </td>
                    <td class="py-2"><?= htmlspecialchars($lesson['topic']    ?? '') ?></td>
                    <td class="py-2"><?= htmlspecialchars($lesson['homework'] ?? '') ?></td>
                    <td class="py-2"><?= htmlspecialchars($lesson['grade']    ?? '') ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <p class="text-center text-sm text-gray-500">
              Nav pieejama stundu saraksta. Saraksts parādīsies, kad tas tiks ievadīts sistēmā.
            </p>
          <?php endif; ?>
        </div>
      </section>

    </main>

  </div>

  <footer class="bg-white border-t border-gray-200 mt-4">
    
  </footer>

  <?php component('footer'); ?>

  <nav>
  </nav>
</body>
</html>
