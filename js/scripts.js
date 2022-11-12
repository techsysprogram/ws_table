$().ready(function () {
  const $url_ws =
    "https://www.resto123.com/wp-content/plugins/Api_Techsysprogram/data";
  const btn01 = document.querySelector("#btnradio1");
  const btn02 = document.querySelector("#btnradio2");

  const btn05 = document.querySelector("#btnStock");

  let Mi_IDO = ""; //aqui se guarda el id organisateur e id tirage para no pasar varias veces

  // btn05.textContent = "hola";
  //aqui lo que hago es mostrar la tabla segun donde este seleccionado mas a delante sera mas inteligente
  Affiche_table(2);

  $("select[name=tech_select_tirage]").change(function () {
    Affiche_table(Select_nuevo_activar());
    // console.log(this.value);
  });

  // $("select[name=tech_form-select0]").change(function () {
  //   console.log(this.value);
  // });

  // tech_selection.change(function () {
  //   console.log(tech_selection);
  // });

  btn01.onclick = () => {
    Affiche_table(1);
  };

  btn02.onclick = () => {
    Affiche_table(2);
  };

  //seleccion de los tirages
  btn05.onclick = () => {
    Api_woocommerce(1);
  };

  //ensures the page is loaded before functions are executed.
  // window.onload = function () {}

  // window.addEventListener(
  //   "load",
  //   function () {
  //     alert("hello!");
  //   },
  //   false
  // );

  // window.ready(
  //   "load",
  //   function () {
  //     alert("hello!");
  //   }
  // );

  btn07.onclick = () => {
    $("#Compra2").html("planches :" + tech_mostrar());
  };

  //aqui muestro lo que se guarda en local
  function tech_mostrar() {
    //mostrar las planches seleccionadas segun nueva compra o activar
    var string_activar = "";
    var resultat = "";
    var lo = "";

    if (Mi_IDO == "") {
      Mi_IDO = Tirage_actif();
    }

    if (Select_nuevo_activar() == 1) {
      //nuevo poner cantidad
      string_activar = window.localStorage.getItem("nuevo " + Mi_IDO);
      var array_planches = string_activar.split(":");
      // console.log("estoy aqui en nuevo : " + array_planches);
      var s_cases = document.getElementsByClassName("form-select");
      var str_s_case = "";
      // console.log(s_cases);
      var i2 = 0;
      for (var i = 1; i < s_cases.length; i++) {
        str_s_case = s_cases[i].value;
        if (
          string_activar.includes(
            str_s_case.substring(0, str_s_case.length - 3)
          )
        ) {
          lo = array_planches[i2];
          if (lo != "") {
            s_cases[i].value = array_planches[i2];
          }
          resultat = resultat + array_planches[i2] + ":";
          i2++;
        }
      }
    } else if (Select_nuevo_activar() == 2) {
      //check value
      string_activar = window.localStorage.getItem("activar " + Mi_IDO);
      // var array_planches = string_activar.split(",");
      // console.log("estoy aqui en activar : " + array_planches);
      var s_cases = document.getElementsByClassName("form-check-input");
      for (var i = 0; i < s_cases.length; i++) {
        if (string_activar.includes(s_cases[i].value)) {
          s_cases[i].checked = true;
          resultat = resultat + s_cases[i].value + ":";
        }
      }
    }

    return resultat;
  }

  // ici je donne l'id organisateur et id tirage actuel donde me encuentro
  function Tirage_actif() {
    console.log("pase aqui en tirage_actif");
    var parts = window.location.search.substr(1).split("&");
    var $_GET = {};
    for (var i = 0; i < parts.length; i++) {
      var temp = parts[i].split("=");
      $_GET[decodeURIComponent(temp[0])] = temp[1];
    }
    var tech_org = $_GET["ido"];
    if (tech_org === undefined) {
      tech_org = "9905";
    }
    var cases = document.getElementsByClassName("form-select");
    // console.log(tech_org + " " + cases[0].value);
    // Mi_var = tech_org + " " + cases[0].value;
    return tech_org + " " + cases[0].value;
  }

  function Select_nuevo_activar() {
    var radios = document.getElementsByName("btnradio");
    var Radio_select = "";
    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) {
        //console.log(radios[i].id);
        Radio_select = radios[i].id;
        break; //sortir
      }
    }
    if (Radio_select === "btnradio1") {
      //nuevas
      return 1;
    } else if (Radio_select === "btnradio2") {
      return 2;
    }
  }

  // Function to compute the product of p1 and p2
  function Affiche_table(index) {
    //con el selector es importante siempre actualizar sin importar que ya tiene dato
    Mi_IDO = Tirage_actif();
    switch (index) {
      case 1:
        // window.location = url;
        $.ajax({
          type: "POST",
          url: $url_ws + "/ws_table_ventas.php?ido=" + Mi_IDO,
          async: true,
          success: function (response) {
            // console.log(response);
            $("#tech_id_table").html(response);
            $("#Compra2").html(`${tech_mostrar()}`);
          },
        });
        break;

      case 2:
        $.ajax({
          type: "POST",
          url: $url_ws + "/ws_table_actif.php?ido=" + Mi_IDO,
          async: true,
          success: function (response) {
            // console.log(response);
            $("#tech_id_table").html(response);
            $("#Compra2").html(`${tech_mostrar()}`);
          },
        });
        break;

      default:
      // code block
    }
  }

  function Api_woocommerce(index) {
    if (Mi_IDO == "") {
      Mi_IDO = Tirage_actif();
    }
    switch (index) {
      case 1:
        // ici j'appel un webservice pour creer un nouveau produit;
        $.ajax({
          type: "POST",
          url:
            $url_ws +
            "/ws_woocommerce.php?dp=" +
            "productossss|" +
            "esto es la description de mi producto|" +
            Mi_IDO +
            "|" +
            "2.5|",
          async: true,
          success: function (response) {
            // console.log(response);
            $("#Compra2").html(response);
          },
        });
        break;

      case 2:

      default:
      // code block
    }

    // return p1 * p2;
  }
});

