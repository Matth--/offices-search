$(document).ready(function() {
    var officeFetcher = new OfficeFetcher();

    function initialize() {
        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            officeFetcher.fetchOffices(place);
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

    $('#searchForm').submit(function(e) {
        e.preventDefault();
    });

    $('.office-condition').on('click', () => {
        officeFetcher.refetch();
    });
});