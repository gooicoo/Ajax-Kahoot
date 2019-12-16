<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["TOS"]) and isset($_POST["token"])) {
    updateToken($_POST["token"]);
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET" and isset($_GET["token"])) {
    $token = $_GET["token"];
    if (!tokenExists($token)) {
      header("Location: .");
    }
  } else {
    header("Location: .");
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Términos de Servicio</title>
    <style>
      body {
        background-color: #41c4de;
        font-family: Times New Roman;
      }

      p {
        font-size: 16px;
      }

      input[type=submit]{
         display: block;
         margin: 0 auto;
         margin-top: 10px;
      }

      h2.titleTOS {
        margin-block-start: 0;
        margin-block-end: 0.5em;
      }

      h2.titleTOS, form {
        text-align: center;
      }

      label {
        font-size: 18px;
      }
    </style>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function(event) {
        var form = document.getElementsByTagName("form")[0];
        form.onsubmit = function() {
          var tos = document.getElementsByName("TOS")[0];
          if (!tos.checked) {
            alert("Debes aceptar los términos de servicio para poder utilizar nuestra web.");
            return false;
          }
          return true;
        };
      });
    </script>
  </head>
  <body>
    <div class="main">
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
 ?>
