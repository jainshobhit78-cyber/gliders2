(function () {
    "use strict";

    document.addEventListener("DOMContentLoaded", function () {
        var experience = document.getElementById("launchExperience");
        if (!experience) return;

        var isPreview = experience.dataset.preview === "true";
        var sessionKey = "gliders-launch-experience-" + experience.dataset.version;
        var root = document.getElementById("root");
        var enterButton = document.getElementById("launchEnterButton");
        var autoNote = document.getElementById("launchAutoNote");
        var ceremonySeconds = document.getElementById("launchCeremonySeconds");
        var countdown = document.getElementById("launchCountdown");
        var autoSeconds = Math.max(10, parseInt(experience.dataset.autoReveal || "10", 10));
        var targetTime = Date.parse(experience.dataset.target || "");
        var countdownTimer;
        var revealTimer;
        var celebrationTimer;
        var noteTimer;
        var revealed = false;
        var celebrating = false;
        var targetCompleted = false;

        function hasBeenSeen() {
            try {
                return window.sessionStorage.getItem(sessionKey) === "seen";
            } catch (error) {
                return false;
            }
        }

        function markAsSeen() {
            if (isPreview) return;
            try {
                window.sessionStorage.setItem(sessionKey, "seen");
            } catch (error) {
                // The experience remains fully usable when storage is unavailable.
            }
        }

        function removeImmediately() {
            experience.remove();
            document.body.classList.remove("launch-experience-active");
        }

        function revealWebsite() {
            if (revealed) return;
            revealed = true;
            window.clearInterval(countdownTimer);
            window.clearInterval(noteTimer);
            window.clearTimeout(revealTimer);
            window.clearTimeout(celebrationTimer);
            markAsSeen();
            experience.classList.add("is-revealing");
            document.body.classList.add("launch-experience-revealing");
            if (root) root.setAttribute("aria-hidden", "false");

            window.setTimeout(function () {
                experience.remove();
                document.body.classList.remove("launch-experience-active", "launch-experience-revealing");
            }, 1750);
        }

        function beginCelebration() {
            if (revealed || celebrating) return;
            celebrating = true;
            window.clearInterval(noteTimer);
            window.clearTimeout(revealTimer);
            if (ceremonySeconds) ceremonySeconds.textContent = "0";
            if (autoNote) autoNote.textContent = "Ribbon cut — launching now";
            experience.classList.add("is-celebrating");
            celebrationTimer = window.setTimeout(revealWebsite, 2600);
        }

        function pad(value) {
            return String(Math.max(0, value)).padStart(2, "0");
        }

        function setValue(selector, value) {
            var element = experience.querySelector(selector);
            if (element) element.textContent = pad(value);
        }

        function updateCountdown() {
            if (!Number.isFinite(targetTime)) {
                if (countdown) countdown.hidden = true;
                return;
            }

            var distance = Math.max(0, targetTime - Date.now());
            var days = Math.floor(distance / 86400000);
            var hours = Math.floor((distance % 86400000) / 3600000);
            var minutes = Math.floor((distance % 3600000) / 60000);
            var seconds = Math.floor((distance % 60000) / 1000);

            setValue("[data-launch-days]", days);
            setValue("[data-launch-hours]", hours);
            setValue("[data-launch-minutes]", minutes);
            setValue("[data-launch-seconds]", seconds);

            if (distance === 0 && !targetCompleted) {
                targetCompleted = true;
                experience.classList.add("countdown-complete");
            }
        }

        if (!isPreview && hasBeenSeen()) {
            removeImmediately();
            return;
        }

        if (root) root.setAttribute("aria-hidden", "true");
        window.requestAnimationFrame(function () {
            experience.classList.add("is-ready");
        });

        updateCountdown();
        countdownTimer = window.setInterval(updateCountdown, 1000);

        var remaining = autoSeconds;
        if (ceremonySeconds) ceremonySeconds.textContent = remaining;
        noteTimer = window.setInterval(function () {
            remaining -= 1;
            if (ceremonySeconds) ceremonySeconds.textContent = Math.max(0, remaining);
            if (remaining > 0 && autoNote) {
                autoNote.innerHTML = "Website opens automatically in <b>" + remaining + "</b>s";
            } else if (remaining <= 0) {
                window.clearInterval(noteTimer);
                beginCelebration();
            }
        }, 1000);

        revealTimer = window.setTimeout(beginCelebration, autoSeconds * 1000);
        enterButton.addEventListener("click", beginCelebration);
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") beginCelebration();
        }, { once: true });
    });
}());
