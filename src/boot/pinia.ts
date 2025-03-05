// src/boot/pinia.js
import { boot } from 'quasar/wrappers'
import { createPinia } from 'pinia'
import piniaPluginPersist from 'pinia-plugin-persist'

export default boot(({ app }) => {
  const pinia = createPinia()

  // Use the persist plugin with Pinia
  pinia.use(piniaPluginPersist)

  app.use(pinia)
})
