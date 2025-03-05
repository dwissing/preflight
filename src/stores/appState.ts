import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAppState = defineStore(
  'appState',
  () => {
    const is_dev = ref(process.env.NODE_ENV === 'development')
    const teleport_ready = ref(false)
    const sidebar_expansion_group = ref({
      airlines: false,
    })
    const current_date = ref('')
    const selected_zone = ref('')
    const loading = ref(false)

    return {
      is_dev,
      teleport_ready,
      sidebar_expansion_group,
      current_date,
      selected_zone,
      loading,
    }
  },
  {
    persist: true,
  }
)
