$(document).ready(function () {
  // Lắng nghe sự kiện nhập liệu trong ô tìm kiếm
  $('#search-box').on('input', function () {
    let query = $(this).val().trim();

    if (query.length > 0) {
        $.ajax({
            url: 'models/fetch_product.php',
            type: 'POST',
            data: { search: query },
            dataType: 'json', // Định dạng phản hồi JSON
            success: function (response) {
                console.log('Products fetched:', response);
                if (response.status === 'success') {
                    let suggestions = '';
                    response.data.forEach(product => {
                        suggestions += `
                            <li>
                                <a href="#" class="dropdown-item">
                                    ${product.name.trim()} <!-- Loại bỏ khoảng trắng khi tạo HTML -->
                                </a>
                            </li>`;
                    });
                    $('#suggestions').html(suggestions).show(); // Hiển thị HTML
                } else if (response.status === 'no_results') {
                    $('#suggestions').html('<li class="dropdown-item">No products found</li>').show();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching products:', error);
                $('#suggestions').hide();
            }
        });
    } else {
        $('#suggestions').hide();
    }
});



  // Ẩn dropdown khi người dùng click bên ngoài
  $(document).on('click', function (e) {
      if (!$(e.target).closest('#search-box, #suggestions').length) {
          $('#suggestions').hide();
      }
  });

  // Khi click vào một item trong dropdown
  $(document).on('click', '.dropdown-item', function () {
    let productName = $(this).text().trim(); // Loại bỏ khoảng trắng dư
    console.log('Product selected:', productName);
    $('#search-box').val(productName); // Điền sản phẩm đã chọn vào ô tìm kiếm
    $('#suggestions').hide(); // Ẩn dropdown
});
});
