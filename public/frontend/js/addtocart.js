// document.addEventListener("DOMContentLoaded", function () {
//   let cart = [];
//   const cartModal = document.getElementById("shoppingCart");
//   if (!cartModal) return;

//   const cartContentContainer = cartModal.querySelector(".tf-mini-cart-sroll .p-4");
//   const subtotalElement = cartModal.querySelector(".tf-totals-total-value");

//   // ---------- Helpers ----------
//   const extractLastPriceNumber = (el) => {
//     const text = (el?.textContent || "").replace(/,/g, "");
//     const nums = text.match(/\d+(?:\.\d+)?/g);
//     return nums ? parseFloat(nums[nums.length - 1]) : 0;
//   };

//   const openCartModal = () => {
//     const modal = bootstrap.Modal.getOrCreateInstance(cartModal);
//     modal.show();
//   };

//   const resetBodyAndBackdrop = () => {
//     document.body.classList.remove("modal-open");
//     document.body.style.overflow = "";
//     document.body.style.paddingRight = "";
//     document.querySelectorAll(".modal-backdrop").forEach(b => b.remove());
//   };

//   const setBtnAdded = (btn) => {
//     if (!btn) return;
//     btn.textContent = "Already Added";
//     btn.classList.add("disabled");
//     btn.style.pointerEvents = "none";
//   };

//   const setBtnAddToCart = (btn, isList) => {
//     if (!btn) return;
//     btn.textContent = isList ? "Add to cart" : "ADD TO CART";
//     btn.classList.remove("disabled");
//     btn.style.pointerEvents = "";
//   };

//   // Update cart icon count
//   const updateCartCount = () => {
//     const countEl = document.querySelector(".nav-cart .count-box");
//     if (!countEl) return;
//     const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
//     countEl.textContent = totalItems;
//   };

//   // ---------- UI updates ----------
//   function updateCartUI() {
//     if (!cart.length) {
//       cartContentContainer.innerHTML = `
//         Your Cart is empty. Start adding favorite products to cart!
//         <a class="btn-line" href="/shop-default-grid">Explore Products</a>
//       `;
//       subtotalElement.textContent = "$0.00";
//       return;
//     }

//     cartContentContainer.innerHTML = cart.map(item => `
//       <div class="tf-mini-cart-item file-delete">
//         <div class="tf-mini-cart-image">
//           <img src="${item.image}" alt="${item.name}" width="60" height="60" style="object-fit:cover;">
//         </div>
//         <div class="tf-mini-cart-info flex-grow-1">
//           <div class="mb_12 d-flex align-items-center justify-content-between flex-wrap gap-12">
//             <div class="text-title">
//               <a class="link text-line-clamp-1" href="${item.url || '#'}">${item.name}</a>
//             </div>
//             <div class="text-button tf-btn-remove remove" data-name="${encodeURIComponent(item.name)}">Remove</div>
//           </div>
//           <div class="d-flex align-items-center justify-content-between flex-wrap gap-12">
//             <div class="text-secondary-2">XL/Blue</div>
//             <div class="text-button">${item.qty} X $${item.price.toFixed(2)}</div>
//           </div>
//         </div>
//       </div>
//     `).join("");

//     const subtotal = cart.reduce((s, it) => s + it.qty * it.price, 0);
//     subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
//   }

//   // ---------- Add to cart ----------
//   document.body.addEventListener("click", function (e) {
//     const addBtn = e.target.closest(".btn-main-product, .list-cart-item .link.text-button");
//     if (addBtn) {
//       e.preventDefault();

//       let name = "", price = 0, image = "", url = "", isList = false;

//       if (addBtn.closest(".card-product")) {
//         const card = addBtn.closest(".card-product");
//         name = card.querySelector(".title.link")?.textContent.trim() || "Unnamed Product";
//         price = extractLastPriceNumber(card.querySelector(".price"));
//         image = card.querySelector(".img-product")?.src || card.querySelector("img")?.src || "";
//         url = card.querySelector(".title.link")?.getAttribute("href") || "#";
//       } else if (addBtn.closest(".list-cart-item")) {
//         const li = addBtn.closest(".list-cart-item");
//         isList = true;
//         name = li.querySelector(".name a")?.textContent.trim() || "Unnamed Product";
//         price = extractLastPriceNumber(li.querySelector(".price, .text-button.price"));
//         image = li.querySelector(".image img")?.src || "";
//         url = li.querySelector(".name a")?.getAttribute("href") || "#";
//       }

