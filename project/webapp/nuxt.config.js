export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  ssr: true,
  target: 'server',
  head: {
    title: 'webapp',
    htmlAttrs: {
      lang: 'fr'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '@/plugins/vue-html-to-paper'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/buefy
    'nuxt-buefy',
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    // ['nuxt-buefy', { css: false, materialDesignIcons: true }],
    'cookie-universal-nuxt',
  ],
  router: {
    middleware: ['auth']
  },
  axios: {
    // baseURL: 'https://www.wele.fr', // Used as fallback if no runtime config is provided
    // baseURL: 'https://api.traefik.me', // Used as fallback if no runtime
    baseURL: process.env.BASE_URL
  },
  auth: {
    strategies: {
      local: {
        scheme: 'refresh',
        token: {
          property: 'token',
          required: true,
          type: false,
          global: true,
          type: 'Bearer',
          maxAge: 3600
        },
        refreshToken: {
          property: 'refresh_token',
          data: 'refresh_token',
          maxAge: 60 * 60 * 24 * 30,
        },
        user: {
          property: false,
          autoFetch: true
        },
        endpoints: {
          entryPoint: process.env.BASE_URL,
          login: { url: process.env.BASE_URL+'/api/login', method: 'post'  },
          refresh: { url: process.env.BASE_URL+'/api/token/refresh', method: 'post' },
          logout: { url: process.env.BASE_URL+'/api/logout', method: 'post' },
          user: { url: process.env.BASE_URL+'/api/me', method: 'get' },
          // callback:'/home'
        }
      }
    }
  },
  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    transpile: [
      'defu'
    ]
  }
}
