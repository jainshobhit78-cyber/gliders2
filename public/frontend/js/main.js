// header slider

// const { use } = require("react");

document.addEventListener("DOMContentLoaded", function () {
    // Initialize Swiper for Recent Products
    const recentProductsSwiper = new Swiper('.tf-product-header', {
        slidesPerView: 3,          // Number of products visible at once
        spaceBetween: 20,          // Space between slides
        loop: false,               // Set true if you want infinite loop
        speed: 600,                // Slide transition speed
        navigation: {              // Optional arrows
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {              // Optional pagination dots
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {             // Responsive settings
            0: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            992: {
                slidesPerView: 2,
                spaceBetween: 20
            }
        },
        // Optional: autoplay
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });

    // Optional: You can add custom actions here, like buttons or events
});







// home page slider

document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".tf-sw-slideshow", {
        spaceBetween: 10,
        slidesPerView: 3,
        breakpoints: {
            1024: { slidesPerView: 3 },
            768: { slidesPerView: 2 },
            0: { slidesPerView: 1.5 },
        },
    });
});


// Customer Say slider!

document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".tf-sw-testimonial .swiper", {
        loop: true,
        spaceBetween: 30,
        pagination: {
            el: ".sw-pagination-testimonial",
            clickable: true
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 15
            },
            768: {
                slidesPerView: 1.3,
                spaceBetween: 30
            },
            1024: {
                slidesPerView: 2,
                spaceBetween: 30
            }
        }
    });
});



// 14 days return slider

document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".tf-sw-iconbox", {
        loop: true,
        spaceBetween: 0, // No space between slides
        autoplay: {
            delay: 2500,
            disableOnInteraction: false
        },
        pagination: {
            el: ".sw-pagination-iconbox",
            clickable: true
        },
        breakpoints: {
            0: {
                slidesPerView: 1
            },
            576: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3
            },
            1200: {
                slidesPerView: 4
            }
        }
    });
});




// Shop Instagram

document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".tf-sw-shop-gallery", {
        loop: true,
        spaceBetween: 0, // No gap between slides
        autoplay: {
            delay: 2500,
            disableOnInteraction: false
        },
        breakpoints: {
            0: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 4
            },
            1199: {
                slidesPerView: 6
            }
        }
    });
});


// Today's Top Picks


// document.addEventListener("DOMContentLoaded", function () {
//     let allProducts = Array.from(document.querySelectorAll("#bottoms .tf-grid-layout .card-product"));

//     // Shuffle array
//     function shuffle(array) {
//         let arr = array.slice();
//         for (let i = arr.length - 1; i > 0; i--) {
//             let j = Math.floor(Math.random() * (i + 1));
//             [arr[i], arr[j]] = [arr[j], arr[i]];
//         }
//         return arr;
//     }

//     // Copy N products in random order
//     function copyProducts(tabId, count) {
//         let tabContent = document.querySelector(`#${tabId} .tf-grid-layout`);
//         if (tabContent) {
//             tabContent.innerHTML = "";
//             let shuffled = shuffle(allProducts).slice(0, count);
//             shuffled.forEach(product => {
//                 let clone = product.cloneNode(true);
//                 clone.classList.remove("show"); // reset
//                 tabContent.appendChild(clone);
//             });
//         }
//     }

//     // Assign different counts
//     copyProducts("onpieces", 6);
//     copyProducts("tops", 6);
//     copyProducts("skirts", 7);
//     copyProducts("dresses", 6);
//     copyProducts("sale", 7);
// });

// // Animation logic
// document.addEventListener("DOMContentLoaded", () => {
//     function animateProducts(targetId) {
//         let productCards = document.querySelectorAll(`${targetId} .card-product`);
//         productCards.forEach((card, index) => {
//             card.classList.remove("show");
//             setTimeout(() => card.classList.add("show"), index * 80);
//         });
//     }

//     document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
//         tab.addEventListener('shown.bs.tab', e => {
//             animateProducts(e.target.getAttribute('href'));
//         });
//     });

//     // First tab animation
//     let activeTab = document.querySelector('.nav-link.active');
//     if (activeTab) {
//         animateProducts(activeTab.getAttribute('href'));
//     }
// });





// Example products array (replace with your own)
// $(document).ready(function(){

//   // Hover swap for product images
//   $('.card-product .product-img').hover(function(){
//     var img1 = $(this).find('.img-product');
//     var img2 = $(this).find('.img-hover');
//     img1.hide();
//     img2.show();
//   }, function(){
//     var img1 = $(this).find('.img-product');
//     var img2 = $(this).find('.img-hover');
//     img2.hide();
//     img1.show();
//   });

//   // Initially hide hover images
//   $('.card-product .img-hover').hide();

//   // Optional: Pin click events
//   $('.tf-pin-btn').click(function(){
//     var pinId = $(this).find('span').attr('id');
//     alert("Pin clicked: " + pinId);  // Replace with your logic
//   });

// });



document.addEventListener("DOMContentLoaded", function () {
    const pin1 = document.getElementById("pin1");
    const pin2 = document.getElementById("pin2");

    const slide1 = document.querySelector(".bundle-hover-item.pin1");
    const slide2 = document.querySelector(".bundle-hover-item.pin2");

    // Hover pin1
    pin1.addEventListener("mouseenter", () => {
        slide2.classList.add("dimmed");
    });
    pin1.addEventListener("mouseleave", () => {
        slide2.classList.remove("dimmed");
    });

    // Hover pin2
    pin2.addEventListener("mouseenter", () => {
        slide1.classList.add("dimmed");
    });
    pin2.addEventListener("mouseleave", () => {
        slide1.classList.remove("dimmed");
    });
});









// wishlist


document.addEventListener("DOMContentLoaded", function () {
    const wishlistBtns = document.querySelectorAll(".wishlist");

    // Function to update tooltip based on wishlist
    function updateTooltips() {
        const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

        wishlistBtns.forEach(btn => {
            const card = btn.closest(".card-product");
            if (!card) return;

            const link = card.querySelector(".product-img").href;
            const tooltip = btn.querySelector(".tooltip");

            if (wishlist.some(item => item.link === link)) {
                tooltip.innerText = "Already Wishlished";
            } else {
                tooltip.innerText = "Wishlist";
            }
        });
    }

    // Initialize tooltip states
    updateTooltips();

    // Click event to toggle wishlist
    wishlistBtns.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            const card = this.closest(".card-product");
            if (!card) return;

            const title = card.querySelector(".card-product-info .title").innerText;
            const price = card.querySelector(".card-product-info .price").innerText;
            const img = card.querySelector(".img-product").src;
            const link = card.querySelector(".product-img").href;

            const product = { title, price, img, link };
            let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

            // Check if product exists
            const index = wishlist.findIndex(item => item.link === link);
            if (index > -1) {
                // Remove from wishlist
                wishlist.splice(index, 1);
            } else {
                // Add to wishlist
                wishlist.push(product);
            }

            localStorage.setItem("wishlist", JSON.stringify(wishlist));
            updateTooltips(); // Update tooltips after change
        });
    });
});





