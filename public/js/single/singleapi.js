jQuery(document).ready(function($){
   //console.log('singleapi');

   $(document).on("click",".checkAvailabilityApiIsland",function(e){
      e.preventDefault();
      let self = $(this);
      console.log(self);

      let posts = self.closest('.availabilty-block').find('input').serialize();
      console.log(posts);

      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      let data = {
         posts:posts
      };

      $.ajax({
         method: "POST",
         url: '/public/' + $("#language").val() + '/single/check/availability',
         dataYype: 'json',
         data: data,
         success: function (data) {
             let text = data.days + ' ' + GetText(lang, 'night', data.days );
         }
     });

   });

});