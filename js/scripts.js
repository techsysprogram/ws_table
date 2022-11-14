$().ready(function () {
  const $url_ws =
    "https://www.resto123.com/wp-content/plugins/Api_Techsysprogram/data";
  const $url_TechAPI = "http://boulier.techsysprogram.fr/TechAPI";
  const btn01 = document.querySelector("#btnradio1");
  const btn02 = document.querySelector("#btnradio2");
  const btn05 = document.querySelector("#btnStock");
  const btn06 = document.querySelector("#btnWoo");
  let var_json_control = "";

  let Mi_IDO = ""; //aqui se guarda el id organisateur e id tirage para no pasar varias veces

  //aqui lo que hago es mostrar la tabla segun donde este seleccionado mas a delante sera mas inteligente
  Affiche_table(2);

  $("select[name=tech_select_tirage]").change(function () {
    Affiche_table(Select_nuevo_activar());
    // console.log(this.value);
  });

  btn01.onclick = () => {
    Affiche_table(1);
  };

  btn02.onclick = () => {
    Affiche_table(2);
  };

  //seleccion de los tirages
  btn05.onclick = () => {
    Verifier_stock();
  };

  //seleccion de los tirages
  btn06.onclick = () => {
    Api_woocommerce(1);
  };

  //aqui muestro lo que se guarda en local
  function tech_mostrar(index) {
    //mostrar las planches seleccionadas segun nueva compra o activar
    var string_activar = "";
    var resultat = "";
    var val_qte = "";

    if (Mi_IDO == "") {
      Mi_IDO = Tirage_actif(1);
    }

    if (index == 1) {
      //nuevo poner cantidad
      string_activar = window.localStorage.getItem("nuevo " + Mi_IDO);
      if (string_activar == null) {
        return "null";
      }
      // console.log("estoy aqui en en nuevo : " + string_activar);
      var array_planches = string_activar.split(";");
      // console.log("estoy aqui en nuevo : " + array_planches);
      var s_cases = document.getElementsByClassName("form-select");
      var str_s_case = "";
      // console.log(s_cases);
      var i2 = 0;
      for (var i = 1; i < s_cases.length; i++) {
        str_s_case = s_cases[i].value;
        // console.log(str_s_case + " => " + str_s_case.substring(1));

        if (string_activar.includes(str_s_case.substring(1))) {
          val_qte = array_planches[i2];
          if (val_qte != "") {
            s_cases[i].value = val_qte;
          }
          i2++;
        }
      }
      // resultat = resultat.substring(0, resultat.length - 1);
      resultat = string_activar;
    } else if (index == 2) {
      //check value
      string_activar = window.localStorage.getItem("activar " + Mi_IDO);
      if (string_activar == null) {
        return "null";
      }
      // var array_planches = string_activar.split(",");
      // console.log("estoy aqui en activar : " + string_activar);
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
  function Tirage_actif(ID_O) {
    // console.log("pase aqui en tirage_actif");
    var cases = document.getElementsByClassName("form-select");
    //ID_O= 1 devuelvo los IdOrg - IDtirage
    switch (ID_O) {
      case 1:
        var str_case = cases[0].value.split(" ").join("");
        break;
      case 2: //aqui te muestro el id organisateur
        var str_case = cases[0].value.split(" ").join("");
        cases = str_case.split("-");
        str_case = cases[0];
        break;
      default:
      // code block
    }
    return str_case;
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
    Mi_IDO = Tirage_actif(1);
    switch (index) {
      case 1:
        // window.location = url;
        $.ajax({
          type: "POST",
          url: $url_ws + "/ws_table_ventas.php?ido=" + Mi_IDO + "-0",
          async: true,
          success: function (response) {
            // console.log(response);
            $("#tech_id_table").html(response);
            $("#Compra2").html(tech_mostrar(1));
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
            $("#Compra2").html(tech_mostrar(2));
          },
        });
        break;

      default:
      // code block
    }
  }

  // Function to compute the product of p1 and p2
  function Verifier_stock() {
    //con el selector es importante siempre actualizar sin importar que ya tiene dato
    // console.log(Mi_IDO);
    // return false;
    // window.location = url;

    if (Select_nuevo_activar() == 1) {
      var_json_control = tech_mostrar(1);

      $.ajax({
        type: "POST",
        url:
          $url_ws +
          "/ws_table_ventas.php?ido=" +
          Mi_IDO +
          "-" +
          var_json_control,
        async: true,
        success: function (response) {
          // console.log(response);
          $("#tech_id_table").html(response);
          $("#Compra2").html(tech_mostrar(1)); //no lo quites es importante o solo llama tech_mostrar(1)
        },
      });
    }
  }

  function Api_woocommerce(index) {
    if (Mi_IDO == "") {
      Mi_IDO = Tirage_actif(1);
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
