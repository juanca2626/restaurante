import { defineStore } from 'pinia'

export const useCartStore = defineStore('cartStore', {
  state: () => ({ 
    cart: [],
    detail: '',
    total: 0
  }),
  actions: {
    addToCart(dish, date = null) {
      let existingDish = this.cart.find(i => i.dish_id == dish.id);
      this.total += parseFloat(dish.price);
      if (existingDish) {
          existingDish.quantity += 1;
      } else {
          this.cart.push({
              dish_id: dish.id,
              extra_dishes: [],
              price: parseFloat(dish.price),
              name: dish.name,
              image: dish.image,
              quantity: 1,
              date: date
          });
      }
    },
    addExtraDishToCart(currentDishId, extraDish) {      
      let currentDish = this.cart.find(i => i.dish_id == currentDishId);
      if (extraDish === undefined) { 
        currentDish.extra_dishes = [];
        return;
      }
      if (currentDish.extra_dishes.length == 1) {
        currentDish.extra_dishes = [];
      }
      currentDish.extra_dishes.push({
        id: extraDish.id,
        name: extraDish.name,
        type: extraDish.type
      })
    },
    substractFromCart(dish_id) {
      let existingDish = this.cart.find(i => i.dish_id == dish_id);
      existingDish.quantity -= 1;
      this.total -= parseFloat(existingDish.price);
      if (existingDish.quantity == 0) {
          const index = this.cart.findIndex(i => i.dish_id === dish_id);
          this.cart.splice(index, 1);
      }
    },
    getCartItem(dish_id) {
      return this.cart.find(i => i.dish_id == dish_id);
    },
    clean() {
      this.cart = [];
      this.detail = '';
      this.total = 0;
    }
  },
  persist: true,
})