jQuery(document).ready(function($) {
    const $eventContainer = $('#events-container');
    const $toggleButton = $('#toggle-layout');

    $toggleButton.click(function() {
        $eventContainer.toggleClass('as-list');
    });
});