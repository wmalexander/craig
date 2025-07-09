/**
 * FloydFest Countdown Frontend JavaScript
 * Version: 0.1.0
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initCountdown();
    });

    function initCountdown() {
        const countdownElement = document.getElementById('floydfest-countdown-timer');
        
        if (!countdownElement || !window.floydFestCountdown) {
            return;
        }

        // Parse target date (July 23, 2025 10:00 AM EST)
        // Convert timezone string to proper format
        const dateString = window.floydFestCountdown.targetDate;
        const targetDate = new Date(dateString + ' EST');
        const options = window.floydFestCountdown.options;

        // Update countdown immediately and then every second
        updateCountdown();
        setInterval(updateCountdown, 1000);

        function updateCountdown() {
            const now = new Date();
            const timeDiff = targetDate - now;

            // Check if event has passed
            if (timeDiff <= 0) {
                countdownElement.innerHTML = '<span class="countdown-ended">FloydFest 2025 has begun!</span>';
                return;
            }

            // Calculate time units
            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

            // Generate HTML based on display format
            let html = '';
            
            if (options.display_format === 'full' || !options.display_format) {
                html = `
                    <div class="countdown-unit">
                        <span class="countdown-number">${days}</span>
                        <span class="countdown-label">${days === 1 ? 'Day' : 'Days'}</span>
                    </div>
                    <div class="countdown-unit">
                        <span class="countdown-number">${padZero(hours)}</span>
                        <span class="countdown-label">${hours === 1 ? 'Hour' : 'Hours'}</span>
                    </div>
                    <div class="countdown-unit">
                        <span class="countdown-number">${padZero(minutes)}</span>
                        <span class="countdown-label">${minutes === 1 ? 'Minute' : 'Minutes'}</span>
                    </div>
                    <div class="countdown-unit">
                        <span class="countdown-number">${padZero(seconds)}</span>
                        <span class="countdown-label">${seconds === 1 ? 'Second' : 'Seconds'}</span>
                    </div>
                `;
            } else if (options.display_format === 'days') {
                html = `<span class="countdown-days-only">${days} ${days === 1 ? 'day' : 'days'} until FloydFest!</span>`;
            } else if (options.display_format === 'compact') {
                html = `<span class="countdown-compact">${days}d ${hours}h ${minutes}m ${seconds}s</span>`;
            }

            countdownElement.innerHTML = html;
        }

        function padZero(num) {
            return num < 10 ? '0' + num : num;
        }
    }

    // Handle dynamic option updates (for future admin preview functionality)
    window.floydFestUpdateCountdown = function() {
        initCountdown();
    };

})();