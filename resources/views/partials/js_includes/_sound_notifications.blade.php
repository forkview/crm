@if(Auth::user()->user_type_id == 13)
<script>
    setInterval(function(){
      $.ajax({
          type: "POST",
          url: '{{ route('api.getStatsDkj') }}',
          data: {},
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
              var sound = false;
							console.log(response);
              for (var i = 0; i < response.length; i++) {

									if (response[i].type == 'Badania/Wysyłka') {
											var countMeShipping = $("#" + response[i].department_info_id*(-1) + "dkjstatus td[name='undone']").text();
											var countMeResearch = $("#" + response[i].department_info_id + "dkjstatus td[name='undone']").text();
											if ((response[i].manager_research_janky_count != countMeResearch && response[i].manager_research_janky_count > countMeResearch)
												|| response[i].manager_shipping_janky_count != countMeShipping && response[i].manager_shipping_janky_count > countMeShipping) {
													var sound = true;
											}

									} else if (response[i].type == 'Badania') {
											var countMe = $("#" + response[i].department_info_id + "dkjstatus td[name='undone']").text();
											if (response[i].manager_research_janky_count != countMe && response[i].manager_research_janky_count > countMe) {
													var sound = true;
											}
									} else if (response[i].type == 'Wysyłka') {
											var countMe = $("#" + response[i].department_info_id + "dkjstatus td[name='undone']").text();
											if (response[i].manager_shipping_janky_count != countMe && response[i].manager_shipping_janky_count > countMe) {
													var sound = true;
											}
									}
              }
							//tutaj ding
							if (sound == true) {
									var snd = new Audio("{{asset('assets/1.mp3')}}");
                  snd.play();
                  sound = false;
                  $('#check_messages_dkj').html('(!) <i class="fa fa-envelope fa-fw"></i><i class="fa fa-caret-down"></i>');

									for (var i = 0; i < response.length; i++) {
										if(response[i].type == 'Badania/Wysyłka') { // tutaj jezeli sa 2 rodzaje oddziału (badania/wysyłka)
												$("#" + response[i].department_info_id + "dkjstatus td[name='status']").text("Odsłuchany (" + response[i].research_all + ")");
												$("#" + response[i].department_info_id + "dkjstatus td[name='count_yanek']").text(response[i].research_janky_count);
												$("#" + response[i].department_info_id + "dkjstatus td[name='undone']").text(response[i].manager_research_janky_count);
												$("#" + response[i].department_info_id + "dkjstatus td[name='status']").removeClass("alert-danger");
												$("#" + response[i].department_info_id + "dkjstatus td[name='status']").addClass("alert-success");

												$("#" + response[i].department_info_id*(-1) + "dkjstatus td[name='status']").text("Odsłuchany (" + response[i].shipping_all + ")");
												$("#" + response[i].department_info_id*(-1) + "dkjstatus td[name='count_yanek']").text(response[i].shipping_janky_count);
												$("#" + response[i].department_info_id*(-1) + "dkjstatus td[name='undone']").text(response[i].manager_shipping_janky_count);
												$("#" + response[i].department_info_id*(-1) + "dkjstatus td[name='status']").removeClass("alert-danger");
												$("#" + response[i].department_info_id*(-1) + "dkjstatus td[name='status']").addClass("alert-success");

										} else { // tutaj jezeli nie ma oddział nie jest podzielony na badania/wysyłkę
												$("#" + response[i].department_info_id + "dkjstatus td[name='status']").text("Odsłuchany (" + response[i].all_check_talk + ")");
												$("#" + response[i].department_info_id + "dkjstatus td[name='count_yanek']").text(response[i].all_bad);
												$("#" + response[i].department_info_id + "dkjstatus td[name='undone']").text(response[i].manager_research_janky_count);
												$("#" + response[i].department_info_id + "dkjstatus td[name='status']").removeClass("alert-danger");
												$("#" + response[i].department_info_id + "dkjstatus td[name='status']").addClass("alert-success");
										}
									}
							}
          }
      });
    }, 60000);
</script>
@endif
