import { action, Action } from 'easy-peasy'

export interface SiteSettings {
  theme: 'dark' | 'light'
}

export interface SettingsStore {
  data?: SiteSettings
  setSettings: Action<SettingsStore, SiteSettings>
  setTheme: Action<SettingsStore, 'dark' | 'light'>
}

const settings: SettingsStore = {
  data: undefined,
  setSettings: action((state, payload) => {
    state.data = payload
  }),
  setTheme: action((state, payload) => {
    localStorage.setItem('theme', payload)
    state.data = {
      ...state.data,
      ...{ theme: payload },
    }
  }),
}

export default settings