// display wishlist

document.addEventListener("DOMContentLoaded", function () {
    const wishlistContainer = document.getElementById("wishlistContainer");
    const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    wishlist.forEach(product => {
        const div = document.createElement("div");
        div.className = "wishlist-item";
        div.innerHTML = `
            <a href="${product.link}">
                <img src="${product.img}" alt="${product.title}" width="100">
                <h4>${product.title}</h4>
                <p>${product.price}</p>
            </a>
        `;
        wishlistContainer.appendChild(div);
    });
});






// About us page tabs

document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".widget-menu-tab .item-title");
    const tabContents = document.querySelectorAll(".widget-content-tab .widget-content-inner");

    tabButtons.forEach((tab, index) => {
        tab.addEventListener("click", function () {
            // Remove active class from all tabs
            tabButtons.forEach(t => t.classList.remove("active"));
            // Add active class to clicked tab
            this.classList.add("active");

            // Hide all tab contents
            tabContents.forEach(c => c.classList.remove("active"));
            // Show corresponding content
            tabContents[index].classList.add("active");
        });
    });
});


// my team

document.addEventListener("DOMContentLoaded", function () {
    const teamSwiper = new Swiper(".team-slider", {
        slidesPerView: 4,        // Number of slides visible on desktop
        spaceBetween: 30,        // Space between slides
        loop: true,              // Infinite loop
        pagination: {
            el: ".sw-pagination-latest",
            clickable: true,     // Allows clicking pagination bullets
        },
        breakpoints: {           // Responsive settings
            0: {                 // Mobile
                slidesPerView: 1,
                spaceBetween: 10,
            },
            576: {               // Small tablets
                slidesPerView: 2,
                spaceBetween: 15,
            },
            768: {               // Tablets
                slidesPerView: 3,
                spaceBetween: 20,
            },
            992: {               // Desktop
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });
});


// About-us Page slider

document.addEventListener("DOMContentLoaded", function () {
    const partnerSwiper = new Swiper(".tf-sw-partner", {
        slidesPerView: 6,          // Number of logos visible on desktop
        spaceBetween: 30,          // Space between logos
        loop: true,                // Infinite loop
        autoplay: {
            delay: 2500,           // Time between slides (2.5s)
            disableOnInteraction: false, // Keep autoplay after user interaction
        },
        breakpoints: {             // Responsive settings
            0: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            576: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
            992: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
            1199: {
                slidesPerView: 6,
                spaceBetween: 30,
            },
            1399: {
                slidesPerView: 7,
                spaceBetween: 30,
            },
        },
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const testimonialSwiper = new Swiper(".tf-sw-testimonial", {
        slidesPerView: 1,              // Show 1 testimonial at a time
        spaceBetween: 30,
        loop: true,                    // Infinite loop
        autoplay: {
            delay: 4000,               // Auto change every 4s
            disableOnInteraction: false, // Keep autoplay after interaction
        },
        pagination: {
            el: ".sw-pagination-testimonial",
            clickable: true,           // Pagination dots are clickable
        },
        breakpoints: {
            768: {                     // Tablet
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1200: {                    // Desktop
                slidesPerView: 3,
                spaceBetween: 30,
            }
        }
    });
});


// tabs shops grid


// $(document).ready(function () {
//     $(".tf-view-layout-switch").on("click", function () {
//         // Active state
//         $(".tf-view-layout-switch").removeClass("active");
//         $(this).addClass("active");

//         // Target wrapper
//         let layoutClass = $(this).data("value-layout");
//         let $wrapper = $(".wrapper-shop");

//         // Remove old tf-col-* classes
//         $wrapper.removeClass(function (i, c) {
//             return (c.match(/(^|\s)tf-col-\S+/g) || []).join(" ");
//         });

//         // Add selected layout class
//         $wrapper.addClass(layoutClass);
//     });
// });


$(document).ready(function () {
    let $wrapper = $(".wrapper-shop");
    let userSelected = false; // track if user clicked manually

    // Function to set layout automatically
    function setAutoLayout() {
        if (userSelected) return; // don't override user choice

        let width = $(window).width();
        let layoutClass = "tf-col-4"; // default

        if (width < 768) {
            layoutClass = "tf-col-2";
        } else if (width >= 768 && width < 1199) {
            layoutClass = "tf-col-3";
        } else {
            layoutClass = "tf-col-4";
        }

        // Remove old tf-col-* classes
        $wrapper.removeClass(function (i, c) {
            return (c.match(/(^|\s)tf-col-\S+/g) || []).join(" ");
        });

        $wrapper.addClass(layoutClass);

        // Update active button
        $(".tf-view-layout-switch").removeClass("active");
        $(`.tf-view-layout-switch[data-value-layout="${layoutClass}"]`).addClass("active");
    }

    // Handle click (manual override)
    $(".tf-view-layout-switch").on("click", function () {
        userSelected = true; // stop auto adjustment

        $(".tf-view-layout-switch").removeClass("active");
        $(this).addClass("active");

        let layoutClass = $(this).data("value-layout");

        $wrapper.removeClass(function (i, c) {
            return (c.match(/(^|\s)tf-col-\S+/g) || []).join(" ");
        });

        $wrapper.addClass(layoutClass);
    });

    // Run on load
    setAutoLayout();

    // Run on resize
    $(window).on("resize", function () {
        setAutoLayout();
    });
});



// filters


$(document).ready(function () {
    // --- Size: only 1 active
    $(".facet-size .size-item").on("click", function () {
        $(this).addClass("active").siblings().removeClass("active");
    });

    // --- Color: only 1 active
    $(".facet-color .color-item").on("click", function () {
        $(this).addClass("active").siblings().removeClass("active");
    });

    // --- Availability (radio)
    $(".facet-fieldset").first().find("input[type=radio]").on("change", function () {
        // remove active from all, add only on checked
        let $fieldset = $(this).closest(".facet-fieldset");
        $fieldset.find(".fieldset-item").removeClass("active");
        $(this).closest(".fieldset-item").addClass("active");
    });

    // --- Brands (checkboxes → multiple allowed)
    $(".facet-fieldset").last().find("input[type=checkbox]").on("change", function () {
        $(this).closest(".fieldset-item").toggleClass("active", this.checked);
    });

    // --- Reset Filters
    $("#reset-filter").on("click", function () {
        // size + color
        $(".facet-size .size-item, .facet-color .color-item").removeClass("active");

        // radios + checkboxes
        $(".facet-fieldset input").prop("checked", false);
        $(".facet-fieldset .fieldset-item").removeClass("active");
    });
});



// range slider


(function () {
    function initTFRange(wrapper) {
        if (!wrapper) return;

        const rangeEl = wrapper.querySelector('.tf-range');
        const thumbL = wrapper.querySelector('.tf-thumb-left');
        const thumbR = wrapper.querySelector('.tf-thumb-right');
        const fill = wrapper.querySelector('.tf-range-fill');
        const outputMin = wrapper.querySelector('#price-min-value');
        const outputMax = wrapper.querySelector('#price-max-value');
        const hiddenMin = wrapper.querySelector('.tf-hidden-min');
        const hiddenMax = wrapper.querySelector('.tf-hidden-max');

        const minAttr = Number(rangeEl.dataset.min) || 0;
        const maxAttr = Number(rangeEl.dataset.max) || 100;
        const step = Number(rangeEl.dataset.step) || 1;
        const minGap = Number(rangeEl.dataset.minGap) || 0;

        // initial values
        let currentMin = Number(hiddenMin.value) || Number(outputMin.textContent) || minAttr;
        let currentMax = Number(hiddenMax.value) || Number(outputMax.textContent) || maxAttr;

        currentMin = Math.max(minAttr, Math.min(currentMin, maxAttr));
        currentMax = Math.max(minAttr, Math.min(currentMax, maxAttr));
        if (currentMin > currentMax) [currentMin, currentMax] = [currentMax, currentMin];

        function valueToPct(v) {
            return ((v - minAttr) / (maxAttr - minAttr)) * 100;
        }
        function pctToValue(p) {
            const raw = minAttr + (p / 100) * (maxAttr - minAttr);
            return Math.min(maxAttr, Math.max(minAttr, Math.round((raw - minAttr) / step) * step + minAttr));
        }

        function render() {
            const pL = valueToPct(currentMin);
            const pR = valueToPct(currentMax);
            thumbL.style.left = pL + '%';
            thumbR.style.left = pR + '%';
            fill.style.left = pL + '%';
            fill.style.width = (pR - pL) + '%';
            outputMin.textContent = currentMin;
            outputMax.textContent = currentMax;
            hiddenMin.value = currentMin;
            hiddenMax.value = currentMax;
            thumbL.setAttribute('aria-valuenow', currentMin);
            thumbR.setAttribute('aria-valuenow', currentMax);
        }

        render();

        let dragging = null;

        function setFromClientX(which, clientX) {
            const rect = rangeEl.getBoundingClientRect();
            const pct = Math.min(100, Math.max(0, ((clientX - rect.left) / rect.width) * 100));
            const val = pctToValue(pct);
            if (which === 'min') {
                currentMin = Math.min(val, currentMax - minGap);
                currentMin = Math.max(minAttr, currentMin);
            } else {
                currentMax = Math.max(val, currentMin + minGap);
                currentMax = Math.min(maxAttr, currentMax);
            }
            render();
            dispatchChange();
        }

        function onPointerDownThumb(e) {
            e.preventDefault();
            dragging = this.classList.contains('tf-thumb-left') ? 'min' : 'max';
            if (e.pointerId && this.setPointerCapture) {
                try { this.setPointerCapture(e.pointerId); } catch (err) { }
            }
        }
        function onPointerMove(e) {
            if (!dragging) return;
            setFromClientX(dragging, e.clientX || (e.touches && e.touches[0].clientX));
        }
        function onPointerUp(e) {
            if (!dragging) return;
            dragging = null;
        }

        function onTrackPointerDown(e) {
            if (e.target.closest('.tf-thumb')) return;
            const rect = rangeEl.getBoundingClientRect();
            const pct = Math.min(100, Math.max(0, ((e.clientX - rect.left) / rect.width) * 100));
            const val = pctToValue(pct);
            const distL = Math.abs(valueToPct(currentMin) - pct);
            const distR = Math.abs(valueToPct(currentMax) - pct);
            const which = distL <= distR ? 'min' : 'max';
            setFromClientX(which, e.clientX);
            dragging = which;
        }

        function onThumbKeyDown(e) {
            const which = this.classList.contains('tf-thumb-left') ? 'min' : 'max';
            if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') {
                e.preventDefault();
                if (which === 'min') currentMin = Math.max(minAttr, Math.min(currentMin - step, currentMax - minGap));
                else currentMax = Math.max(currentMin + minGap, currentMax - step);
                render(); dispatchChange();
            } else if (e.key === 'ArrowRight' || e.key === 'ArrowUp') {
                e.preventDefault();
                if (which === 'min') currentMin = Math.min(currentMin + step, currentMax - minGap);
                else currentMax = Math.min(maxAttr, currentMax + step);
                render(); dispatchChange();
            }
        }

        function dispatchChange() {
            const event = new CustomEvent('tfRangeChange', {
                detail: { min: currentMin, max: currentMax, element: wrapper }
            });
            wrapper.dispatchEvent(event); // 🔑 dispatch on wrapper instead of document
        }

        // Attach events
        thumbL.addEventListener('pointerdown', onPointerDownThumb);
        thumbR.addEventListener('pointerdown', onPointerDownThumb);
        rangeEl.addEventListener('pointerdown', onTrackPointerDown);
        document.addEventListener('pointermove', onPointerMove);
        document.addEventListener('pointerup', onPointerUp);
        thumbL.addEventListener('keydown', onThumbKeyDown);
        thumbR.addEventListener('keydown', onThumbKeyDown);

        // Touch support
        rangeEl.addEventListener('touchstart', e => onTrackPointerDown(e.touches[0]), { passive: false });
        document.addEventListener('touchmove', e => onPointerMove(e.touches[0]), { passive: false });
        document.addEventListener('touchend', onPointerUp);

        // API
        rangeEl.tfRangeGet = () => ({ min: currentMin, max: currentMax });
        rangeEl.tfRangeSet = (minVal, maxVal) => {
            currentMin = Math.max(minAttr, Math.min(minVal, maxAttr));
            currentMax = Math.max(minAttr, Math.min(maxVal, maxAttr));
            render(); dispatchChange();
        };

        dispatchChange();
    }

    // Init all sliders
    function initAllRanges() {
        document.querySelectorAll('.widget-facet.facet-price .tf-range-wrapper')
            .forEach(wrapper => initTFRange(wrapper));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllRanges);
    } else {
        initAllRanges();
    }

})();


// Sort by filters

document.querySelectorAll('.select-item').forEach(item => {
    item.addEventListener('click', function () {
        let value = this.querySelector('.text-value-item').textContent;
        document.querySelector('.text-sort-value').textContent = value;

        // remove 'active' from all
        document.querySelectorAll('.select-item').forEach(i => i.classList.remove('active'));
        // add 'active' to current
        this.classList.add('active');
    });
});

// Sort by filters data show and remove


// ✅ For checkboxes & radios (brand, availability, categories…)
document.querySelectorAll(".tf-check").forEach(input => {
    input.addEventListener("change", function () {
        const label = this.nextElementSibling.textContent.trim();
        const group = this.getAttribute("name") || "filter";
        const value = label;

        if (this.checked) {
            addFilter(label, group, value, this);
        } else {
            let tag = document.querySelector(`[data-group="${group}"][data-value="${value}"]`);
            if (tag) tag.remove();
            updateClearAll();
        }
    });
});

// ✅ For size filter
document.querySelectorAll(".size-item").forEach(item => {
    item.addEventListener("click", function () {
        this.classList.toggle("active");
        const label = this.textContent.trim();
        const group = "size";
        const value = label;

        if (this.classList.contains("active")) {
            addFilter(label, group, value, this);
        } else {
            let tag = document.querySelector(`[data-group="${group}"][data-value="${value}"]`);
            if (tag) tag.remove();
            updateClearAll();
        }
    });
});

// ✅ For color filter
document.querySelectorAll(".color-item").forEach(item => {
    item.addEventListener("click", function () {
        this.classList.toggle("active");
        const label = this.textContent.trim();
        const group = "color";
        const value = label;
        // pick color from CSS background instead of transparent default
        const color = window.getComputedStyle(this.querySelector(".color")).backgroundColor;

        if (this.classList.contains("active")) {
            addFilter(label, group, value, this, color);
        } else {
            let tag = document.querySelector(`[data-group="${group}"][data-value="${value}"]`);
            if (tag) tag.remove();
            updateClearAll();
        }
    });
});

// ✅ Reset Filters button (outside filter tags)
// ✅ Reset Filters button (sidebar bottom)
const resetBtn = document.getElementById("reset-filter");
if (resetBtn) {
    resetBtn.addEventListener("click", () => {
        // Remove all applied tags
        appliedFiltersDiv.querySelectorAll(".filter-tag").forEach(tag => tag.remove());

        // Uncheck checkboxes & radios
        document.querySelectorAll(".tf-check").forEach(i => (i.checked = false));

        // Remove active classes (size & color)
        document.querySelectorAll(".size-item.active, .color-item.active").forEach(i =>
            i.classList.remove("active")
        );

        // ✅ Reset price range if you want
        const minInput = document.querySelector(".tf-hidden-min");
        const maxInput = document.querySelector(".tf-hidden-max");
        if (minInput && maxInput) {
            minInput.value = minInput.getAttribute("value"); // reset to default
            maxInput.value = maxInput.getAttribute("value");
            // also reset UI text if you display min/max
            document.getElementById("price-min-value").textContent = minInput.value;
            document.getElementById("price-max-value").textContent = maxInput.value;
        }

        updateClearAll();
    });
}




// pagination slider



$(document).ready(function () {
    function updatePagination(newPage) {
        let pages = $(".wg-pagination li");
        let totalPages = pages.length - 2; // exclude prev/next
        if (newPage < 1 || newPage > totalPages) return;

        // Remove active
        $(".wg-pagination li").removeClass("active");

        // Add active to correct page
        $(".wg-pagination li").eq(newPage).addClass("active");

        // Enable/Disable prev/next
        $(".wg-pagination .prev").toggleClass("disabled", newPage === 1);
        $(".wg-pagination .next").toggleClass("disabled", newPage === totalPages);
    }

    // Click on page number
    $(document).on("click", ".wg-pagination li .pagination-item.text-button", function () {
        let page = parseInt($(this).text());
        if (!isNaN(page)) updatePagination(page);
    });

    // Prev button
    $(document).on("click", ".wg-pagination .prev:not(.disabled)", function () {
        let current = $(".wg-pagination li.active .pagination-item").text();
        updatePagination(parseInt(current) - 1);
    });

    // Next button
    $(document).on("click", ".wg-pagination .next:not(.disabled)", function () {
        let current = $(".wg-pagination li.active .pagination-item").text();
        updatePagination(parseInt(current) + 1);
    });
});



// shop categories top


document.addEventListener("DOMContentLoaded", function () {
    var collectionSwiper = new Swiper(".swiper.cat-top", {
        slidesPerView: 5,         // Show 5 items on desktop
        spaceBetween: 20,         // Gap between slides
        loop: true,               // Infinite loop
        autoplay: {
            delay: 3000,          // Auto slide every 3s
            disableOnInteraction: false
        },
        pagination: {
            el: ".sw-pagination-collection", // Dots container
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            320: { slidesPerView: 2, spaceBetween: 10 },  // Mobile
            768: { slidesPerView: 3, spaceBetween: 15 },  // Tablet
            1024: { slidesPerView: 4, spaceBetween: 20 }, // Laptop
            1200: { slidesPerView: 5, spaceBetween: 20 }, // Laptop
            1400: { slidesPerView: 5, spaceBetween: 20 }  // Desktop
        }
    });
});




// search page slider 


document.addEventListener("DOMContentLoaded", function () {
    var latestSwiper = new Swiper(".tf-sw-latest", {
        slidesPerView: 4,         // Show 4 products on desktop
        spaceBetween: 24,         // Gap between slides
        loop: true,               // Infinite loop
        autoplay: {
            delay: 4000,
            disableOnInteraction: false
        },
        pagination: {
            el: ".sw-pagination-latest",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            320: { slidesPerView: 1.2, spaceBetween: 12 },   // Mobile
            576: { slidesPerView: 2, spaceBetween: 16 },     // Small tablets
            768: { slidesPerView: 2.5, spaceBetween: 20 },   // Tablets
            1024: { slidesPerView: 3, spaceBetween: 20 },    // Small desktops
            1400: { slidesPerView: 4, spaceBetween: 24 }     // Large screens
        }
    });
});



// Product detail Page slider


document.addEventListener("DOMContentLoaded", function () {
    // Thumbnail Swiper
    var thumbsSwiper = new Swiper(".tf-product-media-thumbs", {
        spaceBetween: 10,
        slidesPerView: 6,
        // autoHeight: true,
        watchSlidesProgress: true,

        // responsive
        breakpoints: {
            1200: {
                direction: "vertical",   // desktop
                autoHeight: false,
            },
            0: {
                direction: "horizontal", // mobile/tablet
                autoHeight: true,
            }
        }
    });

    // Main Swiper
    var mainSwiper = new Swiper(".tf-product-media-main", {
        spaceBetween: 10,
        loop: false,
        thumbs: {
            swiper: thumbsSwiper,
        },
        breakpoints: {
            0: {
                autoHeight: true,  // 👈 Enabled for small screens
            },
            1200: {
                autoHeight: false, // 👈 Disabled for large screens
            },
        },
    });

});


document.querySelectorAll(".tf-product-media-main .swiper-slide img").forEach(img => {
    img.style.transition = "transform 0.2s ease";
    img.addEventListener("mousemove", function (e) {
        const rect = img.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;
        img.style.transformOrigin = `${x}% ${y}%`;
        img.style.transform = "scale(2)"; // zoom level
    });
    img.addEventListener("mouseleave", function () {
        img.style.transformOrigin = "center center";
        img.style.transform = "scale(1)";
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".tf-product-media-main .swiper-slide img");
    if (!slides.length) return;

    const gallery = [];

    slides.forEach((img, i) => {
        const src = img.dataset.zoom || img.dataset.src || img.src;
        if (!src) return;

        gallery.push({ src, type: "image" });

        img.style.cursor = "zoom-in";
        img.addEventListener("click", function (e) {
            e.preventDefault(); // 🚀 stop <a> from opening in new tab
            e.stopPropagation(); // 🚀 stop swiper from reacting
            Fancybox.show(gallery, { startIndex: i });
        });
    });
});


// document.addEventListener("DOMContentLoaded", function () {
//   // create zoom box
//   const zoomBox = document.createElement("div");
//   zoomBox.id = "zoomBox";
//   document.querySelector(".tf-product-media-wrap").appendChild(zoomBox);

//   document.querySelectorAll(".tf-product-media-main .swiper-slide img").forEach(img => {
//     img.addEventListener("mouseenter", function () {
//       zoomBox.style.display = "block";
//       zoomBox.style.backgroundImage = `url(${img.src})`;
//     });

//     img.addEventListener("mousemove", function (e) {
//       const rect = img.getBoundingClientRect();
//       const x = ((e.clientX - rect.left) / rect.width) * 100;
//       const y = ((e.clientY - rect.top) / rect.height) * 100;
//       zoomBox.style.backgroundPosition = `${x}% ${y}%`;
//     });

//     img.addEventListener("mouseleave", function () {
//       zoomBox.style.display = "none";
//     });
//   });
// });





// Product detail Page color selection

document.addEventListener("DOMContentLoaded", () => {
    // Loop through each variant section separately
    document.querySelectorAll(".variant-picker-item").forEach(picker => {
        const colorLabels = picker.querySelectorAll(".color-btn");
        const colorText = picker.querySelector(".value-currentColor");

        colorLabels.forEach(label => {
            label.addEventListener("click", e => {
                e.preventDefault();

                // Remove active from only this section
                colorLabels.forEach(l => l.classList.remove("active"));
                label.classList.add("active");

                // Update color text for this section
                const selectedColor = label.querySelector(".tooltip").textContent;
                if (colorText) {
                    colorText.textContent = selectedColor.toLowerCase();
                }

                // ✅ Only update slider if this section is in the main product area
                if (picker.closest(".tf-product-media-main")) {
                    const slides = document.querySelectorAll(".tf-product-media-main .swiper-slide");

                    slides.forEach(slide => {
                        const img = slide.querySelector("img");
                        if (!img) return;

                        const src = img.getAttribute("data-src") || img.getAttribute("src");
                        const newSrc = src.replace(/-(gray|beige|grey)/, `-${selectedColor.toLowerCase()}`);

                        img.setAttribute("src", newSrc);
                        img.setAttribute("data-zoom", newSrc);
                    });

                    if (typeof mainSwiper !== "undefined") {
                        mainSwiper.update();
                        mainSwiper.slideTo(0);
                        if (mainSwiper.thumbs && mainSwiper.thumbs.swiper) {
                            mainSwiper.thumbs.swiper.update();
                        }
                    }
                }
            });
        });
    });
});


// ✅ Size selection script (scoped properly)
// $(document).ready(function() {
//     $(".size-btn").click(function() {
//         let selectedSize = $(this).data("value");

//         // Only update the size section's label (not color!)
//         $(this)
//           .closest(".variant-picker-item")
//           .find(".variant-picker-label-value")
//           .text(selectedSize);
//     });
// });



$(document).ready(function () {
    // 1) Initialize default active state
    $(".variant-picker-item").each(function () {
        let $checkedInput = $(this).find("input[type=radio][name=size]:checked");
        if ($checkedInput.length) {
            let $label = $(this).find("label[for='" + $checkedInput.attr("id") + "']");
            $label.addClass("active");
            $(this).find(".variant-picker-label-value").text($label.data("value"));
        }
    });

    // 2) Handle click change
    $(".size-btn").click(function () {
        let selectedSize = $(this).data("value");

        // Update only the current section label
        $(this)
            .closest(".variant-picker-item")
            .find(".variant-picker-label-value")
            .text(selectedSize);

        // Remove active class from all size buttons in this section
        $(this)
            .closest(".variant-picker-values")
            .find(".size-btn")
            .removeClass("active");

        // Add active class to the clicked one
        $(this).addClass("active");
    });
});



// Add to cart counter







// color switch home page hover

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".list-color-product").forEach(list => {
        list.querySelectorAll(".list-color-item").forEach(item => {
            // Function to activate a swatch
            const activateSwatch = () => {
                // remove 'active' from all siblings
                list.querySelectorAll(".list-color-item").forEach(i => i.classList.remove("active"));
                // add 'active' to hovered/clicked one
                item.classList.add("active");

                // OPTIONAL: update main product image
                const newImage = item.querySelector("img")?.src;
                const mainImage = list.closest(".card-product, .tf-main-product")?.querySelector(".product-img img, .tf-product-media-main img");
                if (newImage && mainImage) {
                    mainImage.src = newImage;
                }
            };

            // Click event
            item.addEventListener("click", activateSwatch);

            // Hover event
            item.addEventListener("mouseenter", activateSwatch);
        });
    });
});




// Shopping Cart Js Script and wishlist script MODAl

document.addEventListener("click", function (e) {
    // Works even if you click on a child element inside the remove button
    const removeBtn = e.target.closest(".tf-btn-remove");
    if (!removeBtn) return;

    // Prevent page jump if the remove is an <a>
    if (removeBtn.tagName === "A") e.preventDefault();

    // Scope to the SAME list the button belongs to
    const listContainer =
        removeBtn.closest(".tf-mini-cart-sroll") ||
        removeBtn.closest(".tf-mini-cart-main");

    if (!listContainer) return;

    // Remove the item
    const item = removeBtn.closest(".tf-mini-cart-item");
    if (item) item.remove();

    // Count remaining items only inside this list
    const remaining = listContainer.querySelectorAll(".tf-mini-cart-item").length;

    // Toggle the empty message in this list only
    const emptyMessage = listContainer.querySelector(".empty-message");
    if (emptyMessage) {
        if (remaining === 0) {
            emptyMessage.classList.remove("d-none");
        } else {
            emptyMessage.classList.add("d-none");
        }
    }
});


document.addEventListener('DOMContentLoaded', function () {
    // Click on tool buttons
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.tf-mini-cart-tool-btn');
        if (!btn) return;

        // Map button class -> panel modifier
        const map = [
            ['btn-add-note', 'add-note'],
            ['btn-estimate-shipping', 'estimate-shipping'],
            ['btn-add-coupon', 'add-coupon']
        ];

        let type = null;
        for (const [btnClass, panelType] of map) {
            if (btn.classList.contains(btnClass)) { type = panelType; break; }
        }
        if (!type) return;

        // Find target panel (first try by modifier class; fallback by form inside)
        let target = document.querySelector(`.tf-mini-cart-tool-openable.${type}`);
        if (!target) {
            const formClass = type === 'add-note' ? '.form-add-note'
                : type === 'estimate-shipping' ? '.form-estimate-shipping'
                    : '.form-add-coupon';
            const inner = document.querySelector(`.tf-mini-cart-tool-openable ${formClass}`);
            target = inner ? inner.closest('.tf-mini-cart-tool-openable') : null;
        }
        if (!target) { console.warn('Panel not found for:', type); return; }

        // Close other open panels
        document.querySelectorAll('.tf-mini-cart-tool-openable.open').forEach(p => {
            if (p !== target) p.classList.remove('open');
        });

        // Toggle this one
        target.classList.toggle('open');
    });

    // Click on "Cancel" inside any panel
    document.addEventListener('click', function (e) {
        const closer = e.target.closest('.tf-mini-cart-tool-close');
        if (!closer) return;
        const panel = closer.closest('.tf-mini-cart-tool-openable');
        if (panel) panel.classList.remove('open');
    });
});



