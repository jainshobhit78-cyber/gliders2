(function () {
    "use strict";

    document.addEventListener("DOMContentLoaded", function () {
        var experience = document.getElementById("launchExperience");
        if (!experience) return;

        var root = document.getElementById("root");
        var skipButton = document.getElementById("launchEnterButton");
        var countdownNumber = document.getElementById("launchCountdownNumber");
        var countdownWord = document.getElementById("launchCountdownWord");
        var liveStatus = document.getElementById("launchLiveStatus");
        var isPreview = experience.dataset.preview === "true";
        var sessionKey = "gliders-launch-experience-" + experience.dataset.version;
        var requestedDuration = parseInt(experience.dataset.duration || "16", 10);
        var reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
        var timers = [];
        var countdownTimer = null;
        var revealed = false;
        var currentPhase = "intro";
        var fireworks = createFireworks(document.getElementById("launchFireworksCanvas"));

        var ribbonDuration = reducedMotion ? 550 : 1900;
        var countdownStep = reducedMotion ? 250 : 1000;
        var countdownDuration = countdownStep * 5;
        var finaleDuration = reducedMotion ? 900 : 3300;
        var totalDuration = Math.max(14, Math.min(30, Number.isFinite(requestedDuration) ? requestedDuration : 16)) * 1000;
        var introDuration = reducedMotion
            ? 900
            : Math.max(2800, totalDuration - ribbonDuration - countdownDuration - finaleDuration);

        var countdownWords = {
            5: "Five seconds to a new chapter",
            4: "Innovation moves forward",
            3: "Built on courage and capability",
            2: "Designed for a self-reliant India",
            1: "Ready for take-off"
        };

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
                // The ceremony remains usable when browser storage is unavailable.
            }
        }

        function schedule(callback, delay) {
            var timer = window.setTimeout(callback, delay);
            timers.push(timer);
            return timer;
        }

        function clearSequence() {
            timers.forEach(function (timer) { window.clearTimeout(timer); });
            timers = [];
            if (countdownTimer) {
                window.clearInterval(countdownTimer);
                countdownTimer = null;
            }
        }

        function announce(message) {
            if (liveStatus) liveStatus.textContent = message;
        }

        function updatePhaseIndicator(phase) {
            experience.querySelectorAll("[data-phase-dot]").forEach(function (dot) {
                dot.classList.toggle("is-active", dot.dataset.phaseDot === phase);
            });
        }

        function setPhase(phase) {
            currentPhase = phase;
            experience.classList.remove("phase-intro", "phase-ribbon", "phase-countdown", "phase-finale");
            experience.classList.add("phase-" + phase);
            updatePhaseIndicator(phase);
        }

        function replayTextAnimation(element, className) {
            if (!element) return;
            element.classList.remove(className);
            void element.offsetWidth;
            element.classList.add(className);
        }

        function showCountdownValue(value) {
            if (countdownNumber) countdownNumber.textContent = value;
            if (countdownWord) countdownWord.textContent = countdownWords[value] || "A new digital chapter begins";
            replayTextAnimation(countdownNumber, "is-ticking");
            replayTextAnimation(countdownWord, "is-changing");
            announce("Website launch in " + value + (value === 1 ? " second" : " seconds"));
        }

        function enterRibbonScene() {
            if (revealed) return;
            setPhase("ribbon");
            announce("Ceremonial ribbon cutting");
            schedule(function () {
                experience.classList.add("ribbon-cut");
            }, reducedMotion ? 80 : 570);
            schedule(enterCountdownScene, ribbonDuration);
        }

        function enterCountdownScene() {
            if (revealed) return;
            experience.classList.remove("ribbon-cut");
            setPhase("countdown");

            var remaining = 5;
            showCountdownValue(remaining);
            countdownTimer = window.setInterval(function () {
                remaining -= 1;
                if (remaining > 0) {
                    showCountdownValue(remaining);
                    return;
                }

                window.clearInterval(countdownTimer);
                countdownTimer = null;
                enterFinaleScene();
            }, countdownStep);
        }

        function enterFinaleScene() {
            if (revealed) return;
            setPhase("finale");
            announce("Welcome to the new Gliders India website");
            fireworks.start();
            schedule(revealWebsite, finaleDuration);
        }

        function removeExperience() {
            fireworks.destroy();
            experience.remove();
            document.body.classList.remove("launch-experience-active", "launch-experience-revealing");
        }

        function revealWebsite() {
            if (revealed) return;
            revealed = true;
            clearSequence();
            markAsSeen();
            announce("Opening the Gliders India homepage");
            experience.classList.add("is-revealing");
            document.body.classList.add("launch-experience-revealing");
            if (root) root.setAttribute("aria-hidden", "false");
            schedule(removeExperience, reducedMotion ? 100 : 1650);
        }

        function removeImmediately() {
            fireworks.destroy();
            experience.remove();
            document.body.classList.remove("launch-experience-active");
        }

        function handleEscape(event) {
            if (event.key === "Escape") revealWebsite();
        }

        if (!isPreview && hasBeenSeen()) {
            removeImmediately();
            return;
        }

        if (root) root.setAttribute("aria-hidden", "true");
        experience.classList.add("phase-intro");
        window.requestAnimationFrame(function () {
            experience.classList.add("is-ready");
            announce("Gliders India launch ceremony started");
        });

        schedule(enterRibbonScene, introDuration);
        if (skipButton) skipButton.addEventListener("click", revealWebsite);
        document.addEventListener("keydown", handleEscape);

        function createFireworks(canvas) {
            if (!canvas || !canvas.getContext) return { start: function () {}, destroy: function () {} };

            var context = canvas.getContext("2d");
            if (!context) return { start: function () {}, destroy: function () {} };

            var particles = [];
            var shockwaves = [];
            var animationFrame = null;
            var burstTimer = null;
            var active = false;
            var width = 0;
            var height = 0;
            var pixelRatio = 1;
            var palette = ["#ff8b22", "#ffc775", "#ffffff", "#55db85", "#138542", "#70b7ff"];

            function resize() {
                pixelRatio = Math.min(window.devicePixelRatio || 1, 2);
                width = window.innerWidth;
                height = window.innerHeight;
                canvas.width = Math.round(width * pixelRatio);
                canvas.height = Math.round(height * pixelRatio);
                canvas.style.width = width + "px";
                canvas.style.height = height + "px";
                context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
            }

            function makeParticle(x, y, color, angle, speed) {
                return {
                    x: x,
                    y: y,
                    previousX: x,
                    previousY: y,
                    velocityX: Math.cos(angle) * speed,
                    velocityY: Math.sin(angle) * speed,
                    gravity: .052 + Math.random() * .035,
                    drag: .982,
                    alpha: 1,
                    decay: .011 + Math.random() * .009,
                    color: color,
                    size: 1.25 + Math.random() * 1.8,
                    shimmer: Math.random() > .58
                };
            }

            function burst(x, y, scale) {
                var color = palette[Math.floor(Math.random() * palette.length)];
                var count = Math.round((44 + Math.random() * 28) * scale);
                var offset = Math.random() * Math.PI;

                for (var index = 0; index < count; index += 1) {
                    var angle = offset + (Math.PI * 2 * index / count) + (Math.random() - .5) * .12;
                    var speed = (2.1 + Math.random() * 4.8) * scale;
                    particles.push(makeParticle(x, y, index % 6 === 0 ? "#ffffff" : color, angle, speed));
                }

                shockwaves.push({ x: x, y: y, radius: 4, alpha: .75, color: color });
            }

            function launchPattern() {
                if (!active) return;
                var x = width * (.12 + Math.random() * .76);
                var y = height * (.12 + Math.random() * .46);
                burst(x, y, width < 600 ? .72 : 1);
                burstTimer = window.setTimeout(launchPattern, 310 + Math.random() * 390);
            }

            function drawParticle(particle) {
                particle.previousX = particle.x;
                particle.previousY = particle.y;
                particle.velocityX *= particle.drag;
                particle.velocityY = particle.velocityY * particle.drag + particle.gravity;
                particle.x += particle.velocityX;
                particle.y += particle.velocityY;
                particle.alpha -= particle.decay;

                context.globalAlpha = Math.max(0, particle.alpha);
                context.strokeStyle = particle.color;
                context.lineWidth = particle.size;
                context.lineCap = "round";
                context.shadowColor = particle.color;
                context.shadowBlur = particle.shimmer ? 12 : 6;
                context.beginPath();
                context.moveTo(particle.previousX, particle.previousY);
                context.lineTo(particle.x, particle.y);
                context.stroke();

                if (particle.shimmer && Math.random() > .82) {
                    context.fillStyle = "#fff";
                    context.beginPath();
                    context.arc(particle.x, particle.y, particle.size * 1.45, 0, Math.PI * 2);
                    context.fill();
                }
            }

            function drawShockwave(wave) {
                wave.radius += 3.2;
                wave.alpha -= .026;
                context.globalAlpha = Math.max(0, wave.alpha);
                context.strokeStyle = wave.color;
                context.lineWidth = 1.2;
                context.shadowColor = wave.color;
                context.shadowBlur = 14;
                context.beginPath();
                context.arc(wave.x, wave.y, wave.radius, 0, Math.PI * 2);
                context.stroke();
            }

            function render() {
                context.clearRect(0, 0, width, height);
                context.globalCompositeOperation = "lighter";

                particles.forEach(drawParticle);
                shockwaves.forEach(drawShockwave);
                particles = particles.filter(function (particle) { return particle.alpha > 0; });
                shockwaves = shockwaves.filter(function (wave) { return wave.alpha > 0; });

                context.globalAlpha = 1;
                context.shadowBlur = 0;
                context.globalCompositeOperation = "source-over";
                if (active || particles.length || shockwaves.length) {
                    animationFrame = window.requestAnimationFrame(render);
                }
            }

            function start() {
                if (active || reducedMotion) return;
                active = true;
                resize();
                window.addEventListener("resize", resize);
                burst(width * .22, height * .3, width < 600 ? .7 : 1);
                window.setTimeout(function () { if (active) burst(width * .78, height * .24, width < 600 ? .7 : 1); }, 180);
                window.setTimeout(function () { if (active) burst(width * .5, height * .43, width < 600 ? .72 : .92); }, 430);
                launchPattern();
                render();
            }

            function destroy() {
                active = false;
                if (burstTimer) window.clearTimeout(burstTimer);
                if (animationFrame) window.cancelAnimationFrame(animationFrame);
                window.removeEventListener("resize", resize);
                particles = [];
                shockwaves = [];
                context.clearRect(0, 0, width, height);
                document.removeEventListener("keydown", handleEscape);
            }

            return { start: start, destroy: destroy };
        }
    });
}());
