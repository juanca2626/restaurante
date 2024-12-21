<template>
  <div>
    <navbar></navbar>
    <div v-if="uiStore.sidebarIsOpen" class="cover-overflow"></div>
    <slot></slot>
  </div>
</template>
	
<script setup>
  import Navbar from '@/components/Navbar.vue'
  import { useUiStore } from '@/stores/uiStore';
  import { onMounted } from 'vue';

  const uiStore = useUiStore();

  const props = defineProps({
    saveOrderUri: '',
    getCustomerDataUri: ''
  })

  onMounted(() => {
    uiStore.saveOrderUri = props.saveOrderUri;
    uiStore.getCustomerDataUri = props.getCustomerDataUri;
  })
</script>