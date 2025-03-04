import { defineStore } from 'pinia';

export const useAppState = defineStore('appState', {
  state: () => ({
    is_dev: process.env.NODE_ENV === 'development',
    teleport_ready: false,
    sidebar_expansion_group: {
      airlines: false,
    },
    current_date: '',
    selected_zone: '',

    loading: false,
  }),

  /* ------------------------------------------- ACTIONS ------------------------------------------ */
  actions: {
    clear_profile() {
      // this.profile = {
      //   id: '',
      //   name: '',
      //   email: '',
      //   picture: '',
      //   role: '',
      //   is_hotline: '',
      //   is_sales: '',
      //   default_region: '',
      //   time_zone: '',
      //   office: '',
      //   phone: '',
      //   contact_email: '',
      //   job_description: '',
      // };
    },
  },
  getters: {},
});
