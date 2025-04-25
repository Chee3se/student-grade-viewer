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