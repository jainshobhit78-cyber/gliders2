<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gliders India</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <link rel="preload" as="image" href="{{ url('frontend/images/avatar/user-account.jpg') }}" />
    <link rel="stylesheet" href="{{ url('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/fonts/font-icons.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/e2dd61510303e09c.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/fancybox.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/style.css') }}?v={{ file_exists(public_path('frontend/css/style.css')) ? filemtime(public_path('frontend/css/style.css')) : time() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <!-- <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    @yield('style')
</head>

<body class="{{ request()->routeIs('home') ? 'home-page' : '' }}">
    <div id="root">
        @include('frontend.layouts.header')

        <main id="mainContent">
            @yield('content')
        </main>

        @include('frontend.layouts.footer')
    </div>

    <div class="gi-chatbot bounce-animation" id="chatbotContainer">
        <!-- Bouncing Tooltip Bubble -->
        <div class="chatbot-bubble" id="chatbotBubble">How may I help you?</div>

        <button class="chat-toggle" id="chatToggle">
            <img src="{{ asset('frontend/images/logo/g.png') }}" alt="" style="border-radius: 50px">
        </button>

        <div class="chat-box" id="chatBox">
            <div class="chat-header">
                <h4>Gliders India Support</h4>
                <span id="closeChat">✖</span>
            </div>

            <div class="chat-body" id="chatBody">
                <div class="bot-message">
                    Hello 👋 Welcome to Gliders India.<br>
                    How can we help you today?

                    <div id="faqQuestions" class="faq-questions"></div>
                </div>
            </div>

            <div class="chat-footer">
                <input type="text" id="userInput" placeholder="Type your message...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ url('frontend/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="{{ url('frontend/js/wow.min.js') }}"></script>
    <!-- <script src="{{ url('frontend/js/bootstrap.min.js') }}"></script> -->
    <!-- <script src="{{ url('frontend/js/bootstrap.bundle.min.js') }}"></script> -->
    <script src="{{ url('frontend/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('frontend/js/addtocart.js') }}"></script>
    <script src="{{ url('frontend/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility@latest/dist/sienna-accessibility.umd.js"></script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    @yield('scripts')

    <script>
        let currentFontSize = 16;

        /* FONT SIZE */
        function changeFontSize(change) {
            currentFontSize += change;

            if (currentFontSize < 12) currentFontSize = 12;
            if (currentFontSize > 22) currentFontSize = 22;

            document.documentElement.style.fontSize = currentFontSize + "px";
        }

        function resetFontSize() {
            currentFontSize = 16;
            document.documentElement.style.fontSize = "16px";
        }

        /* DARK MODE */
        function toggleDarkMode() {
            document.body.classList.toggle("dark-mode");
        }

        /* SKIP TO CONTENT */
        const skipBtn = document.querySelector(".skip-btn");
        if (skipBtn) {
            skipBtn.addEventListener("click", function (e) {
                e.preventDefault();
                const target = document.querySelector("#mainContent");
                if (target) {
                    target.scrollIntoView({
                        behavior: "smooth"
                    });
                }
            });
        }

        /* SCREEN READER */
        document.getElementById("screenReaderBtn").addEventListener("click", function () {
            const text = document.body.innerText;
            const speech = new SpeechSynthesisUtterance(text);
            speech.lang = "en-IN";
            window.speechSynthesis.speak(speech);
        });

        /* SIENNA ACCESSIBILITY */
        document.addEventListener("DOMContentLoaded", function () {

            document.getElementById("accessibilityBtn").addEventListener("click", function () {

                if (window.SiennaAccessibility) {
                    new window.SiennaAccessibility({
                        target: document.body
                    });
                }

            });

        });
    </script>


    <script>
        document.querySelectorAll('.navbar .dropdown-toggle').forEach(function (el) {
            el.addEventListener('click', function (e) {

                if (window.innerWidth < 992) {
                    e.preventDefault();

                    let parent = this.parentElement;
                    let menu = parent.querySelector('.dropdown-menu');

                    // close others
                    document.querySelectorAll('.navbar .dropdown').forEach(function (item) {
                        if (item !== parent) {
                            item.classList.remove('open');
                        }
                    });

                    // toggle current
                    parent.classList.toggle('open');
                }
            });
        });
    </script>

    <button id="scrollTopBtn" class="scroll-top-btn" aria-label="Scroll to top">
        ↑
    </button>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const scrollBtn = document.getElementById("scrollTopBtn");

            window.addEventListener("scroll", function () {
                if (window.scrollY > 300) {
                    scrollBtn.classList.add("show");
                } else {
                    scrollBtn.classList.remove("show");
                }
            });

            scrollBtn.addEventListener("click", function () {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbar = document.querySelector(".main-navbar");

            const stickyPoint = navbar.offsetTop;

            window.addEventListener("scroll", function () {
                if (window.scrollY > stickyPoint) {
                    navbar.classList.add("sticky-nav");
                } else {
                    navbar.classList.remove("sticky-nav");
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const customBtn = document.getElementById("customAccessibilityBtn");

            if (customBtn) {
                customBtn.addEventListener("click", function () {
                    const originalBtn = document.querySelector(".asw-menu-btn");

                    if (originalBtn) {
                        originalBtn.click();
                    } else {
                        console.log("Accessibility button not found");
                    }
                });
            }
        });
    </script>


    <script>
        const chatToggle = document.getElementById("chatToggle");
        const chatBox = document.getElementById("chatBox");
        const closeChat = document.getElementById("closeChat");
        const chatBody = document.getElementById("chatBody");
        const userInput = document.getElementById("userInput");
        const chatbotBubble = document.getElementById("chatbotBubble");
        const chatbotContainer = document.getElementById("chatbotContainer");

        chatToggle.addEventListener("click", () => {
            chatBox.style.display = "flex";
            if (chatbotBubble) chatbotBubble.style.display = "none";
            if (chatbotContainer) chatbotContainer.classList.remove("bounce-animation");
            userInput.focus();
        });

        closeChat.addEventListener("click", () => {
            chatBox.style.display = "none";
            if (chatbotBubble) chatbotBubble.style.display = "block";
            if (chatbotContainer) chatbotContainer.classList.add("bounce-animation");
        });

        // Enter key support
        userInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                sendMessage();
            }
        });

        function sendMessage() {
            let message = userInput.value.trim();

            if (message === "") return;

            // User message
            let userMsg = document.createElement("div");
            userMsg.className = "user-message";
            userMsg.innerText = message;
            chatBody.appendChild(userMsg);

            userInput.value = "";

            // Typing loader
            let typingMsg = document.createElement("div");
            typingMsg.className = "bot-message typing";
            typingMsg.innerText = "Typing...";
            chatBody.appendChild(typingMsg);

            chatBody.scrollTop = chatBody.scrollHeight;

            fetch("{{ url('/chatbot/reply') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    message: message
                })
            })
                .then(response => response.json())
                .then(data => {
                    typingMsg.remove();

                    let botMsg = document.createElement("div");
                    botMsg.className = "bot-message";
                    botMsg.innerText = data.reply;

                    chatBody.appendChild(botMsg);
                    chatBody.scrollTop = chatBody.scrollHeight;

                    if (data.redirect) {
                        setTimeout(() => {
                            document.getElementById("contact-support-section").scrollIntoView({
                                behavior: "smooth",
                                block: "start"
                            });
                        }, 1500);
                    }
                })
                .catch(error => {
                    typingMsg.remove();

                    let errorMsg = document.createElement("div");
                    errorMsg.className = "bot-message";
                    errorMsg.innerText = "Something went wrong. Please try again.";

                    chatBody.appendChild(errorMsg);
                });
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            loadQuestions();
        });

        function loadQuestions() {
            fetch("{{ url('/chatbot/questions') }}")
                .then(response => response.json())
                .then(data => {
                    let faqBox = document.getElementById("faqQuestions");
                    faqBox.innerHTML = "";

                    data.forEach(item => {
                        let btn = document.createElement("button");
                        btn.className = "faq-btn";
                        btn.innerText = item.question;

                        btn.onclick = function () {
                            userInput.value = item.question;
                            sendMessage();
                        };

                        faqBox.appendChild(btn);
                    });
                });
        }
    </script>

    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                {
                    pageLanguage: 'en',
                    includedLanguages: 'en,hi,es,fr,de,ru,ar,zh-CN,ja,sa,bn,ta,te',
                    autoDisplay: false
                },
                'google_translate_element'
            );
        }

        document.getElementById('languageSwitcher').addEventListener('change', function () {
            let lang = this.value;
            let attempts = 0;

            function triggerTranslation() {
                let select = document.querySelector('.goog-te-combo');
                if (select) {
                    select.value = lang;
                    select.dispatchEvent(new Event('change'));
                } else if (attempts < 20) {
                    attempts++;
                    setTimeout(triggerTranslation, 150);
                }
            }

            triggerTranslation();
        });
    </script>


</body>

</html>