$('#search-form').on('submit', function (e) {
    xTable.draw();
    e.preventDefault();
    //return false;
    //$('#filter').modal('hide');

    //if this function active, when you click pagination data back to normal without filtering 
    /*$('#filter').on('hidden.bs.modal', function (e) {
        $(this)
            .find("input,textarea")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
            $(".selectpicker").val(['']).trigger("change");
    });*/
});