// Add to cart to already added

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (e) {
        // Check for any of the 3 buttons
        const btn = e.target.closest(".btn-main-product, .btn-add-to-cart, .cart-item-bot .link.text-button");
        if (!btn) return;

        e.preventDefault(); // stop <a> from navigating

        if (!btn.classList.contains("added")) {
            // Case 1 & 3: Text directly inside <a>
            if (btn.tagName === "A" && btn.querySelector("span") === null) {
                btn.textContent = "ALREADY ADDED";
            }
            // Case 2: <a> has <span> inside
            else if (btn.querySelector("span")) {
                btn.querySelector("span").textContent = "ALREADY ADDED";
            }

            btn.classList.add("added");
        }
    });
});





// Auto PopUp





// size guide

$(document).ready(function () {
    // Tab selection for Thin / Normal / Plump
    $(".size-button-wrap .size-button-item").click(function () {
        $(this)
            .addClass("select-option")           // add active class
            .siblings()
            .removeClass("select-option");       // remove from others
    });

    // Range slider update (Height & Weight)
    $(".modal-size-guide .range-max").on("input", function () {
        let value = $(this).val();
        let max = $(this).attr("max");

        // Update progress bar width
        let percent = (value / max) * 100;
        $(this)
            .siblings(".tow-bar-block")
            .find(".progress-size")
            .css("width", percent + "%");

        // Update number text (span.max-size)
        $(this)
            .closest(".widget-size")
            .find(".number-size .max-size")
            .text(value);
    });
});




