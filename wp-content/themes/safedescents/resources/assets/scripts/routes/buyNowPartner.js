$(function() {
    $.extend({
        getUrlVars: function() {
            var vars = [],
                hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        getUrlVar: function(name) {
            return $.getUrlVars()[name];
        },
    });

    function validateStartDate() {
      
    }

    // routes wasn't working so i did this.
    if (document.location.pathname === '/buy-now-partner/') {
        $('.pass-select').on('click', 'div.pass-choice', function(ev){
          $('.pass-choice').removeClass('pass-choice-active');
          $(this).addClass('pass-choice-active');
        });

        // Add flatpickr to date fields
        $('input[name="start-date"]').flatpickr({
            altInput: true,
            altFormat: 'n/d/Y',
            dateFormat: 'Y-m-d',
            mode: 'single',
            minDate: 'today',
            onChange: validateStartDate,
            onReady: function(selectedDates, dateStr, instance) {
                if (instance.isMobile) {
                    $(instance.mobileInput).removeAttr('step');
                }
            },
        });

        $('.pass-read-more').on('click', function(){
          $('#read-more').toggleClass('hidden');
          $('html,body').animate({scrollTop: $("#read-more").offset().top},'slow');
        });

        $.get("/wp-json/wp/v2/partner-api?_embed", function(data, status) {
            var query = $.getUrlVars(),
                matchingPartner = {},
                partnerInfo = '';

            for (var i = 0; i < data.length; i++) {
                var partner = data[i];

                if (query.partner === partner.slug) {
                    matchingPartner = partner;
                    break;
                }
            }
            partnerInfo += '<div class="col-sm-12 col-md-3"><img class="partner-logo" src="' + matchingPartner._embedded['wp:featuredmedia'][0].source_url + '" /"></div>';
            partnerInfo += '<div clas="partner-content col-sm-12 col-md-9" >';
            partnerInfo += '<h2>' + matchingPartner.title.rendered + '</h2>';
            partnerInfo += '<p>' + matchingPartner.content.rendered + '</p>';
            partnerInfo += '</div>';
            console.log(matchingPartner);
            $('#partner-info').html(partnerInfo);
        });
    }
});