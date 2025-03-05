// types/pinia-plugin-persistedstate.d.ts

import 'pinia'
import type { PersistenceOptions } from 'pinia-plugin-persistedstate'

declare module 'pinia' {
  export interface DefineStoreOptionsBase<> {
    // Must match the plugin's type exactly or be a superset
    persist?: boolean | PersistenceOptions | PersistenceOptions[]
  }
}
