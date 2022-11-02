$().ready(function () {
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
    var value = $(this).val();

    console.log(value);
    var urlo =
      "https://www.resto123.com/wp-content/plugins/Api_Techsysprogram/data/ws_table_ventas.php?idt=" +
      value;
    console.log(urlo);
    // window.location = url;
    $.ajax({
      type: "POST",
      url: urlo,
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

  $("#btnCompra").click(function () {
    console.log("hizo click");
    var cases = document.getElementsByClassName("form-select");
    let resultat = "";
    for (var i = 0; i < cases.length; i++) {
      resultat += cases[i].value + ",";
    }
    console.log(resultat);
    $("#Compra2").html("vous allez activer les planches " + resultat);
  });

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
