/**
 * FloydFest Countdown Admin JavaScript
 * Version: 0.4.0
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        initColorPickers();
        initPreview();
        bindEventHandlers();
    });

    /**
     * Initialize WordPress color pickers
     */
    function initColorPickers() {
        $('.color-picker').wpColorPicker({
            change: function(event, ui) {
                updatePreview();
            },
            clear: function() {
                updatePreview();
            }
        });
    }

    /**
     * Initialize preview functionality
     */
    function initPreview() {
        updatePreview();
        startPreviewCountdown();
    }

    /**
     * Bind event handlers
     */
    function bindEventHandlers() {
        // Update preview when form fields change
        $('#position, #display_format, #enabled').on('change', updatePreview);
        
        // Form validation
        $('form').on('submit', validateForm);
    }

    /**
     * Update preview based on current settings
     */
    function updatePreview() {
        const $preview = $('#preview-container');
        const $previewTimer = $('#preview-timer');
        
        // Get current form values
        const enabled = $('#enabled').is(':checked');
        const position = $('#position').val();
        const displayFormat = $('#display_format').val();
        const backgroundColor = $('#background_color').val() || '#FF6B6B';
        const textColor = $('#text_color').val() || '#FFFFFF';
        
        // Update preview container styles
        $preview.css({
            'background-color': backgroundColor,
            'color': textColor
        });
        
        // Update position class
        $preview.removeClass('preview-floating');
        if (position === 'floating') {
            $preview.addClass('preview-floating');
        }
        
        // Update enabled state
        if (!enabled) {
            $preview.css('opacity', '0.5');
            $previewTimer.html('<span class="preview-loading">Countdown is disabled</span>');
        } else {
            $preview.css('opacity', '1');
            updatePreviewTimer(displayFormat);
        }
    }

    /**
     * Update preview timer display
     */
    function updatePreviewTimer(displayFormat) {
        const $previewTimer = $('#preview-timer');
        
        // Calculate time until FloydFest (July 23, 2025 10:00 AM EST)
        const targetDate = new Date('2025-07-23T10:00:00-05:00');
        const now = new Date();
        const timeDiff = targetDate - now;
        
        if (timeDiff <= 0) {
            $previewTimer.html('<span class="preview-ended">FloydFest 2025 has begun!</span>');
            return;
        }
        
        const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
        
        let html = '';
        
        if (displayFormat === 'full') {
            html = `
                <div class="preview-unit">
                    <span class="preview-number">${days}</span>
                    <span class="preview-unit-label">${days === 1 ? 'Day' : 'Days'}</span>
                </div>
                <div class="preview-unit">
                    <span class="preview-number">${padZero(hours)}</span>
                    <span class="preview-unit-label">${hours === 1 ? 'Hour' : 'Hours'}</span>
                </div>
                <div class="preview-unit">
                    <span class="preview-number">${padZero(minutes)}</span>
                    <span class="preview-unit-label">${minutes === 1 ? 'Minute' : 'Minutes'}</span>
                </div>
                <div class="preview-unit">
                    <span class="preview-number">${padZero(seconds)}</span>
                    <span class="preview-unit-label">${seconds === 1 ? 'Second' : 'Seconds'}</span>
                </div>
            `;
        } else if (displayFormat === 'days') {
            html = `<span class="preview-days-only">${days} ${days === 1 ? 'day' : 'days'} until FloydFest!</span>`;
        } else if (displayFormat === 'compact') {
            html = `<span class="preview-compact">${days}d ${hours}h ${minutes}m ${seconds}s</span>`;
        }
        
        $previewTimer.html(html);
    }

    /**
     * Start preview countdown timer
     */
    function startPreviewCountdown() {
        setInterval(function() {
            const displayFormat = $('#display_format').val();
            const enabled = $('#enabled').is(':checked');
            
            if (enabled) {
                updatePreviewTimer(displayFormat);
            }
        }, 1000);
    }

    /**
     * Pad number with zero
     */
    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }

    /**
     * Validate form before submission
     */
    function validateForm(event) {
        const backgroundColor = $('#background_color').val();
        const textColor = $('#text_color').val();
        
        // Validate hex colors
        if (backgroundColor && !isValidHexColor(backgroundColor)) {
            event.preventDefault();
            alert('Please enter a valid hex color for background color.');
            return false;
        }
        
        if (textColor && !isValidHexColor(textColor)) {
            event.preventDefault();
            alert('Please enter a valid hex color for text color.');
            return false;
        }
        
        return true;
    }

    /**
     * Check if string is valid hex color
     */
    function isValidHexColor(hex) {
        return /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(hex);
    }

    /**
     * Show success message after settings save
     */
    function showSuccessMessage() {
        const $notice = $('<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>');
        $('.wrap h1').after($notice);
        
        setTimeout(function() {
            $notice.fadeOut();
        }, 3000);
    }

    // Handle settings update success
    if (window.location.search.indexOf('settings-updated=true') !== -1) {
        setTimeout(showSuccessMessage, 100);
    }

})(jQuery);