<!doctype html>
<html lang="lv">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StudioClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              brand: {
                500: '#ff6f00',
              }
            },
            keyframes: {
              fadeIn: {
                '0%': { opacity: '0' },
                '100%': { opacity: '1' }
              }
            },
            animation: {
              fadeIn: 'fadeIn 1s ease-out'
            }
          }
        }
      }
    </script>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
      html, body {
        height: 100%;
        margin: 0;
        overflow-x: hidden;
      }
      body {
        font-family: 'Inter', sans-serif;
        background-color: #fefefe;
        color: #333333;
      }
      .card-hover {
        @apply bg-white rounded-lg shadow-lg transition-transform transform hover:scale-105;
      }
      .fade-in {
        animation: fadeIn 0.8s ease-out;
      }
    </style>
  </head>
  <body>
    
  </body>
</html>