//       let existing = cart.find(p => p.name === name);
//       if (existing) {
//         existing.qty++;
//       } else {
//         cart.push({ name, price, qty: 1, image, url });
//         setBtnAdded(addBtn);
//       }

//       updateCartUI();
//       updateCartCount(); // ✅ update icon count
//       openCartModal();
//       return;
//     }

//     // Remove item from mini-cart
//     if (e.target.classList.contains("tf-btn-remove") || e.target.classList.contains("remove")) {
//       const encoded = e.target.getAttribute("data-name") || "";
//       const productName = decodeURIComponent(encoded);
//       cart = cart.filter(it => it.name !== productName);
//       updateCartUI();
//       updateCartCount(); // ✅ update icon count

//       document.querySelectorAll(".card-product").forEach(card => {
//         const t = card.querySelector(".title.link");
//         if (t && t.textContent.trim() === productName) {
//           setBtnAddToCart(card.querySelector(".btn-main-product"), false);
//         }
//       });
//       document.querySelectorAll(".list-cart-item").forEach(li => {
//         const t = li.querySelector(".name a");
//         if (t && t.textContent.trim() === productName) {
//           setBtnAddToCart(li.querySelector(".link.text-button"), true);
//         }
//       });
//     }
//   });

//   // ---------- Scroll/backdrop fixes ----------
//   cartModal.addEventListener("hidden.bs.modal", function () {
//     resetBodyAndBackdrop();
//   });
//   document.addEventListener("hidden.bs.modal", resetBodyAndBackdrop);
//   document.querySelectorAll(".cart-close-btn, .icon-close-popup, [data-bs-dismiss='modal']").forEach(btn => {
//     btn.addEventListener("click", () => {
//       setTimeout(resetBodyAndBackdrop, 300);
//     });
//   });

//   // Set initial cart count
//   updateCartCount();
// });























// document.addEventListener("DOMContentLoaded", function () {
//   let cart = [];
//   const cartModal = document.getElementById("shoppingCart");
//   if (!cartModal) return;

//   const cartContentContainer = cartModal.querySelector(".tf-mini-cart-sroll .p-4");
//   const subtotalElement = cartModal.querySelector(".tf-totals-total-value");
//   const qtyInput = document.querySelector(".quantity-product");
//   const btnIncrease = document.querySelector(".btn-increase");
//   const btnDecrease = document.querySelector(".btn-decrease");
//   const addToCartBtn = document.querySelector(".btn-add-to-cart");
//   const totalPriceElement = document.querySelector(".tf-qty-price.total-price");

//   let basePrice = parseFloat(totalPriceElement.textContent.replace(/[^0-9.]/g, "")) || 0;

//   // ---------- Helpers ----------
//   const extractLastPriceNumber = (el) => {
//     const text = (el?.textContent || "").replace(/,/g, "");
//     const nums = text.match(/\d+(?:\.\d+)?/g);
//     return nums ? parseFloat(nums[nums.length - 1]) : 0;
//   };

//   const openCartModal = () => {
//     const modal = bootstrap.Modal.getOrCreateInstance(cartModal);
//     modal.show();
//   };

//   const resetBodyAndBackdrop = () => {
//     document.body.classList.remove("modal-open");
//     document.body.style.overflow = "";
//     document.body.style.paddingRight = "";
//     document.querySelectorAll(".modal-backdrop").forEach(b => b.remove());
//   };

//   const setBtnAdded = (btn) => {
//     if (!btn) return;
//     btn.querySelector("span:first-child").textContent = "Already Added -";
//     btn.classList.add("disabled");
//     btn.style.pointerEvents = "auto"; // still allow quantity updates
//   };

//   // Update button total price
//   const updateButtonPrice = () => {
//     const qty = parseInt(qtyInput.value) || 1;
//     totalPriceElement.textContent = `$${(basePrice * qty).toFixed(2)}`;
//   };

//   // Quantity controls
//   btnIncrease.addEventListener("click", () => {
//     qtyInput.value = parseInt(qtyInput.value) + 1;
//     updateButtonPrice();
//     updateCartItemQtyIfAdded();
//   });

//   btnDecrease.addEventListener("click", () => {
//     qtyInput.value = Math.max(1, parseInt(qtyInput.value) - 1);
//     updateButtonPrice();
//     updateCartItemQtyIfAdded();
//   });

