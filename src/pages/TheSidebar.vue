<template>
  <div class="col mycol">
    <div class="">
      <q-list dense class="mylist">
        <q-expansion-item
          v-model="store.sidebar_expansion_group.airlines"
          group="somegroup"
          label="Zone Dashboard"
          popout
          :class="
            store.sidebar_expansion_group.airlines ? 'expanded' : 'collapsed'
          "
          :header-class="
            store.sidebar_expansion_group.airlines
              ? 'text-primary expanded-header'
              : 'text-primary collapsed-header'
          "
          icon="mdi-monitor-dashboard"
        >
          <q-item
            dense
            clickable
            exact
            :active-class="
              store.selected_zone === 'Northeast' ? 'myactive' : ''
            "
            @click="store.selected_zone = 'Northeast'"
            to="/airline-dashboard"
          >
            Northeast
          </q-item>
          <q-item
            dense
            clickable
            exact
            :active-class="store.selected_zone === 'Gulf' ? 'myactive' : ''"
            @click="store.selected_zone = 'Gulf'"
            to="/airline-dashboard"
          >
            Gulf
          </q-item>
          <q-item
            dense
            clickable
            exact
            :active-class="store.selected_zone === 'Midwest' ? 'myactive' : ''"
            @click="store.selected_zone = 'Midwest'"
            to="/airline-dashboard"
          >
            Midwest
          </q-item>
          <q-item
            dense
            clickable
            exact
            :active-class="store.selected_zone === 'Central' ? 'myactive' : ''"
            @click="store.selected_zone = 'Central'"
            to="/airline-dashboard"
          >
            Central
          </q-item>
          <q-item
            dense
            clickable
            exact
            :active-class="store.selected_zone === 'West' ? 'myactive' : ''"
            @click="store.selected_zone = 'West'"
            to="/airline-dashboard"
          >
            West
          </q-item>
        </q-expansion-item>
        <q-separator></q-separator>
        <q-expansion-item
          v-model="store.sidebar_expansion_group.preflight_checks"
          group="somegroup"
          label="Preflight Checks"
          popout
          :to="'/preflight-check'"
          :class="
            store.sidebar_expansion_group.preflight_checks
              ? 'expanded'
              : 'collapsed'
          "
          :header-class="
            store.sidebar_expansion_group.preflight_checks
              ? 'text-primary expanded-header'
              : 'text-primary collapsed-header'
          "
          icon="mdi-text-box-check-outline"
        >
          <div class="q-pa-md">
            <q-select
              v-model="store.selected_airline"
              :options="store.airlines"
              dense
              options-dense
              outlined
              option-value="abbreviation"
              label="Terminal"
              option-label="abbreviation"
            ></q-select>
          </div>
        </q-expansion-item>
        <q-separator></q-separator>
        <q-expansion-item
          :disabled="true"
          v-model="store.sidebar_expansion_group.clerk_schedule"
          group="somegroup"
          label="Clerk Schedule"
          popout
          :class="
            store.sidebar_expansion_group.clerk_schedule
              ? 'expanded'
              : 'collapsed'
          "
          :header-class="
            store.sidebar_expansion_group.clerk_schedule
              ? 'text-primary expanded-header'
              : 'text-primary collapsed-header'
          "
          icon="mdi-account-multiple"
        >
        </q-expansion-item>
        <q-separator></q-separator>
      </q-list>
    </div>
    <q-space></q-space>
    <div class="info">
      Disclaimer: This page contains no real information and is not associated
      with any real company.
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import { useAppState } from '../stores/appState'

const store = useAppState()

onMounted(() => {
  store.load_airlines()
  if (store.airlines.length === 0) {
    store.load_airlines()
  }
})
</script>

<style lang="scss" scoped>
.q-item {
  line-height: 1.8em !important;
  // height: 0.5em !important;
}

.badge {
  position: absolute;
  top: -5px;
  right: 4px;
  z-index: 1;
}

.divider {
  border-top: 1px solid rgb(146, 146, 146);
  color: #1976d2;
  height: 23px;
  margin: 0px 5px 5px 5px;
  padding: 3px;
  text-align: left;
  font-weight: bold;
}

.myactive {
  font-weight: bold;
  display: block;
  width: 100%;
  background-color: #1976d2;
  font-size: 1.2em;
  color: white !important;

  border-radius: 20px;
  text-align: center !important;
}
.mylist {
  // background-color: rgb(184, 70, 70);
  // color: red !important;
  margin-left: 4px;
  margin-right: 4px;
}
.copyright {
  position: absolute;
  bottom: 0px;
}
.expanded {
  background-color: #edf1f9;
  border: 1px solid #1976d2;
  border-radius: 20px;
}
:deep(.expanded-header) {
  font-weight: bold !important;
  font-size: 1.1em;
}
:deep(.expanded-header .q-item__label) {
  margin-left: -25px;
}
:deep(.collapsed-header .q-item__label) {
  // font-weight: bold !important;
  font-size: 1em;
  margin-left: -20px;
}
.q-item {
  z-index: 100;
  line-height: 1.8em !important;
  color: black;
}
.header_badge {
  position: absolute;
  margin-left: 150px;
  margin-top: -10px;
}
.mycol {
  // background-color: rgb(184, 70, 70);
  display: flex;
  justify-content: space-between;
  flex-direction: column;
  height: 100%;
}
.info {
  font-size: 1rem;
  margin-top: 10px;
  margin-left: 10px;
}
</style>
