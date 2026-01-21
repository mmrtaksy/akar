export default {
    darkMode: 'class',
    purge: [
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
    ],
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
          screens: {
              // Özel breakpoint ekleyin
              'xl': '1300px', // xl artık 1300px'den başlar
          },
          container: {
              center: true, // Container'ı ortalamak için
              screens: {
                  xl: '1145px', // xl breakpoint'te container genişliği
              },
          },
      },
  },
    plugins: [],
  }