//   qtyInput.addEventListener("input", () => {
//     if (parseInt(qtyInput.value) < 1) qtyInput.value = 1;
//     updateButtonPrice();
//     updateCartItemQtyIfAdded();
//   });

//   // ---------- Cart UI ----------
//   const updateCartCount = () => {
//     const countEl = document.querySelector(".nav-cart .count-box");
//     if (!countEl) return;
//     const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
//     countEl.textContent = totalItems;
//   };

//   function updateCartUI() {
//     if (!cart.length) {
//       cartContentContainer.innerHTML = `
//         Your Cart is empty. Start adding favorite products to cart!
//         <a class="btn-line" href="/shop-default-grid">Explore Products</a>
//       `;
//       subtotalElement.textContent = "$0.00";
//       return;
//     }

//     cartContentContainer.innerHTML = cart.map(item => `
//       <div class="tf-mini-cart-item file-delete">
//         <div class="tf-mini-cart-image">
//           <img src="${item.image}" alt="${item.name}" width="60" height="60" style="object-fit:cover;">
//         </div>
//         <div class="tf-mini-cart-info flex-grow-1">
//           <div class="mb_12 d-flex align-items-center justify-content-between flex-wrap gap-12">
//             <div class="text-title">
//               <a class="link text-line-clamp-1" href="${item.url || '#'}">${item.name}</a>
//             </div>
//             <div class="text-button tf-btn-remove remove" data-name="${encodeURIComponent(item.name)}">Remove</div>
//           </div>
//           <div class="d-flex align-items-center justify-content-between flex-wrap gap-12">
//             <div class="text-secondary-2">${item.variant || ""}</div>
//             <div class="text-button">${item.qty} X $${item.price.toFixed(2)}</div>
//           </div>
//         </div>
//       </div>
//     `).join("");

//     const subtotal = cart.reduce((s, it) => s + it.qty * it.price, 0);
//     subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
//   }

//   // ---------- Add to cart ----------
//   addToCartBtn.addEventListener("click", function () {
//     const name = document.querySelector(".tf-product-info-name h3.name")?.textContent.trim() || "Unnamed Product";

//     const price = basePrice;
//     const image = document.querySelector(".tf-product-media-main .swiper-slide img")?.src || "";
//     const url = window.location.href;
//     const qty = parseInt(qtyInput.value) || 1;

//     let existing = cart.find(p => p.name === name);
//     if (existing) {
//       existing.qty = qty; // update quantity if already added
//     } else {
//       cart.push({ name, price, qty, image, url });
//       setBtnAdded(addToCartBtn);
//     }

//     updateCartUI();
//     updateCartCount();
//     openCartModal();
//   });

//   // Update cart quantity if already added
//   function updateCartItemQtyIfAdded() {
//     const name = document.querySelector(".tf-product-info-name h3.name")?.textContent.trim() || "Unnamed Product";

//     const qty = parseInt(qtyInput.value) || 1;
//     const item = cart.find(p => p.name === name);
//     if (item) {
//       item.qty = qty;
//       updateCartUI();
//       updateCartCount();
//     }
//   }

//   // Remove item from mini-cart
//   document.body.addEventListener("click", function (e) {
//     if (e.target.classList.contains("tf-btn-remove") || e.target.classList.contains("remove")) {
//       const encoded = e.target.getAttribute("data-name") || "";
//       const productName = decodeURIComponent(encoded);
//       cart = cart.filter(it => it.name !== productName);
//       updateCartUI();
//       updateCartCount();
//       addToCartBtn.querySelector("span:first-child").textContent = "Add to cart -";
//       addToCartBtn.classList.remove("disabled");
//     }
//   });

//   // ---------- Scroll/backdrop fixes ----------
//   cartModal.addEventListener("hidden.bs.modal", resetBodyAndBackdrop);
//   document.addEventListener("hidden.bs.modal", resetBodyAndBackdrop);
//   document.querySelectorAll(".cart-close-btn, .icon-close-popup, [data-bs-dismiss='modal']").forEach(btn => {
//     btn.addEventListener("click", () => {
//       setTimeout(resetBodyAndBackdrop, 300);
//     });
//   });

//   // Initial price update
//   updateButtonPrice();
//   updateCartCount();
// });