// $("#btn-group").click(function () {
//   var radios = document.getElementsByName("btnradio");

//   for (var i = 0; i < radios.length; i++) {
//     if (radios[i].checked) {
//       console.log(radios[i].value);
//       break;
//     }
//   }
// });

// aqui segun el nombre del objeto aqui le dare un accion al hacer click
// document.getElementById("carForm").onsubmit = store
// document.getElementById("clearButton").onclick = clearStorage
// document.getElementById("removeButton").onclick = removeItem
// document.getElementById("retrieveButton").onclick = retrieveRecords

// fetch(url)
//   .then(function (response) {
//     console.log(response.html);
//   })
//   .then(function (body) {
//     console.log(body);
//   });

// let response = fetch(url);

// console.log(response);

// if (response.ok) {
//   // if HTTP-status is 200-299
//   // get the response body (the method explained below)
//   console.log(response);
// } else {
//   alert("HTTP-Error: " + response.status);
// }

// $("#btnGerer").click(() => {
//   console.log("hizo click");
//   var cases = document.getElementsByClassName("form-check-input");
//   var resultat = "";
//   for (var i = 0; i < cases.length; i++) {
//     if (cases[i].checked) {
//       resultat += cases[i].value + ",";
//     } else {
//       //cases[i].checked = true;
//     }
//   }
//   //console.log(resultat);
//   $("#Gerer").html("vous allez activer les planches " + resultat);
// });

//var checkboxes2 = document.getElementsByClassName("table table-hover");

// for (i = 0; checkboxes2.length; i++) {
//   // boucle for //
//   var checkboxes = checkboxes2[i];
//   console.log(checkboxes);
//   //aqui le digo de poner en check el control
//   //checkboxes.checked = true;
// }

//console.log(checkboxes);
//aqui le digo de poner en check el control
//checkboxes.checked = true;

// for (var i = 0; i < checkboxes.length; i++) {
//   console.log(checkboxes);
//   //if (checkboxes[i].checked) {
//   console.log(checkboxes[i].checked);
//   //}
// }

//exemple// me recupera solo el primer valeur que es imput
// var elt = document.querySelector("input");
// console.log(elt);

// $("#flexCheckDefault").click(function () {
//   $("#answer2").html("te vi hiscistes click aqui ojito 55555");
//   console.log("hizo click en el checkk");
// });

// var selectValue =
//   document.getElementById("id_Select").options[
//     document.getElementById("id_Select").selectedIndex
//   ].value;
// select = document.getElementById("id_Select");
// choice = select.selectedIndex;
// valeur = select.options[choice].value;
// texte = select.options[choice].text;
// console.log(valeur);
//   $("#btnanswer").click(function () {
//     console.log("hizo click222");
//     var cases = document.getElementsByClassName("form-check-input");
//     var resultat = "";
//     for (var i = 0; i < cases.length; i++) {
//       if (cases[i].checked) {
//         resultat += cases[i].value + ",";
//       } else {
//         //cases[i].checked = true;
//       }
//     }
//     //console.log(resultat);
//     $("#answer").html("vous allez activer les planches " + resultat);
//   });

// $("#selectId>option").click(function () {
// $("select[name=watwiljedoen]").change(function () {
//   // console.log("selectiono");
//   window.location =
//     "https://www.ma-conciergerie.techsysprogram.com/page-test?idt=" +
//     this.value;
//   // alert(this.value);
// });

// Get the size of the entire webpage
// const pageWidth = document.documentElement.scrollWidth;
// const pageHeight = document.documentElement.scrollHeight;

// console.log(pageWidth);