// Check Out Page


document.addEventListener("DOMContentLoaded", function () {
    const cartBody = document.getElementById("cartBody");
    const emptyCartMsg = document.getElementById("emptyCartMessage");
    const subtotalEl = document.getElementById("subtotal");
    const grandTotalEl = document.getElementById("grandTotal");
    const cartForm = document.getElementById("cartForm");

    const CURRENCY = "₹";

    // Parse "₹ 1,699.50" -> 1699.50
    function parseMoney(str) {
        if (!str) return 0;
        return parseFloat(String(str).replace(/[^0-9.-]/g, "")) || 0;
    }

    // Format 1699.5 -> "₹1699.50"
    function formatMoney(num) {
        return CURRENCY + num.toFixed(2);
    }

    function updateTotals() {
        let subtotal = 0;

        cartBody.querySelectorAll(".tf-cart-item").forEach(row => {
            const priceText = row.querySelector(".price")?.textContent || "0";
            const price = parseMoney(priceText);
            const qty = parseInt(row.querySelector(".quantity-product")?.value || "0", 10) || 0;

            const itemTotal = price * qty;
            const itemTotalEl = row.querySelector(".item-total");
            if (itemTotalEl) itemTotalEl.textContent = formatMoney(itemTotal);

            subtotal += itemTotal;
        });

        // Shipping (from selected radio)
        let shipping = 0;
        const checkedShip = document.querySelector(".ship input[type='radio']:checked");
        if (checkedShip) {
            const priceSpan = checkedShip.closest("fieldset")?.querySelector(".price");
            if (priceSpan) shipping = parseMoney(priceSpan.textContent);
        }

        // Update totals
        subtotalEl.textContent = formatMoney(subtotal);
        grandTotalEl.textContent = formatMoney(subtotal + shipping);
    }

    function checkEmptyCart() {
        const hasItems = cartBody.querySelectorAll(".tf-cart-item").length > 0;
        cartForm.style.display = hasItems ? "block" : "none";
        emptyCartMsg.style.display = hasItems ? "none" : "block";
        if (!hasItems) {
            subtotalEl.textContent = formatMoney(0);
            grandTotalEl.textContent = formatMoney(0);
        }
    }

    // Remove item
    cartBody.addEventListener("click", function (e) {
        if (e.target.closest(".remove-cart")) {
            const row = e.target.closest(".tf-cart-item");
            if (row) row.remove();
            updateTotals();
            checkEmptyCart();
        }
    });

    // Quantity +/-
    // cartBody.addEventListener("click", function (e) {
    //     const btn = e.target;
    //     const row = btn.closest(".tf-cart-item");
    //     if (!row) return;

    //     const input = row.querySelector(".quantity-product");
    //     if (!input) return;

    //     let qty = parseInt(input.value || "1", 10) || 1;

    //     if (btn.classList.contains("btn-increase")) qty++;
    //     if (btn.classList.contains("btn-decrease")) qty = Math.max(1, qty - 1);

    //     input.value = qty;
    //     updateTotals();
    // });

    // Change shipping
    document.querySelectorAll(".ship input[type='radio']").forEach(r => {
        r.addEventListener("change", updateTotals);
    });

    // Initial paint
    updateTotals();
    checkEmptyCart();
});





