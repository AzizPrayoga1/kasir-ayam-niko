
<?php
include_once 'koneksi.php';
session_start();
if(isset($_SESSION['level'])){
    header("Location: login.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="icon" type="image/png" href="images/icons/favicon.ico" />

  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css" />

  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css" />

  <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css" />

  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css" />

  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css" />

  <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css" />

  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css" />

  <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css" />

  <link rel="stylesheet" type="text/css" href="css/util.css" />
  <link rel="stylesheet" type="text/css" href="css/main.css" />

  <meta name="robots" content="noindex, follow" />
  <script nonce="f28da082-e656-4798-93c9-59bb3a2fe4e5">
    try {
      (function (w, d) {
        !(function (k, l, m, n) {
          k[m] = k[m] || {};
          k[m].executed = [];
          k.zaraz = { deferred: [], listeners: [] };
          k.zaraz.q = [];
          k.zaraz._f = function (o) {
            return async function () {
              var p = Array.prototype.slice.call(arguments);
              k.zaraz.q.push({ m: o, a: p });
            };
          };
          for (const q of ["track", "set", "debug"])
            k.zaraz[q] = k.zaraz._f(q);
          k.zaraz.init = () => {
            var r = l.getElementsByTagName(n)[0],
              s = l.createElement(n),
              t = l.getElementsByTagName("title")[0];
            t && (k[m].t = l.getElementsByTagName("title")[0].text);
            k[m].x = Math.random();
            k[m].w = k.screen.width;
            k[m].h = k.screen.height;
            k[m].j = k.innerHeight;
            k[m].e = k.innerWidth;
            k[m].l = k.location.href;
            k[m].r = l.referrer;
            k[m].k = k.screen.colorDepth;
            k[m].n = l.characterSet;
            k[m].o = new Date().getTimezoneOffset();
            if (k.dataLayer)
              for (const x of Object.entries(
                Object.entries(dataLayer).reduce(
                  (y, z) => ({ ...y[1], ...z[1] }),
                  {}
                )
              ))
                zaraz.set(x[0], x[1], { scope: "page" });
            k[m].q = [];
            for (; k.zaraz.q.length;) {
              const A = k.zaraz.q.shift();
              k[m].q.push(A);
            }
            s.defer = !0;
            for (const B of [localStorage, sessionStorage])
              Object.keys(B || {})
                .filter((D) => D.startsWith("_zaraz_"))
                .forEach((C) => {
                  try {
                    k[m]["z_" + C.slice(7)] = JSON.parse(B.getItem(C));
                  } catch {
                    k[m]["z_" + C.slice(7)] = B.getItem(C);
                  }
                });
            s.referrerPolicy = "origin";
            s.src =
              "/cdn-cgi/zaraz/s.js?z=" +
              btoa(encodeURIComponent(JSON.stringify(k[m])));
            r.parentNode.insertBefore(s, r);
          };
          ["complete", "interactive"].includes(l.readyState)
            ? zaraz.init()
            : k.addEventListener("DOMContentLoaded", zaraz.init);
        })(w, d, "zarazData", "script");
      })(window, document);
    } catch (e) {
      throw (fetch("/cdn-cgi/zaraz/t"), e);
    }
  </script>
</head>

<body>
<?php include('navbar.php')?>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100 p-t-50 p-b-90">
        <form class="login100-form validate-form flex-sb flex-w" action="login_proses.php" method="post">
          <span class="login100-form-title p-b-51"> Login Kasir Tidak Aman </span>
          <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
            <input class="input100" type="text" name="username" placeholder="Username" />
            <span class="focus-input100"></span>
          </div>
          <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required">
            <input class="input100" type="password" name="password" placeholder="Password" />
            <span class="focus-input100"></span>
          </div>
          <div class="flex-sb-m w-full p-t-3 p-b-24">
          </div>
          <div class="container-login100-form-btn m-t-17">
              <button class="login100-form-btn" type="submit" value="Login" name="login" > Login </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="dropDownSelect1"></div>

  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>

  <script src="vendor/animsition/js/animsition.min.js"></script>

  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="vendor/select2/select2.min.js"></script>

  <script src="vendor/daterangepicker/moment.min.js"></script>
  <script src="vendor/daterangepicker/daterangepicker.js"></script>

  <script src="vendor/countdowntime/countdowntime.js"></script>

  <script src="js/main.js"></script>

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
      dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "UA-23581568-13");
  </script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317"
    integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA=="
    data-cf-beacon='{"rayId":"86e0a292b9de89a4","version":"2024.3.0","token":"cd0b4b3a733644fc843ef0b185f98241"}'
    crossorigin="anonymous"></script>
</body>

</html>

