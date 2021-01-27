(function() {
    window.sib = {
        equeue: [],
        client_key: "8t6n2ptq0f59fh2fgs581z9l"
    };
    /* OPTIONAL: email for identify request*/
    if($("#isUser").val() == 'true'){
        email = $("#isEmail").val();
    }else {
        email = 'contacto@muebleria-villarreal.com';
    }

    window.sib.email_id = email;
    window.sendinblue = {};
    for (var j = ['track', 'identify', 'trackLink', 'page'], i = 0; i < j.length; i++) {
    (function(k) {
        window.sendinblue[k] = function() {
            var arg = Array.prototype.slice.call(arguments);
            (window.sib[k] || function() {
                    var t = {};
                    t[k] = arg;
                    window.sib.equeue.push(t);
                })(arg[0], arg[1], arg[2]);
            };
        })(j[i]);
    }
    var n = document.createElement("script"),
        i = document.getElementsByTagName("script")[0];
    n.type = "text/javascript", n.id = "sendinblue-js", n.async = !0, n.src = "https://sibautomation.com/sa.js?key=" + window.sib.client_key, i.parentNode.insertBefore(n, i), window.sendinblue.page();
})();



function loginUsuario(email, id){
    // llamar datos de usuario auth
    sendinblue.identify(email, {
      'id': id,
    });

}

function compra_finalizada(){
    console.log('compra finalizada');
    sendinblue.track(
      'Checkout',
      {
        "nombre": "Prueba",
        "LASTNAME" : "Doe",
        "PLAN" : "Diamond",
        "LOCATION" : "San Francisco"
      },
      {
        "id": "a4123c72-c6f7-4d8e-b8cd-4abb8a807891",
        "nombre": 'n',
        "params": {
          "products": [
            {
              "id": 1234,
              "name": "a",
              "amount": 1,
              "price": 220
            },
            {
              "id": 5768,
              "name": "b",
              "amount": 5,
              "price": 1058
            }
          ]
        }
      },
    );
}
