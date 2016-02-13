class OfficeFetcher {

    constructor(){
        this.offices = [];

        this.place = null;

        this.view = $('.results > ul');

        this.isOpenInWeekends = $('#is_open_in_weekends');

        this.hasSupportDesk = $('#has_support_desk');
    }

    fetchOffices(place){
        this.place = place;

        let is_open_in_weekends = this.isOpenInWeekends.is(':checked');
        let has_support_desk = this.hasSupportDesk.is(':checked');

        var data;

        if(place.vicinity) {
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
                has_support_desk: has_support_desk,
            }
        }
        console.log(data);


        $.ajax({
            url: "app_dev.php/api/v1/offices/search",
            type: "get",
            data: data,
            success: (response) => {
                this.offices = response;

                this.populateView();
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }

    clearView(){
        this.view.html('');
    }

    populateView(){
        var html = '';
        for(let office of this.offices) {
            console.log(office);
            html += `<li>Kantoor te ${office.street}, ${office.city}</li>`;
        }

        this.view.html(html);
    }

    refetch(){
        if(this.place) {
            console.log(this.place);
            this.fetchOffices(this.place);
        }
    }
}
