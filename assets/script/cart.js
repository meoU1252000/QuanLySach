'use strict'
function showCart() {
    const cart = document.querySelector(".cart_wrap--list");
    cart.classList.toggle("hidden");
    const cartActive = document.querySelector(".cart_wrap");
    cartActive.classList.toggle("cart_wrap--active");
    if (!cartActive.classList.contains("cart_wrap--active")) {
      cartActive.classList.toggle("cart_wrap--no_active");
      setTimeout(() => {
        cartActive.classList.remove("cart_wrap--no_active");
      }, 1000);
    }
}
  
  /* Turn off Cart*/
  const removeCart = document.querySelector(".close_cart");
  const cartWrap = document.querySelector(".cart_wrap--list");
  const closeCartFunction = function () {
    cartWrap.classList.add("hidden");
    const cartActive = document.querySelector(".cart_wrap");
    cartActive.classList.remove("cart_wrap--active");
    if (!cartActive.classList.contains("cart_wrap--active")) {
      cartActive.classList.toggle("cart_wrap--no_active");
      setTimeout(() => {
        cartActive.classList.remove("cart_wrap--no_active");
      }, 1000);
    }
  };
  removeCart.addEventListener("click",closeCartFunction);

const userWrap = document.querySelector(".user_wrap");
function showAccountInfo(){
  userWrap.classList.toggle("hidden");
  userWrap.classList.toggle("userWrapActive");
}

const closeAccountInfo = function(){
  userWrap.classList.toggle("hidden");
  userWrap.classList.toggle("userWrapActive");
}

document.addEventListener('keydown', function (e) {
  // console.log(e.key);

  if (e.key === 'Escape' && !userWrap.classList.contains('hidden') ) {
    closeAccountInfo();
  }
});


