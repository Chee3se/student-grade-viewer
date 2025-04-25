</main>
<footer class="bg-white border-t mt-auto">
  <div class="mx-auto max-w-7xl px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-10 text-gray-600 fade-in">
    
    
    <div class="md:col-span-2">
      <div class="flex items-center mb-4">
        <i class="fas fa-graduation-cap text-2xl text-orange-500 mr-2"></i>
        <span class="text-xl font-semibold">StudioClass</span>
      </div>
      <p class="leading-relaxed">
        Platforma, kas palīdz skolotājiem un skolēniem pārvaldīt atzīmes un uzdevumus viegli un skaidri.
      </p>
    </div>

  
    <div>
      <h4 class="font-semibold text-lg mb-4">Saites</h4>
      <ul class="space-y-2">
        <li><a href="#" class="hover:text-orange-500 transition">Par mums</a></li>
        <li><a href="#" class="hover:text-orange-500 transition">Kontakti</a></li>
      </ul>
    </div>

   
    <div>
      <h4 class="font-semibold text-lg mb-4">Kontakti</h4>
      <ul class="space-y-2 text-sm">
        <li class="flex items-center"><i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>Rīga, Brīvības iela 123</li>
        <li class="flex items-center"><i class="fas fa-phone mr-2 text-orange-500"></i>+371 67123456</li>
        <li class="flex items-center"><i class="fas fa-envelope mr-2 text-orange-500"></i>info@studioclass.lv</li>
      </ul>

      
      <div class="mt-6">
        <?php if (isset($_SESSION['user'])): ?>
          <a href="/logout" class="inline-block px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Iziet</a>
        <?php else: ?>
          <a href="/login" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Pieteikties</a>
        <?php endif; ?>
      </div>
    </div>

  </div>

  <!-- Footer apakšrinda -->
  <div class="text-center text-gray-400 text-sm py-6 border-t mt-10">
    &copy; <?php echo date('Y'); ?> StudioClass. Visas tiesības aizsargātas.
  </div>
</footer>
