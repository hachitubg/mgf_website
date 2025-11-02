jQuery(document).ready(function(){
    /**
     * Call price list by Ajax
     * @desc GET DATA PRICE LIST UPDATE ON TABLE
     */
    initPriceListByType('#home-tab-4');
    initPriceListByType('#home-tab-5');

    function initPriceListByType(selector) {
        let url = $("#price-list").data('href');
        let type = $(selector).data('type');
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                type: type,
            },
            beforeSend: function () {
                $(`${selector} .table-wrapper`).addClass('skeleton-holder')
            },
            success: function (data) {
                const response = JSON.parse(data)
                $(`${selector}`).replaceWith(response.html)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Lỗi khi gửi yêu cầu AJAX: " + textStatus, errorThrown);
            },
            complete: function () {
                // console.log("Hoàn thành yêu cầu AJAX.");
            }
        });
    }
});