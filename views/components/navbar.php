<header class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
  <div class="mx-auto max-w-7xl px-6 py-4 flex justify-between items-center">
    <a href="/" class="flex items-center">
      <i class="fas fa-graduation-cap text-2xl mr-2"></i>
      <span class="text-2xl font-semibold">StudioClass</span>
    </a>
    <nav class="space-x-4">
      <a href="#" class="hover:underline">Par mums</a>
      <a href="#" class="hover:underline ">Kontakti</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/dashboard" class="hover:underline">Panelis</a>
            <a href="/profile" class="hover:underline">Profils</a>
          <a href="/logout" class="px-4 py-2 bg-white text-orange-600 font-medium rounded hover:bg-gray-100">Iziet</a>
        <?php else: ?>
            <a href="/login" class="px-4 py-2 bg-white text-orange-600 font-medium rounded hover:bg-gray-100">Pieslēgties</a>
        <?php endif; ?>
    </nav>
  </div>
</header>