// Register


$(document).ready(function () {
    $(".toggle-password").on("click", function () {
        let $input = $(this).siblings("input");
        let $icon = $(this).find("i");

        if ($input.attr("type") === "password") {
            $input.attr("type", "text");
            $(this).removeClass("unshow").addClass("show");
            $icon.removeClass("icon-eye-hide-line").addClass("icon-eye-line");
        } else {
            $input.attr("type", "password");
            $(this).removeClass("show").addClass("unshow");
            $icon.removeClass("icon-eye-line").addClass("icon-eye-hide-line");
        }
    });
});


// product dropdown detail


$(document).on("click", ".dropdown-close", function () {
    let $dropdown = $(this).closest(".dropdown-menu");
    $dropdown.removeClass("show");
    $dropdown.parent(".dropdown").removeClass("show");
});


// address

$(document).ready(function () {
    $(".show-form-address").hide(); // hide form initially

    // Open on Add address
    $(".btn-address").on("click", function (e) {
        e.preventDefault();
        $(".show-form-address").slideDown(300);
    });

    // Close on Cancel
    $(".btn-hide-address").on("click", function (e) {
        e.preventDefault();
        $(".show-form-address").slideUp(300);
    });
});


// edit address


$(function () {
    // EDIT / CLOSE toggle
    $(document).on("click", ".btn-edit-address", function (e) {
        e.preventDefault();

        const $btn = $(this);
        const $item = $btn.closest(".account-address-item");

        // If this item is already open -> close it
        if ($btn.hasClass("is-open")) {
            $item.find(".edit-form-address").slideUp(200, function () { $(this).remove(); });
            $btn.removeClass("is-open").find(".text").text("Edit");
            return;
        }

        // Close any other open forms + reset other buttons
        $(".account-address-item .edit-form-address").remove();
        $(".btn-edit-address.is-open").removeClass("is-open").find(".text").text("Edit");

        // Clone the hidden template (the one outside the list)
        const $template = $("form.edit-form-address.wd-form-address").first();
        const $form = $template.clone(true, true);

        // Make it visible and safe (avoid duplicate IDs)
        $form.removeClass("d-none").addClass("d-block");
        $form.find("#CartDrawer-Form_agree").removeAttr("id");

        // Append just under this address and show
        $item.append($form.hide());
        $form.slideDown(200);

        // Mark button as open
        $btn.addClass("is-open").find(".text").text("Close");
    });

    // CANCEL inside the form
    $(document).on("click", ".btn-hide-edit-address", function (e) {
        e.preventDefault();
        const $form = $(this).closest(".edit-form-address");
        const $item = $form.closest(".account-address-item");

        $form.slideUp(200, function () { $(this).remove(); });
        $item.find(".btn-edit-address").removeClass("is-open").find(".text").text("Edit");
    });

    // DELETE this address card
    $(document).on("click", ".btn-delete-address", function (e) {
        e.preventDefault();
        const $item = $(this).closest(".account-address-item");
        $item.slideUp(200, function () { $(this).remove(); });
    });
});





