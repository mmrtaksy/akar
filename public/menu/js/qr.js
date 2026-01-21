$(document).ready(function () {
    const loadedMenus = new Set();
    
    const lang = $('#lang').val();

    const plusIcon = () => `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
        </svg>`;

    const minusIcon = () => `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
        </svg>`;

    const menuScroll = (target) => {
        setTimeout(() => {
            if (target.length) {
                target[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 500);
    };

    const createProductCard = (menu) => {
        return `
            <div class="bg-gray-50 rounded shadow cursor-pointer product-item" 
                 data-title="${menu.title}" 
                 id="menu-item-${menu.id}" 
                 data-id="${menu.id}" 
                 data-category-id="${menu.category_id}" 
                 data-description="${menu.description || ''}" 
                 data-image="${menu.image}" 
                 data-price="${menu.price}">
                <img src="${menu.image}" alt="${menu.title}" class="w-full rounded">
                <div class="content p-2">
                    <h3 class="mt-2 font-semibold">${menu.title}</h3>
                    <p class="text-gray-600">${menu.price}</p>
                </div>
            </div>`;
    };

    function loadMenuChildren(id, callback = () => { }) {
        const $container = $(`#category-${id}`);
        const $icon = $(`#icon-${id}`);
        const $target = $(`#menu-block-${id}`);

        if ($container.hasClass('active')) {
            $container.removeClass('active');
            $icon.html(plusIcon());
            return;
        }

        $('.menu-content').removeClass('active');
        $('[id^="icon-"]').html(plusIcon());

        if (loadedMenus.has(id)) {
            $container.addClass('active');
            $icon.html(minusIcon());
            menuScroll($target);
            callback();
            return;
        }

        

        $.getJSON(`/menu-children/${id}?lang=${lang}`, function (res) {
            $container.empty();


            res.data.forEach(menu => {
                $container.append(createProductCard(menu));
            });


            $container.addClass('active');
            loadedMenus.add(id);
            $icon.html(minusIcon());
            menuScroll($target);
            callback(); // 👈 burada çağrılıyor
        }).fail(function (err) {
            console.error('Veri çekilemedi:', err);
        });
    }


    // Ürün tıklanınca detay modalı aç
    $(document).on('click', '.product-item', function () {
        const title = $(this).data('title');
        const price = $(this).data('price');
        const description = $(this).data('description');
        const image = $(this).data('image');

        $('#productModalContent').html(`
            <img src="${image}" class="w-full h-auto" />
            <div class="p-3">
                <h2 class="text-xl font-bold mb-2 flex justify-between gap-3"> <span>${title}</span> <p class="text-gray-700">${price}</p></h2>
                <p class="text-gray-700">${description}</p> 
            </div>
        `);

        $('#productModal').fadeIn(300);
    });

    $('#productModal').on('click', function () {
        $('#productModal').fadeOut(300);
    });

    // Arama butonuna tıklanınca arama modalını aç
    $('#openSearchModal').on('click', function () {
        $('#searchModal').fadeIn(300);
    });

    $('#closeSearchModal').on('click', function () {
        $('#searchModal').fadeOut(300);
    });

    // Arama fonksiyonu
    $('#searchInput').on('input', function () {
        const keyword = $(this).val().trim().toLowerCase();
        if (!keyword) {
            $('#searchResults').html('');
            return;
        }


        $.ajax({
            url: `/menu-search?lang=${lang}`,
            method: 'GET',
            data: { q: keyword },
            success: function (res) {
                let results = '';
                if (res.length > 0) {
                    res.forEach(item => {
                        results += `<li class="cursor-pointer hover:text-blue-600 transition"
                                       data-category-id="${item.parent_id}" 
                                       data-item-id="${item.id}">
                                       ${item.name}
                                   </li>`;
                    });
                } else {
                    results = '<li class="text-gray-500">Sonuç bulunamadı.</li>';
                }
                $('#searchResults').html(results);
            }
        });
    });

    // Arama sonucu tıklanınca scroll ve efekt
    $(document).on('click', '#searchResults li', function () {
        const categoryId = $(this).data('category-id');
        const itemId = $(this).data('item-id');

        $('#searchModal').fadeOut(300);

        setTimeout(() => {
            loadMenuChildren(categoryId);

            setTimeout(() => {
                const $el = $(`#menu-item-${itemId}`).find('.content');
                if ($el.length) {
                    $el.css('background-color', '#f9ff00');
                    setTimeout(() => $el.css('background-color', '#fff'), 2000);
                }
            }, 1000);
        }, 500);
    });

    $(document).on('click', '.load-category', function () {
        const id = $(this).data('id');
        loadMenuChildren(id);
    });

});
