<template>
  <div class="container mx-auto px-4 py-6">
    <!-- Layout principal -->
    <div class="flex flex-col lg:flex-row gap-6">
      <!-- Sección izquierda (Información del restaurante) -->
      <aside
        class="lg:w-1/4 bg-white rounded-lg shadow-lg p-6 hidden lg:block"
      >
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-orange-600 mb-4">Conócenos</h2>
          <p class="text-sm text-gray-600 leading-relaxed">
            Restaurante Gourmet<br />
            Dirección: Av. Principal 123<br />
            Teléfono: (01) 234-5678<br />
            Horario: 8:00 AM - 10:00 PM
          </p>
        </div>

        <div class="mb-6">
          <h2 class="text-xl font-semibold text-orange-600 mb-4">
            Entra en Contacto
          </h2>
          <div class="flex items-center text-sm text-gray-600 mb-2">
            <!-- Icono de correo -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4H8a4 4 0 00-4 4v8a4 4 0 004 4h8a4 4 0 004-4V8a4 4 0 00-4-4zM8 10l4 4 4-4" />
          </svg>
            contacto@restaurante.com
          </div>
          <div class="flex items-center text-sm text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M9 3v2M15 3v2M4 9h16v10H4z" />
          </svg>
            www.laonce.com
          </div>
        </div>

        <div>
          <h2 class="text-xl font-semibold text-orange-600 mb-4">Recogida</h2>
          <p class="text-sm text-gray-600">
            Ofrecemos un servicio rápido para recoger tus pedidos, Estamos para
            servirte!
          </p>
          <div class="rounded-lg overflow-hidden shadow-md mt-4">
            <img
              class="w-full h-40 object-cover"
              src="/images/resto_laonce.jpg"
              alt="Recogida"
            />
          </div>
        </div>
      </aside>

      <!-- Sección derecha (Menú con tabs) -->
      <div class="flex-1">
        <!-- Tabs para días de la semana -->
        <div class="flex border-b border-gray-200 overflow-x-auto no-scrollbar">
          <button
            v-for="(day, index) in days"
            :key="index"
            @click="activeTab = index"
            class="flex-1 py-3 text-center text-sm font-medium transition duration-300 uppercase tracking-wider whitespace-nowrap"
            :class="{
              'border-b-4 border-orange-500 text-orange-600 font-bold':
                activeTab === index,
              'text-gray-500 hover:text-orange-500': activeTab !== index
            }"
          >
            {{ day }}
            <span class="text-xs text-gray-400 block mt-1">
              {{ menu.find(i => i.day_of_week === index)?.date_formated || '' }}
            </span>
          </button>
        </div>

        <!-- Lista de platos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
          <div
            v-for="item in menu.filter(i => i.day_of_week === activeTab && i.dish.type == 'Segundo')"
            :key="item.dish.id"
            class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col hover:shadow-xl transition duration-300 menu-item"
          >
            <!-- Imagen del plato -->
             <!-- :src="`/images/dishes/${item.dish.image || 'no-image'}.jpg`" -->
            <div class="relative h-40">
              <img
                :src="item.dish.image ? `/storage/${item.dish.image}` : '/images/no-image.jpg'"
                alt="Imagen del plato"
                class="absolute inset-0 w-full h-full object-cover"
              />
            </div>

            <!-- Información del plato -->
            <div class="p-4 flex flex-col justify-between flex-1">
              <h3
                class="text-lg font-semibold text-gray-800 line-clamp-2 text-center"
              >
                {{ item.dish.name }}
              </h3>
              <p class="text-sm text-gray-500 mt-2 line-clamp-3 text-center">
                {{ item.dish.description || 'Sin descripción disponible' }}
              </p>
              <select class="form-control" v-if="cartStore.getCartItem(item.dish.id)" @change="cartStore.addExtraDishToCart(item.dish.id, extraDishes.find(i => i.id == $event.target.value))">
                <option value="null">Sin Entrada</option>
                <option :selected="cartStore.getCartItem(item.dish.id) && cartStore.getCartItem(item.dish.id).extra_dishes.length > 0 && cartStore.getCartItem(item.dish.id).extra_dishes[0].id == extra.dish.id" 
                  v-for="extra in menu.filter(i => i.day_of_week === activeTab && i.dish.type == 'Entrada')" :value="extra.dish.id">{{ extra.dish.name }}</option>
              </select>
              <div class="flex items-center justify-between mt-4">
                <span class="text-lg font-semibold text-orange-600">S/ {{ item.dish.price }}</span>
                <div>
                  <button
                    v-if="!cartStore.getCartItem(item.dish.id)"
                    @click="cartStore.addToCart(item.dish, item.date)"
                    class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition duration-300"
                  >
                    Agregar
                  </button>
                  <button
                    v-else
                    @click="cartStore.substractFromCart(item.dish.id)"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 flex items-center gap-2"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M9 3v1H4v2h16V4h-5V3H9zM5 7h14v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7zm6 3v7h2v-7h-2z" />
                    </svg>
                    Quitar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from "@/stores/cartStore";
import { ref } from "vue";

const props = defineProps({
  menu: Array,
  extraDishes: Array,
});
const days = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
const activeTab = ref(0);
const cartStore = useCartStore();
</script>

<style scoped>
.menu-item img {
  transition: transform 0.3s ease-in-out;
}
.menu-item img:hover {
  transform: scale(1.05);
}

button {
  transition: background-color 0.3s ease, color 0.3s ease;
}

.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