// wishlist page


document.addEventListener("DOMContentLoaded", function () {
    const wishlistContainer = document.querySelector(".tf-grid-layout");
    const pagination = document.querySelector(".wg-pagination");

    if (wishlistContainer) {
        function checkWishlistEmpty() {
            if (wishlistContainer.children.length === 0) {
                // Remove pagination if exists
                if (pagination) {
                    pagination.remove();
                }

                // Replace grid with empty message
                wishlistContainer.outerHTML = `
                    <div class="wishlist-empty-msg p-5 text-center w-100">
                        <p>Your wishlist is empty. Start adding your favorite products to save them for later!</p>
                        <a class="btn-line mt-3" href="${window.appUrl}">Explore Products</a>
                    </div>
                `;
            }
        }

        // Run on page load
        checkWishlistEmpty();

        // Watch for dynamic changes
        const observer = new MutationObserver(checkWishlistEmpty);
        observer.observe(wishlistContainer, { childList: true });
    }
});







// Home 2 Slider

// topbar

$(document).ready(function () {
    var topbarSwiper = new Swiper(".tf-sw-top_bar", {
        loop: true,
        speed: 600,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".snbp2", // right arrow
            prevEl: ".snbn2", // left arrow
        },
    });
});

// Banner

$(document).ready(function () {
    // Destroy any existing swiper (prevents double init)
    if ($('.slider-style2 .tf-sw-slideshow')[0].swiper) {
        $('.slider-style2 .tf-sw-slideshow')[0].swiper.destroy(true, true);
    }

    var swiper = new Swiper(".slider-style2 .tf-sw-slideshow", {
        loop: true,
        speed: 800,
        slidesPerView: 1,
        spaceBetween: 0,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".spd33",
            clickable: true,
        },
        simulateTouch: true,
        allowTouchMove: true,
        grabCursor: true,
        resistanceRatio: 0,
        watchSlidesProgress: true,
        observer: true,
        observeParents: true,
        autoHeight: true
    });

    // ✅ After all images load, update Swiper layout
    $(".slider-style2 .tf-sw-slideshow img").on("load", function () {
        swiper.update();
    });

    // ✅ Also run a delayed update to fix early misalignment
    setTimeout(() => swiper.update(), 1000);
});


