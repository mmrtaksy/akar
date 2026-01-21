
document.addEventListener("DOMContentLoaded", function () {


    $('#menu').on('click', function(e){
        e.preventDefault();

        let sb = $('#sidebar');

        if(sb.hasClass('-left-full')){
            sb.removeClass('-left-full');
        }else{
            sb.addClass('-left-full');
        }
    });




    let modal = null;
    const viewModals = document.querySelectorAll('.viewModal');
    const modalCloseBtn = document.getElementById('modalCloseBtn');

    if (viewModals) {
        viewModals.forEach((btn) => {
            btn.addEventListener('click', () => {
                const modalID = btn.getAttribute('data-modal');
                modal = document.querySelector('.modal[id="' + modalID + '"]');
                if(!modal){
                    alert('Modal bulunamadı');
                    return
                }

                // Modalı aç
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });
    }

    // Modal kapatma olayı
    if(modalCloseBtn){
        modalCloseBtn.addEventListener('click', () => {
            // Modalı kapat
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    }

    // Modal dışına tıklama olayı
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            // Modalı kapat
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });



    if($('.select2').length){
        $('.select2').select2();
    }




      let steps = 1;
      const prevBtn = $('.prevBtn');
      const nextBtn = $('.nextBtn');

      $('.stepsBtn').on('click', function(){
          // İlerleme adımını ayarla
          if ($(this).hasClass('nextBtn')) {
              steps++;
          } else if ($(this).hasClass('prevBtn')) {
              steps--;
          }

          // İlk adımda geri düğmesini devre dışı bırak
          if (steps === 1) {
              prevBtn.attr('disabled', true);
          } else {
              prevBtn.attr('disabled', false);
          }

          // Son adımda ileri düğmesini devre dışı bırak
          if (steps === 3) {
              nextBtn.attr('disabled', true);
          } else {
              nextBtn.attr('disabled', false);
          }

          // Tüm adımların içeriğini gizle
          $('.stepContent').removeClass('block').addClass('hidden');
          $('.step').removeClass('bg-blue-500 text-white').addClass('bg-gray-200');

          // İlgili adımın içeriğini göster
          $('#content' + steps).removeClass('hidden').addClass('block');

          $('#step' + steps).removeClass('bg-gray-200').addClass('bg-blue-500 text-white');

      });




      $('.toggleMenu').on('click', function(){
        const th = $(this);
        if(th.next('ul').hasClass('block')){
            $(this).next('ul').removeClass('block').addClass('hidden');
        }else{
            $('.toggleMenu ul').removeClass('block').addClass('hidden');
            $(this).next('ul').removeClass('hidden').addClass('block');
        }
        return false;
      })



      const emailInput = `<label for="approve_email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email</label>
      <div class="mt-2">
          <input id="approve_email" name="approve_email" type="email" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" />
      </div>`;

      const linkInput = `<label for="approve_link" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Bağlantı URL</label>
      <div class="mt-2">
          <input id="approve_link" name="approve_link" type="url" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" />
      </div>`;


      $('#approve_type').on('change', function(){
        const thv = $(this).val();
        if(thv == 0){
            $('#connect_type_input').html(emailInput);
        }else{

            $('#connect_type_input').html(linkInput);
        }
      })

      $('.isdelete').on('click', function(){
            if(!confirm('İşleme devam etmek istediğinize emin misiniz?')){
                return false;
            }
      });

      $(".phone").inputmask({"mask": "(999) 999-9999"});

      if( $('.content').length ){
        


        CKEDITOR.replaceClass = "editor";
        CKEDITOR.config.versionCheck = false;
        
        
        $('.content').each(function(){
            CKEDITOR.replace($(this)[0]);
        })
      }

  

      if( $('.select2ajax').length ){

        $('.select2ajax').select2({
            minimumInputLength: 3,
            delay: 350,
            cache: true,
            ajax: {
                url: function () {
                    var element = $(this);
                    var dataUrl = element.attr('data-url');
                    return '/api/' + dataUrl;
                },
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (data) {
                    var dataParse = $.map(data.items, function (obj) {
                        return {
                            id: obj.id,
                            text: obj.name
                        }
                    });
                    return {
                        results: dataParse
                    }
                }
            }
        });


    }



    
    if( $('.select2city').length ){


        $('.select2city').select2({
            minimumInputLength: 2,
            delay: 350,
            cache: true,
            ajax: {
                url: function (params) {
                    return '/api/citysearch/' + $('#country_id').val()
                },
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (data) {
                    var dataParse = $.map(data.items, function (obj) {
                        return {
                            id: obj.id,
                            text: obj.name
                        }
                    });
                    return {
                        results: dataParse
                    }
                }
            },
        })

    }


});
