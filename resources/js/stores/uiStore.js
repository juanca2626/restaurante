import { defineStore } from 'pinia'

export const useUiStore = defineStore('uiStore', {
  state: () => ({ 
    sidebarIsOpen: false,
    saveOrderUri: '',
    getCustomerDataUri: ''
  }),
})