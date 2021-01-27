


var nom_acc = $("#auth_bienv_nom").text().trim().toLowerCase();


(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
});


$("#telefono_dir_val").keypress(function(){
    if (this.value.length > this.maxLength)
    this.value = this.value.slice(0, this.maxLength);
});

$("#cp_dir_val").keypress(function(){
    if (this.value.length > this.maxLength)
    this.value = this.value.slice(0, this.maxLength);
});

$("#newDIR").click(function(){
    $(".Dom-entrega").show();
    $("#boton_dom_cancel").show();
    $("#div_agg_dom").hide();
    $("#nombre_dir").val('');
});

function limpia_campos(){
    $("#nombre_dir_val").val('');
    $("#nombre_dir_val").val('');
    $("#paterno_dir_val").val('');
    $("#materno_dir_val").val('');
    $("#telefono_dir_val").val('');
    $("#calle_dir_val").val('');
    $("#num_ext_dir_val").val('');
    $("#num_int_dir_val").val('');
    $("#cp_dir_val").val('');
    $("#entre_calle1_dir_val").val('');
    $("#entre_calle2_dir_val").val('');
    $("#inp_col_search").val('');
    $("#referencias_dir_val").val('');
}
