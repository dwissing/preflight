import { RouteRecordRaw } from 'vue-router'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      {
        path: 'airline-dashboard',
        component: () => import('layouts/AirlineDashboard.vue'),
        props: { zone: 'yourZoneValue' },
      },
      {
        path: 'preflight-check',
        component: () => import('pages/PreflightCheck.vue'),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
]

export default routes
