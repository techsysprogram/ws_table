$().ready(function () {
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
  const btn01 = document.querySelector("#btnradio1");
  const btn02 = document.querySelector("#btnradio2");
  const btn03 = document.querySelector("#watwiljedoen");
  const btn05 = document.querySelector("#btnCompra");

  btn05.onclick = () => {
    var cases = document.getElementsByClassName("form-select");
    let resultat = "";
    for (var i = 0; i < cases.length; i++) {
      resultat += cases[i].value + ",";
    }
    // console.log(resultat);
    $("#Compra2").html("vous allez activer les planches " + resultat);
  };

  btn01.onclick = () => {
    var radios = document.getElementsByName("btnradio");

    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) {
        console.log(radios[i].value);
        // break;
      }
    }

    // alert(js.value);
  };

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

  $("select[name=watwiljedoen]").change(function () {
    //hide all extra lists
    //$('.hide').hide();
    //get current value
    console.log(Object.values("#watwiljedoen"));

    var value = $(this).val();
    // window.location = url;
    $.ajax({
      type: "POST",
      url:
        "https://www.resto123.com/wp-content/plugins/Api_Techsysprogram/data/ws_table_ventas.php?idt=" +
        value,
      async: true,
      success: function (response) {
        // console.log(response);
        $("#Compra").html(response);
      },
    });
  });

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
});

// Get the size of the entire webpage
// const pageWidth = document.documentElement.scrollWidth;
// const pageHeight = document.documentElement.scrollHeight;

// console.log(pageWidth);
