import tailwindcss from "@tailwindcss/vite";
export default {
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  css: ['~/assets/css/main.css'],  vite: {    plugins: [      tailwindcss(),    ],  },
  
  publicRuntimeConfig: {
    apiBase: "http://127.0.0.1:8000/api",
  },
}

