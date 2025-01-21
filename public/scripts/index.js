function ubah_format(field, nilai) {
    var mynumeral = numeral(nilai).format('0,0');
    if (field.includes('jumlah')) {
        mynumeral = numeral(nilai).format('0,0.0');
    }
    $("#" + field).val(mynumeral);
}
