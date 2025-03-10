<template>
  <!-- END LOGIN -->
  <div class="constrained bg-grey-2">
    <q-layout view="hHh Lpr lfr">
      <q-header elevated class="bg-white text-primary no-print">
        <q-toolbar>
          <q-btn
            flat
            round
            dense
            icon="mdi-menu"
            @click="leftDrawerOpen = !leftDrawerOpen"
          />
          <router-link :to="'/'">
            <div class="logo">
              <div class="silo">Preflight</div>
            </div>
          </router-link>

          <!-- THESE ARE FOR TELEPORTING: -->
          <div id="search"></div>
          <div id="controls">
            <q-btn @click="set_date(1)">Monday</q-btn>
            <q-btn @click="set_date(2)">Tuesday</q-btn>
            <q-btn @click="set_date(3)">Wednesday</q-btn>
            <q-btn @click="set_date(4)">Thursday</q-btn>
            <q-btn @click="set_date(5)">Friday</q-btn>
          </div>
          date: {{ store.current_date }}
          <!-- --------------------- -->
          <q-space></q-space>
        </q-toolbar>
      </q-header>

      <!--// Left drawer //-->
      <q-drawer
        class="no-print"
        show-if-above
        v-model="leftDrawerOpen"
        @before-hide="leftDrawerOpen = false"
        content-class="bg-white"
        elevated
        :width="190"
        style="
          display: flex;
          flex-direction: column;
          justify-content: space-between;
        "
      >
        <div class="">
          <TheSidebar></TheSidebar>
        </div>
      </q-drawer>

      <!--// Main content //-->
      <q-page-container class="bg-grey-2">
        <router-view />
      </q-page-container>
    </q-layout>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import dayjs from 'dayjs'
// import { useRouter } from 'vue-router';
import { useAppState } from '../stores/appState.ts'

import TheSidebar from '../pages/TheSidebar.vue'
// const router = useRouter();

const store = useAppState()
const leftDrawerOpen = ref(true)

async function set_date(date: number) {
  // Get the date of the Monday of the current week
  const monday = dayjs().startOf('week')
  const day = monday.add(date, 'day').format('YYYY-MM-DD')
  store.current_date = day
  console.log(date)
}
</script>

<style scoped type="text/css">
.constrained {
  width: 100%;
  height: 100%;
}

.constrained .q-layout,
.constrained .q-header,
.constrained .q-footer {
  margin: 0 auto;
  /* max-width: 1245px !important; */
}

.nav-btn {
  min-width: 90px;
}
.mytitle {
  text-align: left;
}

.logo {
  /* padding: 0 !important; */
  display: flex;
  flex-basis: 100px;
  margin: 0px 0px 0px 0px !important;
  font-size: 1.8em;
  align-items: center;
  font-weight: bold;
  width: 135px;
  color: grey;
}
</style>
