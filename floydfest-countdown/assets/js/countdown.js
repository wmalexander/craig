/**
 * FloydFest Countdown Frontend JavaScript
 * Version: 0.3.0
 */

(function() {
    'use strict';

    // Initialize when DOM is ready or immediately if already loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCountdown);
    } else {
        initCountdown();
    }

    function initCountdown() {
        const countdownElement = document.getElementById('floydfest-countdown-timer');
        
        if (!countdownElement || !window.floydFestCountdown) {
            return;
        }

        // Parse target date with timezone handling
        const dateString = window.floydFestCountdown.targetDate;
        const timezone = window.floydFestCountdown.timezone || 'America/New_York';
        
        // Create date in EST/EDT timezone
        const targetDate = new Date(dateString.replace(' ', 'T') + '-05:00'); // EST offset
        const options = window.floydFestCountdown.options || {};

        // Ensure countdown container exists and is visible
        ensureCountdownVisibility();
        
        // Update countdown immediately and then every second
        updateCountdown();
        const interval = setInterval(updateCountdown, 1000);
        
        // Cleanup interval if container is removed
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    mutation.removedNodes.forEach(function(node) {
                        if (node.nodeType === Node.ELEMENT_NODE && 
                            (node.id === 'floydfest-countdown-container' || 
                             node.contains(document.getElementById('floydfest-countdown-container')))) {
                            clearInterval(interval);
                            observer.disconnect();
                        }
                    });
                }
            });
        });
        
        observer.observe(document.body, { childList: true, subtree: true });

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
        
        function ensureCountdownVisibility() {
            const container = document.getElementById('floydfest-countdown-container');
            if (!container) {
                return;
            }
            
            // Ensure countdown is not hidden by theme styles
            const computedStyle = window.getComputedStyle(container);
            if (computedStyle.display === 'none' || computedStyle.visibility === 'hidden') {
                container.style.display = 'block';
                container.style.visibility = 'visible';
            }
            
            // Ensure z-index is high enough
            const zIndex = parseInt(computedStyle.zIndex);
            if (isNaN(zIndex) || zIndex < 999999) {
                container.style.zIndex = '999999';
            }
        }
    }

    // Handle dynamic option updates (for future admin preview functionality)
    window.floydFestUpdateCountdown = function() {
        initCountdown();
    };

})();