<template>
  <div v-show="uiStore.sidebarIsOpen" class="sidebar-cart" :class="{open: 'open'}">
    <div class="py-3 header flex">
      <img class="cursor-pointer" src="/icons/chevron-left.svg" @click="goToPreviousPage" alt="">
      <div class="text-red text-center text-2xl font-semibold" style="margin:0 auto">RestoRapi - LaOnce</div>
    </div>
    <div v-if="cartStore.cart.length > 0">
      <div class="body">
        <div v-if="page == 1">
          <div>
            <div class="pb-3 font-bold">Carrito ({{ cartStore.cart.length }})</div>
            <ul class="border border-transparent">
              <template v-for="(day, dayIndex) in days">
                <li>
                <div v-if="cartStore.cart.filter(i => new Date(i.date).getDay() == dayIndex).length > 0" class="font-semibold text-sm pb-1 underline text-red">{{ day }}</div>
                  <div v-for="(item, index) in cartStore.cart.filter(i => new Date(i.date).getDay() == dayIndex)" :key="index" 
                    class="menu-item sidebar-item relative">
                    <div class="flex flex-1 flex-col py-3 pr-2">
                      <div class="pb-1 pl-2">
                        <p class="text-base font-semibold text-left line-clamp-2 text-ellipsis sm:text-sm md:text-sm lg:text-lg xl:text-lg"
                          style="color: rgb(2, 6, 23);">
                          <span class="mr-5 text-md">{{ item.name }}</span>
                          <span class="text-red text-base text-md text-left">S/&nbsp;{{ item.price }}</span>
                          </p>
                      </div>                    
                      <div class="absolute right-2 top-3 flex justify-end pb-2">
                        <div class="flex">
                          <span @click="cartStore.substractFromCart(item.dish_id)">
                            <img src="/icons/trash.svg" alt="">                          
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </template>
            </ul>
            <div class="text-red text-xs underline cursor-pointer text-right mb-10 font-semibold" @click="cartStore.clean()">Vaciar carrito</div>
            <div class="flex h-full flex-1 items-center justify-center cursor-pointer text-sm font-semibold text-red mb-10" @click="uiStore.sidebarIsOpen = false">Ver más productos <img src="/icons/chevron-right.svg" alt=""></div>
          </div>
          <div>
            <div class="flex flex-col gap-2">
              <div class="pb-2 font-bold">Observación</div>
              <textarea rows="3" v-model="cartStore.detail" placeholder="Escribe aquí la observación de tu pedido" class="kyteInput focus:border-theme-custom-primary border-gray-eee py-2 text-sm min-h-[102px]" maxlength="200" name="observation"></textarea>
              <p class="text-xs font-normal text-left pt-2 text-right" style="color: rgb(148, 163, 184);">@{{cartStore.detail.length}}/200</p>
            </div>
          </div>
        </div>
        <div v-else-if="page == 2">
          <div class="mb-4">
            <div class="pb-3 font-bold">Datos</div>
            <div class="form-group">
              <label for="">DNI</label>
              <input type="text" v-model="dni" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Nombre y apellido</label>
              <input type="text" v-model="name" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Dirección</label>
              <input type="text" v-model="address" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Celular</label>
              <input type="text" v-model="cellphone" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="make-order">
        <div class="flex mb-3 justify-between">
          <div class="font-semibold">Total</div>
          <div class="font-bold">S/ {{ cartStore.total }}</div>
        </div>
        <button v-if="page == 1" class="make-order-button" @click="page = 2" type="button">Continuar para finalizar</button>
        <button v-else-if="page == 2" class="make-order-button" @click="makeOrder()" :disabled="loading"  type="button"> {{ loading ? 'Cargando' : 'Hacer pedido' }} </button>
      </div>
    </div>
    <div v-else-if="page == 3" class="flex justify-center items-center">
      <div class="flex flex-col items-center gap-9">
        <svg width="50%" viewBox="0 0 174 143" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.13086 27.2652C2.13086 23.1742 5.4472 19.8579 9.53811 19.8579H23.5536C24.8949 19.8579 25.9822 20.9452 25.9822 22.2865V32.2438C25.9822 33.5851 24.8948 34.6724 23.5536 34.6724H9.53811C5.44719 34.6724 2.13086 31.3561 2.13086 27.2652Z" fill="#A9B1BE" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="66.4055" cy="129.731" r="10.7825" fill="#A9B1BE" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></circle><circle cx="115.214" cy="129.731" r="10.7825" fill="#A9B1BE" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></circle><circle cx="66.4048" cy="129.731" r="5.60791" fill="white" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></circle><circle cx="115.213" cy="129.731" r="5.60791" fill="white" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></circle><path d="M26.1309 31.4128V23.5608L35.9768 23.512C38.2564 23.5537 40.8261 25.0458 41.5379 28.4497L56.7635 107.945C56.9416 108.748 57.257 108.927 58.0582 108.936L130.129 108.892C136.833 108.921 136.919 118.16 130.129 118.225L56.2043 118.374C52.7043 118.145 49.9433 114.754 49.0933 110.966L33.8344 31.4128H26.1309Z" fill="#A9B1BE" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></path><path d="M145.503 39.4316H43.7129L54.3467 94.968H137.226C140.666 95.0164 142.7 93.7051 143.964 90.4761L151.921 47.8131C153.083 41.3466 150.014 39.3006 145.503 39.4316Z" fill="white" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></path><path d="M145.503 39.4316H43.7129L54.3467 94.968H137.226C140.666 95.0164 142.7 93.7051 143.964 90.4761L151.921 47.8131C153.083 41.3466 150.014 39.3006 145.503 39.4316Z" fill="white" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></path><path d="M64.5023 39.462C64.3808 38.6325 63.6098 38.0587 62.7804 38.1803C61.951 38.3018 61.3771 39.0727 61.4987 39.9022L64.5023 39.462ZM69.5926 95.132C69.7141 95.9615 70.4851 96.5353 71.3145 96.4137C72.1439 96.2922 72.7178 95.5213 72.5962 94.6918L69.5926 95.132ZM88.4983 39.7567C88.4783 38.9187 87.7827 38.2556 86.9447 38.2756C86.1066 38.2956 85.4435 38.9912 85.4635 39.8292L88.4983 39.7567ZM86.7725 94.6205C86.7925 95.4586 87.4881 96.1217 88.3261 96.1017C89.1642 96.0817 89.8273 95.3861 89.8073 94.548L86.7725 94.6205ZM113.224 39.51C113.224 38.6717 112.545 37.9922 111.707 37.9922C110.868 37.9922 110.189 38.6717 110.189 39.51L113.224 39.51ZM104.368 93.9445L104.188 95.4516L107.202 95.8126L107.382 94.3055L104.368 93.9445ZM135.856 39.7956C135.982 38.9669 135.413 38.1928 134.584 38.0666C133.755 37.9405 132.981 38.5101 132.855 39.3388L135.856 39.7956ZM124.456 94.5197C124.329 95.3484 124.899 96.1225 125.728 96.2487C126.556 96.3748 127.331 95.8052 127.457 94.9765L124.456 94.5197ZM146.263 79.0705C147.101 79.0705 147.781 78.3909 147.781 77.5526C147.781 76.7143 147.101 76.0348 146.263 76.0348V79.0705ZM51.4424 76.0348C50.6042 76.0348 49.9246 76.7143 49.9246 77.5526C49.9246 78.3909 50.6042 79.0705 51.4424 79.0705V76.0348ZM150.026 59.746C150.864 59.7481 151.546 59.0702 151.548 58.2319C151.55 57.3936 150.872 56.7124 150.034 56.7103L150.026 59.746ZM47.4178 56.4581C46.5795 56.456 45.8983 57.1339 45.8962 57.9722C45.8942 58.8105 46.572 59.4917 47.4103 59.4938L47.4178 56.4581ZM61.4987 39.9022L69.5926 95.132L72.5962 94.6918L64.5023 39.462L61.4987 39.9022ZM85.4635 39.8292L86.7725 94.6205L89.8073 94.548L88.4983 39.7567L85.4635 39.8292ZM110.189 39.51C110.189 39.4623 110.185 39.5412 110.153 39.8946C110.127 40.1919 110.087 40.6144 110.035 41.1509C109.931 42.2231 109.78 43.7413 109.592 45.6036C109.216 49.3277 108.692 54.4228 108.1 60.0675C106.915 71.3595 105.458 84.84 104.368 93.9445L107.382 94.3055C108.475 85.1773 109.934 71.6779 111.119 60.3843C111.712 54.7362 112.236 49.6371 112.613 45.9084C112.801 44.0443 112.952 42.5214 113.056 41.4431C113.108 40.9044 113.149 40.4743 113.177 40.1674C113.199 39.9166 113.224 39.6396 113.224 39.51L110.189 39.51ZM132.855 39.3388L124.456 94.5197L127.457 94.9765L135.856 39.7956L132.855 39.3388ZM146.263 76.0348H51.4424V79.0705H146.263V76.0348ZM150.034 56.7103L47.4178 56.4581L47.4103 59.4938L150.026 59.746L150.034 56.7103Z" fill="#444E5E"></path><path d="M50.1391 39.7294L44.375 39.8574L55.3907 94.5517L70.7615 94.6798L69.6087 88.0191L63.3323 88.1472C60.9751 88.1394 59.9278 86.8166 59.2334 84.1764L50.1391 39.7294Z" fill="#A9B1BE"></path><path d="M69.773 39.7294L63.6191 39.8574L72.3697 94.0731L87.7404 94.2012L87.3618 87.5405L81.0854 87.6686C78.7283 87.6609 77.2965 86.338 76.6022 83.6978L69.773 39.7294Z" fill="#A9B1BE"></path><path d="M93.9438 39.7294L88.1797 39.8574L89.1152 93.9824L104.486 94.1105L105.487 87.4498L98.3595 87.5779C96.0023 87.5702 94.262 86.2716 94.2606 83.6072L93.9438 39.7294Z" fill="#A9B1BE"></path><path d="M118.168 40.3792L112.404 40.5073L107.156 93.9682L142.592 94.0591L143.593 87.3985L117.208 87.4416C114.851 87.4338 113.226 85.9141 113.452 83.2497L118.168 40.3792Z" fill="#A9B1BE"></path><path d="M145.503 39.4316H43.7129L54.3467 94.968H137.226C140.666 95.0164 142.7 93.7051 143.964 90.4761L151.921 47.8131C153.083 41.3466 150.014 39.3006 145.503 39.4316Z" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></path><path d="M64.5023 39.462C64.3808 38.6325 63.6098 38.0587 62.7804 38.1803C61.951 38.3018 61.3771 39.0727 61.4987 39.9022L64.5023 39.462ZM69.5926 95.132C69.7141 95.9615 70.4851 96.5353 71.3145 96.4137C72.1439 96.2922 72.7178 95.5213 72.5962 94.6918L69.5926 95.132ZM88.4983 39.7567C88.4783 38.9187 87.7827 38.2556 86.9447 38.2756C86.1066 38.2956 85.4435 38.9912 85.4635 39.8292L88.4983 39.7567ZM86.7725 94.6205C86.7925 95.4586 87.4881 96.1217 88.3261 96.1017C89.1642 96.0817 89.8273 95.3861 89.8073 94.548L86.7725 94.6205ZM113.224 39.51C113.224 38.6717 112.545 37.9922 111.707 37.9922C110.868 37.9922 110.189 38.6717 110.189 39.51L113.224 39.51ZM104.368 93.9445L104.188 95.4516L107.202 95.8126L107.382 94.3055L104.368 93.9445ZM135.856 39.7956C135.982 38.9669 135.413 38.1928 134.584 38.0666C133.755 37.9405 132.981 38.5101 132.855 39.3388L135.856 39.7956ZM124.456 94.5197C124.329 95.3484 124.899 96.1225 125.728 96.2487C126.556 96.3748 127.331 95.8052 127.457 94.9765L124.456 94.5197ZM146.263 79.0705C147.101 79.0705 147.781 78.3909 147.781 77.5526C147.781 76.7143 147.101 76.0348 146.263 76.0348V79.0705ZM51.4424 76.0348C50.6042 76.0348 49.9246 76.7143 49.9246 77.5526C49.9246 78.3909 50.6042 79.0705 51.4424 79.0705V76.0348ZM150.026 59.746C150.864 59.7481 151.546 59.0702 151.548 58.2319C151.55 57.3936 150.872 56.7124 150.034 56.7103L150.026 59.746ZM47.4178 56.4581C46.5795 56.456 45.8983 57.1339 45.8962 57.9722C45.8942 58.8105 46.572 59.4917 47.4103 59.4938L47.4178 56.4581ZM61.4987 39.9022L69.5926 95.132L72.5962 94.6918L64.5023 39.462L61.4987 39.9022ZM85.4635 39.8292L86.7725 94.6205L89.8073 94.548L88.4983 39.7567L85.4635 39.8292ZM110.189 39.51C110.189 39.4623 110.185 39.5412 110.153 39.8946C110.127 40.1919 110.087 40.6144 110.035 41.1509C109.931 42.2231 109.78 43.7413 109.592 45.6036C109.216 49.3277 108.692 54.4228 108.1 60.0675C106.915 71.3595 105.458 84.84 104.368 93.9445L107.382 94.3055C108.475 85.1773 109.934 71.6779 111.119 60.3843C111.712 54.7362 112.236 49.6371 112.613 45.9084C112.801 44.0443 112.952 42.5214 113.056 41.4431C113.108 40.9044 113.149 40.4743 113.177 40.1674C113.199 39.9166 113.224 39.6396 113.224 39.51L110.189 39.51ZM132.855 39.3388L124.456 94.5197L127.457 94.9765L135.856 39.7956L132.855 39.3388ZM146.263 76.0348H51.4424V79.0705H146.263V76.0348ZM150.034 56.7103L47.4178 56.4581L47.4103 59.4938L150.026 59.746L150.034 56.7103Z" fill="#444E5E"></path><circle cx="103.671" cy="26.8471" r="24.8471" fill="var(--kyte-custom-primary)" stroke="#444E5E" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></circle><path d="M124.544 26.894C124.544 15.3659 115.199 6.02051 103.672 6.02051" stroke="white" stroke-width="3.03571" stroke-linecap="round" stroke-linejoin="round"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M98.139 35.0846C98.1439 35.0896 98.1488 35.0945 98.1537 35.0994C99.3237 36.2694 101.033 36.5722 102.481 36.0077C102.987 35.8107 103.461 35.5079 103.87 35.0994C103.873 35.0962 103.876 35.093 103.88 35.0898L113.302 25.6677C114.88 24.0892 114.88 21.5299 113.302 19.9514C111.723 18.373 109.164 18.373 107.585 19.9514L101.012 26.525L99.3923 24.9054C97.8138 23.327 95.2545 23.327 93.6761 24.9054C92.0976 26.4839 92.0976 29.0432 93.6761 30.6216L98.139 35.0846Z" fill="white"></path><path d="M98.139 35.0846L99.2177 34.0168L99.2123 34.0113L98.139 35.0846ZM102.481 36.0077L101.93 34.5934L101.93 34.5934L102.481 36.0077ZM103.87 35.0994L104.943 36.1727L104.943 36.1726L103.87 35.0994ZM103.88 35.0898L102.806 34.0165L102.803 34.02L103.88 35.0898ZM113.302 25.6677L114.375 26.7409L113.302 25.6677ZM107.585 19.9514L108.659 21.0247V21.0247L107.585 19.9514ZM101.012 26.525L99.9386 27.5983C100.531 28.1911 101.492 28.1911 102.085 27.5983L101.012 26.525ZM99.3923 24.9054L100.466 23.8322V23.8322L99.3923 24.9054ZM93.6761 30.6216L92.6028 31.6949H92.6028L93.6761 30.6216ZM99.227 34.0261C99.2239 34.023 99.2208 34.0199 99.2177 34.0168L97.0603 36.1525C97.067 36.1592 97.0737 36.166 97.0804 36.1727L99.227 34.0261ZM101.93 34.5934C101.022 34.9472 99.956 34.7551 99.227 34.0261L97.0804 36.1727C98.6915 37.7837 101.043 38.1972 103.032 37.422L101.93 34.5934ZM102.797 34.0261C102.54 34.2832 102.244 34.4712 101.93 34.5934L103.032 37.4221C103.73 37.1502 104.383 36.7326 104.943 36.1727L102.797 34.0261ZM102.803 34.02C102.801 34.022 102.799 34.0241 102.797 34.0261L104.943 36.1726C104.948 36.1683 104.952 36.1639 104.956 36.1595L102.803 34.02ZM112.228 24.5944L102.806 34.0165L104.953 36.163L114.375 26.7409L112.228 24.5944ZM112.228 21.0247C113.214 22.0105 113.214 23.6086 112.228 24.5944L114.375 26.7409C116.546 24.5697 116.546 21.0494 114.375 18.8782L112.228 21.0247ZM108.659 21.0247C109.644 20.039 111.243 20.039 112.228 21.0247L114.375 18.8782C112.204 16.7069 108.683 16.7069 106.512 18.8782L108.659 21.0247ZM102.085 27.5983L108.659 21.0247L106.512 18.8782L99.9386 25.4518L102.085 27.5983ZM98.319 25.9787L99.9386 27.5983L102.085 25.4518L100.466 23.8322L98.319 25.9787ZM94.7493 25.9787C95.7351 24.993 97.3333 24.993 98.319 25.9787L100.466 23.8322C98.2943 21.6609 94.774 21.6609 92.6028 23.8322L94.7493 25.9787ZM94.7493 29.5484C93.7636 28.5626 93.7636 26.9645 94.7493 25.9787L92.6028 23.8322C90.4315 26.0034 90.4315 29.5237 92.6028 31.6949L94.7493 29.5484ZM99.2123 34.0113L94.7493 29.5484L92.6028 31.6949L97.0657 36.1579L99.2123 34.0113Z" fill="#444E5E"></path></svg>
        <p class="text-center text-red text-3xl font-bold">¡Pedido enviado!</p>
        <p class="text-center text-xl" style="width:70%">Nos comunicaremos contigo en breve para confirmar los detalles de tu compra. <br> ¡Gracias por elegirnos!</p>
        <button class="keep-navigating-button" style="width:70%; margin:0 auto" @click="uiStore.sidebarIsOpen = false">Volver a la tienda</button>
      </div>
    </div>
    <div v-else class="flex justify-center items-center">
      <div class="flex flex-col items-center gap-9">
        <svg width="40%" viewBox="0 0 145 133" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="112.736" cy="20.5996" r="3" stroke="var(--kyte-custom-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></circle><circle cx="47.7362" cy="20.5996" r="3" stroke="var(--kyte-custom-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></circle><path d="M79.7362 7.59961V37.5996" stroke="var(--kyte-custom-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M90.5544 1.59961V20.3093C90.5544 24.9867 95.2135 29.6641 101.736 30.5996M70.9862 1.59961V20.3093C70.9862 25.9222 66.3271 28.7286 60.7362 30.5996" stroke="var(--kyte-custom-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M1.73624 37.4062C1.73624 34.0373 4.46734 31.3062 7.83633 31.3062H19.3785C20.4831 31.3062 21.3785 32.2016 21.3785 33.3062V41.5063C21.3785 42.6109 20.4831 43.5063 19.3785 43.5063H7.83633C4.46734 43.5063 1.73624 40.7752 1.73624 37.4062Z" fill="#A9B1BE" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="54.6678" cy="121.79" r="8.8797" fill="#A9B1BE" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></circle><circle cx="94.8629" cy="121.79" r="8.8797" fill="#A9B1BE" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></circle><circle cx="54.6678" cy="121.79" r="4.61829" fill="white" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></circle><circle cx="94.8629" cy="121.79" r="4.61829" fill="white" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></circle><path d="M21.5005 40.8219V34.3556L29.6089 34.3154C31.4863 34.3498 33.6025 35.5785 34.1887 38.3818L46.7274 103.848C46.8741 104.51 47.1339 104.657 47.7936 104.665L107.146 104.629C112.667 104.652 112.738 112.261 107.146 112.315L46.2669 112.437C43.3845 112.249 41.1108 109.456 40.4108 106.337L27.8446 40.8219H21.5005Z" fill="#A9B1BE" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M119.808 47.4257H35.9809L44.7382 93.1616H112.992C115.825 93.2015 117.5 92.1216 118.541 89.4624L125.093 54.3281C126.051 49.0028 123.523 47.3178 119.808 47.4257Z" fill="white" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M119.808 47.4257H35.9809L44.7382 93.1616H112.992C115.825 93.2015 117.5 92.1216 118.541 89.4624L125.093 54.3281C126.051 49.0028 123.523 47.3178 119.808 47.4257Z" fill="white" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M53.1018 47.4507C53.0017 46.7676 52.3668 46.295 51.6837 46.3951C51.0007 46.4952 50.5281 47.1301 50.6282 47.8132L53.1018 47.4507ZM57.2938 93.2967C57.3939 93.9797 58.0288 94.4523 58.7118 94.3522C59.3949 94.2521 59.8675 93.6172 59.7674 92.9342L57.2938 93.2967ZM72.8632 47.6934C72.8467 47.0033 72.2739 46.4572 71.5837 46.4736C70.8936 46.4901 70.3475 47.063 70.3639 47.7531L72.8632 47.6934ZM71.4419 92.8754C71.4584 93.5656 72.0313 94.1117 72.7214 94.0952C73.4116 94.0787 73.9577 93.5059 73.9412 92.8157L71.4419 92.8754ZM93.2259 47.4902C93.2259 46.7999 92.6663 46.2402 91.9759 46.2402C91.2856 46.2402 90.7259 46.7999 90.7259 47.4902L93.2259 47.4902ZM85.9325 92.3187L85.7838 93.5599L88.2661 93.8571L88.4147 92.616L85.9325 92.3187ZM111.864 47.7254C111.968 47.0429 111.499 46.4055 110.816 46.3016C110.134 46.1977 109.496 46.6667 109.392 47.3492L111.864 47.7254ZM102.475 92.7924C102.371 93.4749 102.84 94.1124 103.523 94.2163C104.205 94.3201 104.843 93.8511 104.947 93.1686L102.475 92.7924ZM120.434 80.0695C121.125 80.0695 121.684 79.5098 121.684 78.8195C121.684 78.1291 121.125 77.5695 120.434 77.5695V80.0695ZM42.3466 77.5695C41.6562 77.5695 41.0966 78.1291 41.0966 78.8195C41.0966 79.5098 41.6562 80.0695 42.3466 80.0695V77.5695ZM123.533 64.1552C124.224 64.1569 124.785 63.5986 124.786 62.9083C124.788 62.2179 124.23 61.6569 123.539 61.6552L123.533 64.1552ZM39.0322 61.4475C38.3418 61.4458 37.7808 62.0041 37.7791 62.6944C37.7774 63.3848 38.3357 63.9458 39.026 63.9475L39.0322 61.4475ZM50.6282 47.8132L57.2938 93.2967L59.7674 92.9342L53.1018 47.4507L50.6282 47.8132ZM70.3639 47.7531L71.4419 92.8754L73.9412 92.8157L72.8632 47.6934L70.3639 47.7531ZM90.7259 47.4902C90.7259 47.4509 90.7231 47.5159 90.6968 47.807C90.6747 48.0518 90.6419 48.3997 90.5992 48.8415C90.5137 49.7245 90.3896 50.9748 90.2348 52.5085C89.9252 55.5754 89.4937 59.7714 89.0059 64.42C88.0302 73.7192 86.8304 84.8209 85.9325 92.3187L88.4147 92.616C89.315 85.0987 90.5164 73.9815 91.4923 64.6809C91.9803 60.0295 92.4122 55.8302 92.7221 52.7595C92.8771 51.2243 93.0016 49.9702 93.0875 49.0822C93.1305 48.6386 93.1639 48.2844 93.1867 48.0316C93.2053 47.8251 93.2259 47.597 93.2259 47.4902L90.7259 47.4902ZM109.392 47.3492L102.475 92.7924L104.947 93.1686L111.864 47.7254L109.392 47.3492ZM120.434 77.5695H42.3466V80.0695H120.434V77.5695ZM123.539 61.6552L39.0322 61.4475L39.026 63.9475L123.533 64.1552L123.539 61.6552Z" fill="#444E5E"></path><path d="M41.2718 47.6709L36.5249 47.7764L45.5967 92.8187L58.2549 92.9242L57.3056 87.439L52.1368 87.5445C50.1956 87.5381 49.333 86.4486 48.7612 84.2744L41.2718 47.6709Z" fill="#A9B1BE"></path><path d="M57.4416 47.6709L52.3737 47.7764L59.58 92.4246L72.2383 92.5301L71.9265 87.0448L66.7577 87.1503C64.8165 87.1439 63.6374 86.0545 63.0656 83.8803L57.4416 47.6709Z" fill="#A9B1BE"></path><path d="M77.347 47.6709L72.6001 47.7764L73.3706 92.3499L86.0289 92.4554L86.8531 86.9702L80.9835 87.0757C79.0423 87.0693 77.6091 85.9998 77.6079 83.8056L77.347 47.6709Z" fill="#A9B1BE"></path><path d="M97.2968 48.2061L92.5499 48.3115L88.2285 92.3382L117.411 92.4131L118.235 86.9279L96.5068 86.9633C94.5657 86.9569 93.227 85.7055 93.413 83.5112L97.2968 48.2061Z" fill="#A9B1BE"></path><path d="M119.808 47.4257H35.9809L44.7382 93.1616H112.992C115.825 93.2015 117.5 92.1216 118.541 89.4624L125.093 54.3281C126.051 49.0028 123.523 47.3178 119.808 47.4257Z" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M53.1018 47.4507C53.0017 46.7676 52.3668 46.295 51.6837 46.3951C51.0007 46.4952 50.5281 47.1301 50.6282 47.8132L53.1018 47.4507ZM57.2938 93.2967C57.3939 93.9797 58.0288 94.4523 58.7118 94.3522C59.3949 94.2521 59.8675 93.6172 59.7674 92.9342L57.2938 93.2967ZM72.8632 47.6934C72.8467 47.0033 72.2739 46.4572 71.5837 46.4736C70.8936 46.4901 70.3475 47.063 70.3639 47.7531L72.8632 47.6934ZM71.4419 92.8754C71.4584 93.5656 72.0313 94.1117 72.7214 94.0952C73.4116 94.0787 73.9577 93.5059 73.9412 92.8157L71.4419 92.8754ZM93.2259 47.4902C93.2259 46.7999 92.6663 46.2402 91.9759 46.2402C91.2856 46.2402 90.7259 46.7999 90.7259 47.4902L93.2259 47.4902ZM85.9325 92.3187L85.7838 93.5599L88.2661 93.8571L88.4147 92.616L85.9325 92.3187ZM111.864 47.7254C111.968 47.0429 111.499 46.4055 110.816 46.3016C110.134 46.1977 109.496 46.6667 109.392 47.3492L111.864 47.7254ZM102.475 92.7924C102.371 93.4749 102.84 94.1124 103.523 94.2163C104.205 94.3201 104.843 93.8511 104.947 93.1686L102.475 92.7924ZM120.434 80.0695C121.125 80.0695 121.684 79.5098 121.684 78.8195C121.684 78.1291 121.125 77.5695 120.434 77.5695V80.0695ZM42.3466 77.5695C41.6562 77.5695 41.0966 78.1291 41.0966 78.8195C41.0966 79.5098 41.6562 80.0695 42.3466 80.0695V77.5695ZM123.533 64.1552C124.224 64.1569 124.785 63.5986 124.786 62.9083C124.788 62.2179 124.23 61.6569 123.539 61.6552L123.533 64.1552ZM39.0322 61.4475C38.3418 61.4458 37.7808 62.0041 37.7791 62.6944C37.7774 63.3848 38.3357 63.9458 39.026 63.9475L39.0322 61.4475ZM50.6282 47.8132L57.2938 93.2967L59.7674 92.9342L53.1018 47.4507L50.6282 47.8132ZM70.3639 47.7531L71.4419 92.8754L73.9412 92.8157L72.8632 47.6934L70.3639 47.7531ZM90.7259 47.4902C90.7259 47.4509 90.7231 47.5159 90.6968 47.807C90.6747 48.0518 90.6419 48.3997 90.5992 48.8415C90.5137 49.7245 90.3896 50.9748 90.2348 52.5085C89.9252 55.5754 89.4937 59.7714 89.0059 64.42C88.0302 73.7192 86.8304 84.8209 85.9325 92.3187L88.4147 92.616C89.315 85.0987 90.5164 73.9815 91.4923 64.6809C91.9803 60.0295 92.4122 55.8302 92.7221 52.7595C92.8771 51.2243 93.0016 49.9702 93.0875 49.0822C93.1305 48.6386 93.1639 48.2844 93.1867 48.0316C93.2053 47.8251 93.2259 47.597 93.2259 47.4902L90.7259 47.4902ZM109.392 47.3492L102.475 92.7924L104.947 93.1686L111.864 47.7254L109.392 47.3492ZM120.434 77.5695H42.3466V80.0695H120.434V77.5695ZM123.539 61.6552L39.0322 61.4475L39.026 63.9475L123.533 64.1552L123.539 61.6552Z" fill="#444E5E"></path><path d="M11.7638 131.4H143.264" stroke="#444E5E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        <p class="text-center text-red text-2xl font-bold">Carrito Vacío</p>
        <p class="text-center text-xl" style="width:70%">¡Explore el catálogo y agregue artículos a su carrito!</p>
        <button class="keep-navigating-button" style="width:70%; margin:0 auto" @click="goToPreviousPage">Seguir Navegando</button>
      </div>
    </div>
  </div>
</template>
	
<script setup>
  import { useCartStore } from '@/stores/cartStore';
  import { useUiStore } from '@/stores/uiStore';
  import { ref, watch } from 'vue';

  const props = defineProps({
    menu: [],
    open: false
  })
  const days = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
  const uiStore = useUiStore();
  const cartStore = useCartStore();
  const loading = ref(false);
  const page = ref(1);    
  const name = ref('');
  const cellphone = ref('');  
  const dni = ref('');  
  const address = ref('');

  watch(dni, (value) => {
    if (value) {
      getCustomerData()
    }
  })

  const makeOrder = () => {
    if (!dni.value) { alert('Llena el campo DNI'); return; }
    loading.value = true;
    fetch(`${uiStore.saveOrderUri}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        cart: cartStore.cart,
        name: name.value,
        cellphone: cellphone.value,
        dni: dni.value,
        address: address.value,
        total: cartStore.total,
        detail: cartStore.detail
      })
    })
    .then(async response => {
      loading.value = false;
      const data = await response.json();
      if (!response.ok) {
        const error = (data && data.message) || response.status;
        return Promise.reject(error);
      }
      cartStore.clean();
      cleanFields();
      page.value = 3;
      setTimeout(() => {
        window.location.reload();
      }, 2000);
    }).catch(error => {
      loading.value = false;      
      alert(error);
    })
  }

  const getCustomerData = () => {    
    fetch(`${uiStore.getCustomerDataUri.replace(':dni', dni.value)}`, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    }).then(async response => {
      const data = await response.json();
      if (!data.name) {
        const isNumeric= !isNaN(dni.value) && !isNaN(parseFloat(dni.value));
        if (!isNumeric) {
          name.value = '';
          cellphone.value = '';
          address.value = '';
        }
          return;
      }
      name.value = data.name;
      cellphone.value = data.cellphone;
      address.value = data.address;
    })
  }

  const goToPreviousPage = () => {
    if (page.value == 2) { 
      page.value -= 1;
      return;
    }
    uiStore.sidebarIsOpen = false;
    page.value = 1;
  }

  const cleanFields = () => {
    name.value = '';
    cellphone.value = '';
    dni.value = ''
    address.value = '';
  }

  const getDish = (dish_id) => {
    return props.menu.map(i => i.dish).find(i => i.id == dish_id)
  }
</script>