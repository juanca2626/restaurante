<template>
  <header class="py-3 flex">
    <div class="text-center text-2xl font-semibold">RestoRapi - LaOnce</div>
    <div class="cart-button flex" @click="uiStore.sidebarIsOpen = true"><img src="/icons/shopping-cart.svg" alt=""> <div>{{ cartStore.cart.reduce((sum, product) => sum + product.quantity, 0) }}</div></div>
  </header>
</template>

<script setup>
  import { useCartStore } from '@/stores/cartStore';
  import { useUiStore } from '@/stores/uiStore';

  const cartStore = useCartStore()
  const uiStore = useUiStore()
</script>
