import { defineStore } from 'pinia'
import axios from 'axios'
import { Airline } from '../types/airline.interface'
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
    airlines: [],
    selected_airline: {} as Airline,
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
    async load_airlines() {
      try {
        const response = await axios.post(
          `${import.meta.env.VITE_API_URL}load_airlines.php`,
          {
            zone: this.selected_zone,
          }
        )
        console.log(response.data)
        this.airlines = response.data
      } catch (error) {
        console.error('Error loading airlines:', error)
      }
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
    pick: ['selected_zone', 'airlines', 'selected_airline'],
  },
})
