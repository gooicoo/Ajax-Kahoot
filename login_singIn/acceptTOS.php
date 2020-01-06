<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["TOS"]) and isset($_POST["token"])) {
    session_start();
    $token = $_POST["token"];
    $_SESSION["alertMsg"] = "Gracias por aceptar los términos de servicio. Inicia sesión para acceder a tu cuenta.";
    $_SESSION["alertType"] = "success";
    if (strpos($token, ";") !== false) {
      $split = explode(";", $token);
      $token = $split[0];
      if ($split[1] == "PaymentDONE") {
        $_SESSION["alertMsg"] = "Tu pago se ha realizado correctamente. Inicia sesión para acceder a tu cuenta.";
      }
    }
    updateToken($token);
  }
  else if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["updateAcc"])) {
    updateToken($_POST["updateAcc"]);
    updateAccountType("FREE", $_POST["updateAcc"]);
    session_start();
    $_SESSION["alertMsg"] = "Gracias por aceptar los términos de servicio. Inicia sesión para acceder a tu cuenta.";
    $_SESSION["alertType"] = "success";
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET" and isset($_GET["token"])) {
    $token = $_GET["token"];
    if (!tokenExists($token)) {
      header("Location: .");
    }
    $type = getAccountType($token);
  } else {
    header("Location: .");
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Términos de Servicio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./CSS/acceptTOS.css">
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function(event) {
        var paymentDone = false;
        var form = document.getElementsByTagName("form")[0];
        form.onsubmit = function() {
          var tos = document.getElementsByName("TOS")[0];
          if (!tos.checked) {
            alert("Debes aceptar los términos de servicio para poder utilizar nuestra web.");
            return false;
          }
          var openModal = document.getElementById("openModal");
          if (openModal != null) {
            openModal.click();
            return false;
          }
          return true;
        };

        var free = document.getElementById("btnAccFree");
        free.onclick = function() {
          var form = document.getElementById("formAccFree");
          form.submit();
        };

        var pay = document.getElementById("payNow");
        pay.onclick = function() {
          paymentDone = true;
          var token = document.getElementsByName("token")[0];
          token.value += ";PaymentDONE";
          form.submit();
        };
      });
    </script>
  </head>
  <body>
    <div class="main p-3">
      <div class="article" id="content">
        <div>
          <div id="placeholders">
            <h1 style="text-align: center;">POLÍTICA DE PRIVACIDAD</h1>
            <p>&nbsp;</p>
            <p>El presente Política de Privacidad establece los términos en que Ajax-Kahoot usa y protege la información que es proporcionada por sus usuarios al momento de utilizar su sitio web. Esta compañía está comprometida con la seguridad de los datos de sus usuarios. Cuando le pedimos llenar los campos de información personal con la cual usted pueda ser identificado, lo hacemos asegurando que sólo se empleará de acuerdo con los términos de este documento. Sin embargo esta Política de Privacidad puede cambiar con el tiempo o ser actualizada por lo que le recomendamos y enfatizamos revisar continuamente esta página para asegurarse que está de acuerdo con dichos cambios.</p>
            <h2>Información que es recogida</h2>
            <p>Nuestro sitio web podrá recoger información personal por ejemplo: Nombre,&nbsp; información de contacto como&nbsp; su dirección de correo electrónica e información demográfica. Así mismo cuando sea necesario podrá ser requerida información específica para procesar algún pedido o realizar una entrega o facturación.</p>
            <h2>Uso de la información recogida</h2>
            <p>Nuestro sitio web emplea la información con el fin de proporcionar el mejor servicio posible, particularmente para mantener un registro de usuarios, de pedidos en caso que aplique, y mejorar nuestros productos y servicios. &nbsp;Es posible que sean enviados correos electrónicos periódicamente a través de nuestro sitio con ofertas especiales, nuevos productos y otra información publicitaria que consideremos relevante para usted o que pueda brindarle algún beneficio, estos correos electrónicos serán enviados a la dirección que usted proporcione y podrán ser cancelados en cualquier momento.</p>
            <p>Ajax-Kahoot está altamente comprometido para cumplir con el compromiso de mantener su información segura. Usamos los sistemas más avanzados y los actualizamos constantemente para asegurarnos que no exista ningún acceso no autorizado.</p>
            <h2>Cookies</h2>
            <p>Una cookie se refiere a un fichero que es enviado con la finalidad de solicitar permiso para almacenarse en su ordenador, al aceptar dicho fichero se crea y la cookie sirve entonces para tener información respecto al tráfico web, y también facilita las futuras visitas a una web recurrente. Otra función que tienen las cookies es que con ellas las web pueden reconocerte individualmente y por tanto brindarte el mejor servicio personalizado de su web.</p>
            <p>Nuestro sitio web emplea las cookies para poder identificar las páginas que son visitadas y su frecuencia. Esta información es empleada únicamente para análisis estadístico y después la información se elimina de forma permanente. Usted puede eliminar las cookies en cualquier momento desde su ordenador. Sin embargo las cookies ayudan a proporcionar un mejor servicio de los sitios web, estás no dan acceso a información de su ordenador ni de usted, a menos de que usted así lo quiera y la proporcione directamente. Usted puede aceptar o negar el uso de cookies, sin embargo la mayoría de navegadores aceptan cookies automáticamente pues sirve para tener un mejor servicio web. También usted puede cambiar la configuración de su ordenador para declinar las cookies. Si se declinan es posible que no pueda utilizar algunos de nuestros servicios.</p>
            <h2>Enlaces a Terceros</h2>
            <p>Este sitio web pudiera contener en laces a otros sitios que pudieran ser de su interés. Una vez que usted de clic en estos enlaces y abandone nuestra página, ya no tenemos control sobre al sitio al que es redirigido y por lo tanto no somos responsables de los términos o privacidad ni de la protección de sus datos en esos otros sitios terceros. Dichos sitios están sujetos a sus propias políticas de privacidad por lo cual es recomendable que los consulte para confirmar que usted está de acuerdo con estas.</p>
            <h2>Control de su información personal</h2>
            <p>En cualquier momento usted puede restringir la recopilación o el uso de la información personal que es proporcionada a nuestro sitio web.&nbsp; Cada vez que se le solicite rellenar un formulario, como el de alta de usuario, puede marcar o desmarcar la opción de recibir información por correo electrónico. &nbsp;En caso de que haya marcado la opción de recibir nuestro boletín o publicidad usted puede cancelarla en cualquier momento.</p>
            <p>Esta compañía no venderá, cederá ni distribuirá la información personal que es recopilada sin su consentimiento, salvo que sea requerido por un juez con un orden judicial.</p>
            <p>Ajax-Kahoot, se reserva el derecho de cambiar los términos de la presente Política de Privacidad en cualquier momento.</p>

            <?php if ($type == "PREMIUM"): ?>
              <div class="alert alert-warning mt-4 mb-0" role="alert">
                <h4 class="font-weight-bold">Aviso!</h4>
                <p>Al crear tu cuenta seleccionaste PREMIUM. Una vez aceptes los términos de servicio, deberás realizar el pago para poder disfrutar de las ventajas PREMIUM.</p>
              </div>
            <?php endif; ?>

          </div>
          </br>
          <h2 class="titleTOS">Aceptas los términos de servicio?</h2>
          <form action="acceptTOS.php" method="post">
            <input type="checkbox" name="TOS"></input>
            <input type="text" value="<?=$token;?>" name="token" style="display: none;"></input>
            <label for="TOS">He leido los términos de servicio y acepto</label>
            <input type="submit" value="Enviar">
          </form>
        </div>
      </div>
    </div>

    <?php if ($type == "PREMIUM"): ?>

    <button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#paymentModal" id="openModal">Open</button>
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLabel">Detalles del pago</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="credit-card-box">
              <div class="display-table mb-2">
                <div class="row display-tr">
                  <h6 class="display-td font-weight-bold">Paga utilizando</h6>
                  <div class="display-td">
                    <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                  </div>
                </div>
              </div>
              <form role="form" id="payment-form">
                <div class="form-group">
                  <label for="nameOnCard">NOMBRE</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="nameOnCard" placeholder="Como aparece en la tarjeta"/>
                  </div>
                </div>
                <div class="form-group">
                  <label for="cardNumber">Nº TARJETA</label>
                  <div class="input-group">
                    <input
                    type="tel"
                    class="form-control"
                    name="cardNumber"
                    placeholder="Número de tarjeta válido"
                    autocomplete="cc-number"
                    required autofocus
                    />
                    <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="cardExpiry">FECHA DE VENCIMIENTO</label>
                    <input
                    type="tel"
                    class="form-control"
                    name="cardExpiry"
                    placeholder="MM / YY"
                    autocomplete="cc-exp"
                    required
                    />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="cardCVC">CVV</label>
                    <input
                    type="tel"
                    class="form-control"
                    name="cardCVV"
                    placeholder="CVV"
                    autocomplete="cc-csc"
                    required
                    />
                  </div>
                </div>
                <div class="form-group" style="display:none;">
                  <div class="col-xs-12">
                    <p class="payment-errors"></p>
                  </div>
                </div>
              </form>
            </div>
            <table class="table table-hover mt-2">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>#</th>
                  <th class="text-center">Precio</th>
                  <th class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="col-md-9"><em>Cuenta PREMIUM en Ajax-Kahoot</em></td>
                  <td class="col-md-1" style="text-align: center"> 1 </td>
                  <td class="col-md-1 text-center">5€</td>
                  <td class="col-md-1 text-center">5€</td>
                </tr>
                <tr>
                  <td> &nbsp; </td>
                  <td> &nbsp; </td>
                  <td class="text-right">
                    <p>
                      <strong>Subtotal:&nbsp;</strong>
                    </p>
                    <p>
                      <strong>IVA:&nbsp;</strong>
                    </p>
                  </td>
                  <td class="text-center">
                    <p>
                      <strong>4.13€</strong>
                    </p>
                    <p>
                      <strong>0.87€</strong>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td> &nbsp; </td>
                  <td> &nbsp; </td>
                  <td class="text-right"><h4><strong>Total:&nbsp;</strong></h4></td>
                  <td class="text-center text-danger"><h4><strong>5€</strong></h4></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#accFreeModal" data-dismiss="modal">Ya no quiero PREMIUM</button>
            <button type="button" class="btn btn-primary" id="payNow">Pagar ahora</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="accFreeModal" tabindex="-1" role="dialog" aria-labelledby="accFreeModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="accFreeModalLabel">Información</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Si continuas, tu cuenta será gratuita y no podrás disfrutar de las ventajas de ser PREMIUM.</p>
            <p>Estás seguro que quieres continuar?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#paymentModal" data-dismiss="modal">Atrás</button>
            <button type="button" class="btn btn-primary" id="btnAccFree">Continuar sin PREMIUM</button>
          </div>
        </div>
      </div>
    </div>

    <form class="d-none" action="acceptTOS.php" method="post" id="formAccFree">
      <input type="text" name="updateAcc" value="<?=$token;?>"></input>
      <input type="submit">
    </form>

  <?php endif; ?>

  </body>