// collection

$(document).ready(function () {
    var categoriesSwiper = new Swiper(".flat-collection-circle .swiper", {
        loop: true,
        speed: 800,
        autoplay: true,
        slidesPerView: 2,       // default on mobile
        spaceBetween: 20,       // gap between slides
        pagination: {
            el: ".spd54",
            clickable: true,
        },
        navigation: {
            nextEl: ".snbn12",
            prevEl: ".snbp12",
        },
        breakpoints: {
            576: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 24,
            },
            992: {
                slidesPerView: 5,
                spaceBetween: 24,
            },
            1200: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
        }
    });
});

// Capsule Collection

$(document).ready(function () {
    var collectionSwiper = new Swiper(".tf-sw-collection", {
        loop: true, // ✅ makes 2 slides loop infinitely
        speed: 800,
        slidesPerView: 2, // show one at a time
        spaceBetween: 20,
        pagination: {
            el: ".spd43",
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 2, // keep 1 even on tablet
            },
            1200: {
                slidesPerView: 2, // force single slide on large screens too
            }
        }
    });
});



// language in mobile

document.querySelectorAll('.tf-currencies .dropdown-item').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        let img = this.getAttribute('data-img');
        let value = this.getAttribute('data-value');
        document.querySelector('.currency-btn .filter-option-inner-inner').innerHTML =
            `<img src="${img}" alt="${value}" width="18" class="me-1" /> ${value}`;
    });
});

// Language dropdown update
document.querySelectorAll('.tf-languages .dropdown-item').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        let value = this.getAttribute('data-value');
        document.querySelector('.language-btn .filter-option-inner-inner').textContent = value;
    });
});


// Headers Desktop

document.addEventListener("DOMContentLoaded", function () {
    let currentPath = window.location.pathname.split("/").pop();
    if (currentPath === "") currentPath = "index.html";

    // Reset all active
    document.querySelectorAll(".box-navigation .menu-item, .box-navigation .menu-item-li")
        .forEach(el => el.classList.remove("active"));

    // Save clicked link (href + text) into localStorage
    document.querySelectorAll(".box-navigation a").forEach(function (link) {
        link.addEventListener("click", function () {
            localStorage.setItem("activeLink", link.getAttribute("href") + "|" + link.textContent.trim());
        });
    });

    let saved = localStorage.getItem("activeLink");
    let matched = false;

    if (saved) {
        // Restore exact submenu
        let [savedHref, savedText] = saved.split("|");
        document.querySelectorAll(".box-navigation a").forEach(function (link) {
            let linkPath = link.getAttribute("href");
            let linkText = link.textContent.trim();

            if (!matched && linkPath === currentPath && linkText === savedText) {
                let li = link.closest("li");
                if (li) li.classList.add("active");

                let parentMenu = link.closest(".menu-item.position-relative, .menu-item");
                if (parentMenu) parentMenu.classList.add("active");

                matched = true;
            }
        });
    }

    // If nothing restored → just activate the FIRST match only
    if (!matched) {
        let firstMatch = document.querySelector('.box-navigation a[href="' + currentPath + '"]');
        if (firstMatch) {
            let li = firstMatch.closest("li");
            if (li) li.classList.add("active");

            let parentMenu = firstMatch.closest(".menu-item.position-relative, .menu-item");
            if (parentMenu) parentMenu.classList.add("active");
        }
    }
});

