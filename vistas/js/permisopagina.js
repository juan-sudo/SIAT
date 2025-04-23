class PermisoPagina {
    constructor() {
    this.Idusuario=0;      
    }

  lista_pagina(idusuario) {
    let datos_usuario = new FormData();
    datos_usuario.append("idusuario",idusuario);
    datos_usuario.append("usuario_permiso","usuario_permiso");
    $.ajax({
      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos_usuario,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        $(".usuario_permiso").html(respuesta['nombre']);
        $(".dni_permiso").html(respuesta['dni']);
      }

    })
    let datos = new FormData();
    datos.append("lista_pagina","lista_pagina");
    datos.append("idusuario",idusuario);
    $.ajax({
      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        $(".permiso_pagina").html(respuesta);
        function actualizarSubpaginas(idPagina, marcar) {
          const subpaginas = document.querySelectorAll(`li[id_pagina="${idPagina}"] li input[name="permisos[]"]`);
          subpaginas.forEach(subpagina => {
            subpagina.checked = marcar;
          });
        }
        // Obtener todos los checkboxes
        const checkboxes = document.querySelectorAll('input[name="permisos[]"]');
        checkboxes.forEach(checkbox => {
          checkbox.addEventListener('change', function() {
            const idPagina = this.closest('li').getAttribute('id_pagina');
            const idSubpagina = this.closest('li').getAttribute('id_subpagina');
        
            if (idPagina) {
              // Si es una página, marcar o desmarcar todas las subpáginas
              actualizarSubpaginas(idPagina, this.checked);
            } else if (idSubpagina) {
              // Si es una subpágina, verificar si todas las subpáginas están marcadas y actualizar la página principal
              const paginaCheckbox = this.closest('ul').closest('li').querySelector('input[name="permisos[]"]');
              const subpaginas = this.closest('ul').querySelectorAll(`li[id_pagina="${paginaCheckbox.getAttribute('id_pagina')}"] li input[name="permisos[]"]:checked`);
        
              // Marcar la página solo si todas las subpáginas están marcadas
              paginaCheckbox.checked = subpaginas.length === this.closest('ul').querySelectorAll(`li[id_pagina="${paginaCheckbox.getAttribute('id_pagina')}"] li input[name="permisos[]"]`).length;
            }
          });
        });
      }

    })
  } 
  guardarValores() {
    const idPaginaArray = [];
    const idSubpaginaArray = [];

    const checkboxes = document.querySelectorAll('input[name="permisos[]"]:checked');

    checkboxes.forEach(checkbox => {
      const idPagina = checkbox.closest('li').getAttribute('id_pagina');
      const idSubpagina = checkbox.closest('li').getAttribute('id_subpagina');

      if (idPagina) {
        idPaginaArray.push(idPagina);
      }
      if (idSubpagina) {
        idSubpaginaArray.push(idSubpagina);
      }
    });
    // Puedes hacer lo que quieras con los arrays aquí, por ejemplo, imprimirlos en la consola
    console.log('ID_Pagina Array:', idPaginaArray);
    console.log('ID_Subpagina Array:', idSubpaginaArray);
    console.log('usuario:',this.Idusuario);
    var idPaginaArray_c = idPaginaArray.map(function(valor) {
      return parseInt(valor, 10); // parseInt convierte una cadena a un número
    });
    console.log('ID_Pagina Array:', idPaginaArray_c);
    let datos = new FormData();
    datos.append("idpagina",JSON.stringify(idPaginaArray));
    datos.append("idsubpagina",JSON.stringify(idSubpaginaArray));
    datos.append("idusuario",this.Idusuario);
    datos.append("permiso_pagina","permiso_pagina");
    $.ajax({
      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta.tipo === "correcto") {
          $("#modalPermiso").modal("hide");
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 5000);
          
        }
        else{
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 4000);
        }
      }   
    })
  }
  
}
//fin de la clase y constructor
const permisopagina = new PermisoPagina();

  //obteniendo el valor pasado por get deesde lista de contribuyente caja - a caja 
  document.addEventListener('DOMContentLoaded', function () {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var Id = urlParams.get('id');
    caja.idContribuyente_caja=Id;
    caja.estadoCuenta(Id);
    caja.n_recibo();
    //caja.tipo_papel();
    console.log(caja.idContribuyente_caja);
  })

//Mostrar el Pop up para confirma si pagar o no
$(document).on("click", ".btnPermiso", function () {
     permisopagina.Idusuario = $(this).attr("IdUsuario");
     console.log("id usuario:"+permisopagina.Idusuario)
     permisopagina.lista_pagina(permisopagina.Idusuario);
    $('#modalPagar_si_no').modal('show');    
});
//Guardar los valores 
$(document).on("click", ".guardar_permisos", function () {
         permisopagina.guardarValores();
     });

