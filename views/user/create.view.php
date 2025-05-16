<?php require base_path('views/components/header.php'); ?>


<h1 class="text-2xl font-bold p-4 text-orange-600">Pievienot lietotāju</h1>

<form action="/users" method="POST" class="p-4 space-y-4">
    <input
      type="text"
      name="name"
      placeholder="Vārds"
      class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-orange-300"
    >
    <input
      type="email"
      name="email"
      placeholder="E‑pasts"
      class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-orange-300"
    >
    <input
      type="password"
      name="password"
      placeholder="Parole"
      class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-orange-300"
    >
    <button
      type="submit"
      class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded transition"
    >
      Izveidot
    </button>
</form>

<?php require base_path('views/components/footer.php'); ?>