</html>

<?php

  function getConnection() {
    $hostname = "localhost";
    $dbname = "kahoot";
    $username = "admin_kahoot";
    $pw = "P@ssw0rd";
    return new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8;", $username, $pw);
  }

  function tokenExists($token) {
    $pdo = getConnection();
    $query = $pdo->prepare("SELECT token FROM token WHERE token = '$token' and type='TOS' and expired = 0");
    $success = $query->execute();
    if ($success) {
      $row = $query->fetch();
      if (!$row) {
        return $row;
      }
    }
    return $success;
  }

  function updateToken($token) {
    $pdo = getConnection();
    $query = $pdo->prepare("UPDATE token SET expired = 1 WHERE token = '$token'");
    $query->execute();
  }

  function getAccountType($token) {
    $pdo = getConnection();
    $query = $pdo->prepare("SELECT u.user_type FROM users u, token t WHERE u.user_id=t.user_id and t.token = '$token'");
    $query->execute();
    $row = $query->fetch();
    return $row['user_type'];
  }

  function updateAccountType($type, $token) {
    $pdo = getConnection();
    $query = $pdo->prepare("SELECT user_id FROM token WHERE token = '$token'");
    $query->execute();
    $row = $query->fetch();
    $user_id = $row['user_id'];
    $query2 = $pdo->prepare("UPDATE users SET user_type = '$type' WHERE user_id = $user_id");
    $query2->execute();
  }
 ?>
