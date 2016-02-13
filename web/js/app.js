'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var OfficeFetcher = function () {
    function OfficeFetcher() {
        _classCallCheck(this, OfficeFetcher);

        this.offices = [];

        this.place = null;

        this.view = $('.results > ul');

        this.isOpenInWeekends = $('#is_open_in_weekends');

        this.hasSupportDesk = $('#has_support_desk');
    }

    _createClass(OfficeFetcher, [{
        key: 'fetchOffices',
        value: function fetchOffices(place) {
            var _this = this;

            this.place = place;

            var is_open_in_weekends = this.isOpenInWeekends.is(':checked');
            var has_support_desk = this.hasSupportDesk.is(':checked');

            var data;

            if (place.vicinity) {
                data = {
                    city: place.vicinity,
                    lat: place.geometry.location.lat(),
                    long: place.geometry.location.lng(),
                    is_open_in_weekends: is_open_in_weekends,
                    has_support_desk: has_support_desk
                };
            } else {
                data = {
                    city: place.name,
                    is_open_in_weekends: is_open_in_weekends,
                    has_support_desk: has_support_desk
                };
            }
            console.log(data);

            $.ajax({
                url: "app_dev.php/api/v1/offices/search",
                type: "get",
                data: data,
                success: function success(response) {
                    _this.offices = response;

                    _this.populateView();
                },
                error: function error(xhr) {
                    console.log(xhr);
                }
            });
        }
    }, {
        key: 'clearView',
        value: function clearView() {
            this.view.html('');
        }
    }, {
        key: 'populateView',
        value: function populateView() {
            var html = '';
            var _iteratorNormalCompletion = true;
            var _didIteratorError = false;
            var _iteratorError = undefined;

            try {
                for (var _iterator = this.offices[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                    var office = _step.value;

                    console.log(office);
                    html += '<li>Kantoor te ' + office.street + ', ' + office.city + '</li>';
                }
            } catch (err) {
                _didIteratorError = true;
                _iteratorError = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion && _iterator.return) {
                        _iterator.return();
                    }
                } finally {
                    if (_didIteratorError) {
                        throw _iteratorError;
                    }
                }
            }

            this.view.html(html);
        }
    }, {
        key: 'refetch',
        value: function refetch() {
            if (this.place) {
                console.log(this.place);
                this.fetchOffices(this.place);
            }
        }
    }]);

    return OfficeFetcher;
}();

$(document).ready(function () {
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

    $('#searchForm').submit(function (e) {
        e.preventDefault();
    });

    $('.office-condition').on('click', function () {
        officeFetcher.refetch();
    });
});