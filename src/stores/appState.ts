import { defineStore } from 'pinia'

export const useAppState = defineStore('appState', {
  // 1) State must declare all properties you use later
  state: () => ({
    is_dev: process.env.NODE_ENV === 'development',
    teleport_ready: false,
    sidebar_expansion_group: {
      airlines: false,
      preflight_checks: false,
      clerk_schedule: false,
      gate_schedule: false,
    },
    current_date: '',
    selected_zone: '',
    loading: false,
    profile: {} as Record<string, unknown>, // Example property
  }),

  // 2) Actions (functions) that mutate state
  actions: {
    clear_profile() {
      // Make sure `profile` exists in state
      this.profile = {}
    },
  },

  // 3) (Optional) Getters if you need computed-like properties
  getters: {
    // example_getter(state) {
    //   return state.selected_zone.toUpperCase();
    // },
  },

  // 4) Configure which parts of state to persist
  persist: {
    storage: localStorage,
    pick: ['selected_zone'],
  },
})
