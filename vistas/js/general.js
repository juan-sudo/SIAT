class General {
  constructor() {
    this.iso_usuario = null;
    this.iso_area = null;
    this.predio_propietario=null;
    this.parametro=null;
    this.init_envio=null;
    this.anio_valor=null;
  }

  
   mostrarAlerta(tipo, titulo, mensaje, opciones = {}) {
    // Asegurar que el estilo se aplique solo una vez
    if (!document.getElementById("swal2-custom-style")) {
        const style = document.createElement("style");
        style.id = "swal2-custom-style";
        style.textContent = `
            .swal2-container {
                z-index: 20000 !important;
            }
        `;
        document.head.appendChild(style);
    }

    Swal.fire({
        icon: tipo, // "success" o "error"
        title: titulo,
        text: mensaje,
        showConfirmButton: true, // Muestra el botón "OK"
        confirmButtonText: "OK",
        timer: tipo === "success" ? 20000 : null // Solo aplica timer en caso de éxito
    }).then(() => {
        // Si hay una redirección, se ejecuta
        if (opciones.redireccion) {
            window.location.href = opciones.redireccion;
        }

        // Si hay un formulario para limpiar, se limpia
        if (opciones.limpiarFormulario) {
            document.getElementById(opciones.limpiarFormulario).reset();
        }

        // Si hay una función personalizada, se ejecuta
        if (opciones.callback && typeof opciones.callback === "function") {
            opciones.callback();
        }
    });
}

  predio_propietario_f(idContribuyente_pc,parametro_b,init_envio,anio) {
       
        $.ajax({
          url: "ajax/contribuyente.ajax.php",
          method: "POST",
          data: {
            idContribuyente_pc: idContribuyente_pc,
            parametro_b: parametro_b,
            init_envio:init_envio,
            anio:anio,
            predio_propietario:"predio_propietario",
          },
          beforeSend: function() {
            $(".m_predio_propietario").html(loadingMessage);
          },
          success: function (data) {
            $(".m_predio_propietario").html(data);
          
          },
          error: function() {
            $(".m_predio_propietario").html(errordata);
          }
        });   
  }
  anio_propietario(propietario,anio){

    $.ajax({
      url: "ajax/contribuyente.ajax.php",
      method: "POST",
      data: {
        idContribuyente_pc: propietario,
        parametro_b: this.parametro,
        init_envio:this.init_envio,
        anio:anio,
        predio_propietario:"anio_pro",
      },
      beforeSend: function() {
        $(".m_predio_propietario").html(loadingMessage);
      },
      success: function (data) {
        $(".m_predio_propietario").html(data);
      
      },
      error: function() {
        $(".m_predio_propietario").html(errordata);
      }
    });   
  }
}
const general = new General();
$(document).ready(function(){
   
    // Mostrar la alerta cuando se haga clic en el contenedor
    $("#respuestaAjax_srm").on("click", function() {
      $(this).hide(); // Oculta el div al hacer clic en él
    });
    general.iso_usuario = $('#mySpan_user').attr('iso_usuario');
    console.log("valor del iso capturado desde general:"+general.iso_usuario);
    general.iso_area = $('#mySpan_area').attr('iso_area');
    console.log("valor del iso capturado desde general:"+general.iso_area);
   
    //Modal de propietario . predio
      //Modal Propie 
      $(document).on("click", "#predio_propietario", function () {
        general.predio_propietario = $(this).attr("idContribuyente_predio_propietario");
        general.anio_valor =new Date().getFullYear();
        general.parametro = $(this).attr("parametro_b");
        general.init_envio = $(this).attr("init_envio");
        // console.log("predio_propietario."+general.predio_propietario);
        general.predio_propietario_f(general.predio_propietario,general.parametro,general.init_envio,general.anio_valor);
        $("#modal_predio_propietario").modal("show");
        console.log("anio propietario:"+general.predio_propietario);
        console.log("anio:"+general.anio_valor);
      });

      $(document).on("dblclick", "#tr_id_contribuyente", function () {
        general.predio_propietario = $(this).attr("idContribuyente_predio_propietario");
        general.anio_valor = new Date().getFullYear();
        general.parametro = $(this).attr("parametro_b");
        general.init_envio = $(this).attr("init_envio");
        // console.log("predio_propietario."+general.predio_propietario);
        general.predio_propietario_f(general.predio_propietario, general.parametro, general.init_envio, general.anio_valor);
        $("#modal_predio_propietario").modal("show");
        console.log("anio propietario:" + general.predio_propietario);
        console.log("anio:" + general.anio_valor);
    });


      $(document).on("change", "#anio_propietario", function () {
        general.anio_valor = $(this).find('option:selected').text();
        general.predio_propietario_f(general.predio_propietario,general.parametro,general.init_envio,general.anio_valor);
        console.log("anio propietario:"+general.predio_propietario);
        console.log("anio :"+ general.anio_propietario);
      });

  });

  let loadingMessage = `
  <tr>
    <td colspan="10" class="text-center"> 
      <div class="load-6 form-group pull-center">
        <div class="l-1 letter">C</div>
        <div class="l-2 letter">a</div>
        <div class="l-3 letter">r</div>
        <div class="l-4 letter">g</div>
        <div class="l-5 letter">a</div>
        <div class="l-6 letter">n</div>
        <div class="l-7 letter">d</div>
        <div class="l-8 letter">o</div>
        <div class="l-9 letter">.</div>
        <div class="l-10 letter">.</div>
        <div class="l-11 letter">.</div>
      </div>
    </td>
  </tr>`;

  let loadingMessage_s = `
  
      <div class="load-6 form-group pull-center">
        <div class="l-1 letter">C</div>
        <div class="l-2 letter">a</div>
        <div class="l-3 letter">r</div>
        <div class="l-4 letter">g</div>
        <div class="l-5 letter">a</div>
        <div class="l-6 letter">n</div>
        <div class="l-7 letter">d</div>
        <div class="l-8 letter">o</div>
        <div class="l-9 letter">.</div>
        <div class="l-10 letter">.</div>
        <div class="l-11 letter">.</div>
      </div>
 `;

  let errordata=`
  <tr>
    <td colspan="8" class="text-center">Error al cargar data</td>
  </tr>
`;

//filtro de las tablas
function searchTable(proveido) {
  const input = document.getElementById("searchInput");
  const filter = input.value.toLowerCase();
  let table = null;
  
  if (proveido === 'proveido') {
      table = document.getElementById("tbListaEspeciesV");
  }
  if (proveido === 'clasificador') {
    table = document.getElementById("tbclasificador");
  }
  if (proveido === 'especie_valorada') {
    table = document.getElementById("tbespecie_valorada");
  }
  // Agrega más condiciones aquí si tienes más tablas
  
  if (table) {
      const trs = table.getElementsByTagName("tr");

      for (let i = 1; i < trs.length; i++) {
          const tds = trs[i].getElementsByTagName("td");
          let match = false;

          for (let j = 0; j < tds.length; j++) {
              if (tds[j]) {
                  const textValue = tds[j].textContent || tds[j].innerText;
                  if (textValue.toLowerCase().indexOf(filter) > -1) {
                      match = true;
                      break;
                  }
              }
          }

          if (match) {
              trs[i].classList.remove("hide");
          } else {
              trs[i].classList.add("hide");
          }
      }
  }
}


