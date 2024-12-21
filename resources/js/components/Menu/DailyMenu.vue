<template>
  <div class="w-full mx-auto">    
    <div class="flex border-b border-gray-300">
      <button v-for="(day, index) in days" :key="index" @click="activeTab = index"
        class="flex-1 py-2 text-center text-sm font-medium focus:outline-none"
        :class="{
          'border-b-2 border-blue-500 text-blue-500': activeTab === index,
          'text-gray-500 hover:text-blue-500': activeTab !== index
        }"
      >
        {{ day }} {{ menu.find(i => i.day_of_week == index).date_formated }}
      </button>
    </div>

    <div class="p-4">
      <ul class="md:grid-cols-2 xl:grid-cols-2 grid md:px-side-space-sm sm:px-side-space-sm gap-2">
        <li v-for="item in menu.filter(i => i.day_of_week == activeTab)">
            <div class="menu-item">
                <img :src="`/storage/${item.dish.image}`" alt="">
                <div class="flex flex-1 flex-col py-3 pr-2 md:min-h-[120px] relative">
                    <div class="pb-1 pl-2 sm:h-10 md:h-10 lg:h-14 xl:h-14">
                        <p class="text-base font-light text-left line-clamp-2 text-ellipsis sm:text-sm md:text-sm lg:text-lg xl:text-lg"
                            style="color: rgb(2, 6, 23);">{{ item.dish.name }}</p>
                    </div>
                    <div class="flex items-end justify-between pl-2">
                        <div>
                            <div class="h-4"></div>
                            <p class="text-red text-base font-medium text-left sm:text-lg md:text-lg lg:text-xl xl:text-xl">S/&nbsp;{{ item.dish.price}}</p>
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-2 flex justify-end pb-2">
                        <button v-if="!cartStore.getCartItem(item.dish.id)" @click="cartStore.addToCart(item.dish, item.date)" class="add-to-cart-button">+</button>
                        <div v-else class="flex">
                            <span @click="cartStore.substractFromCart(item.dish.id)">
                                <img src="/icons/trash.svg" alt="">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    </div>
  </div>    
</template>

<script setup>    
    import { useCartStore } from '@/stores/cartStore';
    import { ref } from 'vue';

    const props = defineProps({
        menu: []
    })
    const days = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
    const activeTab = ref(0);
    const cartStore = useCartStore();
</script>