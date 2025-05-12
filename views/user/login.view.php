<?php component('header'); ?>
<!doctype html>
<html lang="lv">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      .login-container {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      }
    </style>
  </head>
  <body class="flex min-h-screen flex-col bg-gray-50">
    <main class="flex flex-grow items-center justify-center p-4 md:p-0">
      <div class="login-container w-full max-w-lg overflow-hidden rounded-2xl bg-white">
        <!-- Left decorative sidebar -->
        <div class="flex flex-col md:flex-row">
          <div class="hidden w-2 bg-gradient-to-b from-orange-400 to-orange-600 md:block"></div>

          <div class="flex-1 p-12 md:p-16">
            <div class="mb-8 text-center">
              <h2 class="text-3xl font-bold text-gray-800">Pieslēgties</h2>
            </div>

            <form class="space-y-6" action="/login" method="POST" >
              <div>
                <label class="mb-2 block font-medium text-gray-700" for="email">E-pasts</label>
                <div class="relative">
                  <input name="email" type="email" id="email" placeholder="Ievadiet e-pastu" class="w-full rounded-lg border border-gray-300 px-4 py-3 transition-all focus:border-transparent focus:ring-2 focus:ring-orange-500 focus:outline-none" />
                </div>
              </div>
              <div>


                <div class="mb-2 flex items-center justify-between">
                  <label class="block font-medium text-gray-700" for="password">Parole</label>
                </div>
                <div class="relative">
                  <input name="password" type="password" id="password" placeholder="Ievadiet paroli" class="w-full rounded-lg border border-gray-300 px-4 py-3 transition-all focus:border-transparent focus:ring-2 focus:ring-orange-500 focus:outline-none" />
                </div>
                <?= error('password') ?>
              </div>


              <div class="pt-2">
                <button type="submit" class="w-full transform rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 py-3 font-bold text-white shadow-md transition-all hover:scale-[1.02] hover:from-orange-600 hover:to-orange-700 active:scale-[0.98]">PIESLĒGTIES</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
<?php component('footer'); ?>
