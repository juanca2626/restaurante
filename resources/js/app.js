import './bootstrap'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import DailyMenu from '@/components/Menu/DailyMenu.vue'
import SidebarCart from '@/components/SidebarCart.vue'
import Navbar from '@/components/Navbar.vue'
import MainApp from '@/components/MainApp.vue'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
const app = createApp({
    setup() {
        return {
            message: 'Welcome to Your Vue.js App'
        };
    },
    components: {
        DailyMenu,
        MainApp,
        SidebarCart,
        Navbar
    },
})

app.use(pinia)
app.mount('#app')
window.app = app