// header mobile

document.addEventListener("DOMContentLoaded", function () {
    let currentPath = window.location.pathname.split("/").pop();
    if (currentPath === "") currentPath = "index.html";

    // Reset all active states
    document.querySelectorAll(".nav-ul-mb .nav-mb-item, .nav-ul-mb .sub-nav-menu li, .sub-nav-link, .mb-menu-link")
        .forEach(el => el.classList.remove("active"));

    // Save clicked link (href + text) in localStorage
    document.querySelectorAll(".nav-ul-mb a").forEach(function (link) {
        link.addEventListener("click", function () {
            localStorage.setItem("activeMbLink", link.getAttribute("href") + "|" + link.textContent.trim());
        });
    });

    let saved = localStorage.getItem("activeMbLink");
    let matched = false;

    if (saved) {
        let [savedHref, savedText] = saved.split("|");

        document.querySelectorAll(".nav-ul-mb a").forEach(function (link) {
            let linkPath = link.getAttribute("href");
            let linkText = link.textContent.trim();

            if (!matched && linkPath === currentPath && linkText === savedText) {
                let li = link.closest("li");
                if (li) li.classList.add("active");
                link.classList.add("active");

                // Expand parents (Shop, Products, etc.)
                let collapseParents = link.closest(".collapse");
                while (collapseParents) {
                    collapseParents.classList.add("show");
                    let trigger = document.querySelector('[href="#' + collapseParents.id + '"]');
                    if (trigger) {
                        trigger.classList.remove("collapsed");
                        trigger.classList.add("active"); // ✅ Make parent also active
                    }
                    collapseParents = collapseParents.parentElement.closest(".collapse");
                }

                matched = true;
            }
        });
    }

    // If nothing matched, highlight first match for this page
    if (!matched) {
        let firstMatch = document.querySelector('.nav-ul-mb a[href="' + currentPath + '"]');
        if (firstMatch) {
            let li = firstMatch.closest("li");
            if (li) li.classList.add("active");
            firstMatch.classList.add("active");

            // Expand its parents
            let collapseParents = firstMatch.closest(".collapse");
            while (collapseParents) {
                collapseParents.classList.add("show");
                let trigger = document.querySelector('[href="#' + collapseParents.id + '"]');
                if (trigger) {
                    trigger.classList.remove("collapsed");
                    trigger.classList.add("active"); // ✅ Make parent also active
                }
                collapseParents = collapseParents.parentElement.closest(".collapse");
            }
        }
    }
});


// compare products

document.addEventListener("DOMContentLoaded", function () {
    const compareWrap = document.querySelector(".tf-compare-wrap");
    const emptyMessage = document.querySelector(".tf-compare-list > div:not(.tf-compare-wrap):not(.tf-compare-head):not(.tf-compare-buttons)");
    const clearAllBtn = document.querySelector(".tf-compapre-button-clear-all");

    function updateCompareUI() {
        if (compareWrap && compareWrap.children.length > 0) {
            compareWrap.style.display = "flex";   // show product list
            emptyMessage.style.display = "none";   // hide empty message
        } else {
            compareWrap.style.display = "none";    // hide product list
            emptyMessage.style.display = "flex";  // show empty message
        }
    }

    // Remove single product
    compareWrap.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove")) {
            const item = e.target.closest(".tf-compare-item");
            if (item) {
                item.remove();
                updateCompareUI();
            }
        }
    });

    // Clear all products
    clearAllBtn.addEventListener("click", function () {
        compareWrap.innerHTML = "";
        updateCompareUI();
    });

    // Initial check
    updateCompareUI();
});


// sticky header

document.addEventListener("DOMContentLoaded", function () {
    const header = document.getElementById("header");
    const stickyOffset = 500; // px after which header becomes sticky

    window.addEventListener("scroll", function () {
        if (window.scrollY > stickyOffset) {
            if (!header.classList.contains("sticky")) {
                header.classList.add("sticky");
            }
        } else {
            header.classList.remove("sticky");
        }
    });
});


// otp

document.querySelectorAll(".otp .login-wrap .form-login .wrap input").forEach((input, index, arr) => {
    input.addEventListener("input", () => {
        if (input.value.length === 1 && index < arr.length - 1) {
            arr[index + 1].focus(); // jump to next
        }
    });

    input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !input.value && index > 0) {
            arr[index - 1].focus(); // go back on backspace
        }
    });
});

// footer toggle

$(function () {
    $(".footer-heading-mobile").on("click", function () {
        if ($(window).width() <= 767) {
            // close others if you want accordion effect
            // $(".footer-col-block .tf-collapse-content").not($(this).next()).slideUp();

            $(this).next(".tf-collapse-content").slideToggle(300);
        }
    });
});

// scroll top

document.addEventListener("DOMContentLoaded", function () {
    const scrollBtn = document.getElementById("scroll-top");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 200) {
            scrollBtn.classList.add("show");
        } else {
            scrollBtn.classList.remove("show");
        }
    });

    scrollBtn.addEventListener("click", (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});


// stickey footer

window.addEventListener("scroll", function () {
    const sticky = document.getElementById("stickyFooter");
    if (window.scrollY > 900) {
        sticky.classList.add("show");
    } else {
        sticky.classList.remove("show");
    }
});


// Pincode Script

document.getElementById("pincodeForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const input = this.querySelector("input[name='pincode']");
    const btn = document.getElementById("checkBtn");
    const msg = document.getElementById("deliveryMsg");

    if (input.value.trim() === "") {
        alert("Please enter a pincode");
        return;
    }

    // Change button → Checking...
    btn.textContent = "Checking...";
    btn.disabled = true;

    // Simulate API delay
    setTimeout(() => {
        btn.textContent = "Check";      // Reset button
        btn.disabled = false;
        msg.style.display = "block";    // Show message
    }, 1500);
});





// Paste any New Script Here Start
// document.querySelectorAll("button[type='submit']").forEach(function(button) {
//     button.addEventListener("click", function() {
//         this.classList.add("btn-loading");
//         this.innerHTML = "Processing...";
//     });
// });






// Paste any New Script Here END




// login to otp This Is the last script after this any script not apply

document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault(); // stop default submit for now

    if (this.checkValidity()) {
        // ✅ Form is valid → redirect
        window.location.href = "otp.html";
    } else {
        // ❌ Show validation errors
        this.reportValidity();
    }
});
